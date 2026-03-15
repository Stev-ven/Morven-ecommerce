<?php

namespace App\Http\Middleware;

use App\Models\SessionAnalytic;
use App\Models\AbandonedCart;
use App\Models\UserPreference;
use App\Services\SessionSecurityService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackSessionDetails
{
    protected SessionSecurityService $securityService;

    public function __construct(SessionSecurityService $securityService)
    {
        $this->securityService = $securityService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Generate unique user ID if not exists
        if (!Session::has('user_id')) {
            Session::put('user_id', uniqid('user_', true));
        }

        // 2. Verify authenticated user still exists
        if (Auth::check()) {
            $userExists = \App\Models\User::where('id', Auth::id())->exists();
            if (!$userExists) {
                // User was deleted, logout and clear session
                Auth::logout();
                Session::flush();
                Session::regenerate();
                return redirect()->route('home')->with('info', 'Your session has expired. Please log in again.');
            }
        }

        $userId = Session::get('user_id');
        $sessionId = Session::getId();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $currentUrl = $request->fullUrl();

        // 2. Detect and prevent session hijacking
        // Skip security check for payment callback routes to avoid false positives
        $isPaymentCallback = $request->is('payment/callback*') || $request->is('order/success*');
        
        if (!$isPaymentCallback && $this->securityService->detectSuspiciousActivity($sessionId, $ipAddress, $userAgent)) {
            // Log suspicious activity
            \Log::warning('Suspicious session activity detected', [
                'session_id' => $sessionId,
                'user_id' => $userId,
                'ip' => $ipAddress,
            ]);
            
            // Note: We only log, we don't block. To block, uncomment below:
            // Session::flush();
            // return redirect()->route('home')->with('error', 'Session security issue detected');
        }

        // 3. Rate limiting
        if (!$this->securityService->checkRateLimit($sessionId)) {
            return response('Too many requests', 429);
        }

        // 4. Track session analytics and page views
        $this->trackSessionAnalytics($sessionId, $userId, $request);

        // 5. Track abandoned carts
        $this->trackAbandonedCart($sessionId, $userId);

        // 6. Initialize or update user preferences
        $this->initializeUserPreferences($userId);

        // 7. Associate guest cart with authenticated user
        if (Auth::check()) {
            $this->associateGuestCartWithUser($userId, Auth::id());
        }

        // 8. Update session details
        Session::put('session_details', [
            'user_id' => $userId,
            'last_accessed_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'current_page' => $currentUrl,
        ]);

        return $next($request);
    }

    /**
     * Track session analytics and page views
     */
    protected function trackSessionAnalytics(string $sessionId, string $userId, Request $request): void
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        // Get auth user ID, but verify user still exists
        $authUserId = Auth::id();
        if ($authUserId) {
            $userExists = \App\Models\User::where('id', $authUserId)->exists();
            if (!$userExists) {
                // User was deleted, logout and clear auth
                Auth::logout();
                $authUserId = null;
            }
        }

        $sessionAnalytic = SessionAnalytic::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => $userId,
                'auth_user_id' => $authUserId,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referrer' => $request->header('referer'),
                'first_visit_at' => now(),
                'last_activity_at' => now(),
                'device_type' => $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop'),
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
            ]
        );

        // Add page view
        $sessionAnalytic->addPageView($request->fullUrl());
        $sessionAnalytic->updateSessionDuration();
    }

    /**
     * Track abandoned carts
     */
    protected function trackAbandonedCart(string $sessionId, string $userId): void
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return;
        }

        // Verify auth user exists if logged in
        $authUserId = Auth::id();
        if ($authUserId) {
            $userExists = \App\Models\User::where('id', $authUserId)->exists();
            if (!$userExists) {
                Auth::logout();
                $authUserId = null;
            }
        }

        $cartTotal = collect($cart)->sum('subtotal');
        $itemsCount = collect($cart)->sum('qty');

        // Check if cart was abandoned (no activity for 30 minutes)
        $lastActivity = Session::get('session_details.last_accessed_at');
        if ($lastActivity && now()->diffInMinutes($lastActivity) >= 30) {
            AbandonedCart::updateOrCreate(
                [
                    'session_id' => $sessionId,
                    'user_id' => $userId,
                    'status' => 'abandoned',
                ],
                [
                    'auth_user_id' => $authUserId,
                    'email' => $authUserId ? Auth::user()->email : null,
                    'cart_data' => $cart,
                    'cart_total' => $cartTotal,
                    'items_count' => $itemsCount,
                    'delivery_option' => Session::get('delivery_option'),
                    'abandoned_at' => now(),
                ]
            );
        }
    }

    /**
     * Initialize or update user preferences
     */
    protected function initializeUserPreferences(string $userId): void
    {
        // Verify auth user exists if logged in
        $authUserId = Auth::id();
        if ($authUserId) {
            $userExists = \App\Models\User::where('id', $authUserId)->exists();
            if (!$userExists) {
                Auth::logout();
                $authUserId = null;
            }
        }

        UserPreference::firstOrCreate(
            ['user_id' => $userId],
            [
                'auth_user_id' => $authUserId,
                'preferred_language' => app()->getLocale(),
                'preferred_currency' => 'GHS',
            ]
        );
    }

    /**
     * Associate guest cart with authenticated user
     */
    protected function associateGuestCartWithUser(string $guestUserId, int $authUserId): void
    {
        // Update session analytics
        SessionAnalytic::where('user_id', $guestUserId)
            ->whereNull('auth_user_id')
            ->update(['auth_user_id' => $authUserId]);

        // Update abandoned carts
        AbandonedCart::where('user_id', $guestUserId)
            ->whereNull('auth_user_id')
            ->update([
                'auth_user_id' => $authUserId,
                'email' => Auth::user()->email,
            ]);

        // Update user preferences
        UserPreference::where('user_id', $guestUserId)
            ->whereNull('auth_user_id')
            ->update(['auth_user_id' => $authUserId]);

        // Optionally: Merge guest cart with user's existing cart
        // This would require additional logic in CartService
    }
}
