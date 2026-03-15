<?php

namespace App\Services;

use App\Models\SessionAnalytic;
use Illuminate\Support\Facades\Cache;

class SessionSecurityService
{
    /**
     * Detect potential session hijacking
     */
    public function detectSuspiciousActivity(string $sessionId, string $currentIp, string $currentUserAgent): bool
    {
        $session = SessionAnalytic::where('session_id', $sessionId)->first();
        
        if (!$session) {
            return false;
        }

        $suspicious = false;

        // Skip checks for localhost/development IPs
        $localhostIps = ['127.0.0.1', '::1', 'localhost'];
        if (in_array($currentIp, $localhostIps) || in_array($session->ip_address, $localhostIps)) {
            return false;
        }

        // Only flag IP changes if they're from completely different networks
        // Allow minor IP changes (same subnet) which can happen with mobile networks or load balancers
        if ($session->ip_address !== $currentIp) {
            // Extract first 3 octets for IPv4 comparison (same subnet check)
            $sessionIpParts = explode('.', $session->ip_address);
            $currentIpParts = explode('.', $currentIp);
            
            // Only flag if first 2 octets are different (different network)
            if (count($sessionIpParts) >= 2 && count($currentIpParts) >= 2) {
                if ($sessionIpParts[0] !== $currentIpParts[0] || $sessionIpParts[1] !== $currentIpParts[1]) {
                    $suspicious = true;
                }
            }
        }

        // Don't flag user agent changes - browsers update, extensions modify UA strings
        // Only flag if user agent is completely missing or drastically different (different browser family)
        // This is too strict for normal use, so we'll skip it
        // if ($session->user_agent !== $currentUserAgent) {
        //     $suspicious = true;
        // }

        // Check for unusual activity patterns
        if ($this->hasUnusualActivityPattern($session)) {
            $suspicious = true;
        }

        if ($suspicious) {
            $session->update(['is_suspicious' => true]);
        }

        return $suspicious;
    }

    /**
     * Check for unusual activity patterns
     */
    protected function hasUnusualActivityPattern(SessionAnalytic $session): bool
    {
        // Check for too many page views in short time (potential bot)
        // Increased threshold to be more lenient - 200 views in less than 2 minutes is suspicious
        if ($session->total_page_views > 200 && $session->session_duration < 120) {
            return true;
        }

        return false;
    }

    /**
     * Rate limiting for session
     */
    public function checkRateLimit(string $sessionId): bool
    {
        $key = "session_rate_limit:{$sessionId}";
        $requests = Cache::get($key, 0);

        if ($requests > 100) { // 100 requests per minute
            return false;
        }

        Cache::put($key, $requests + 1, 60);
        return true;
    }

    /**
     * Validate session integrity
     */
    public function validateSession(string $sessionId, array $sessionData): bool
    {
        // Check if session has required data
        if (!isset($sessionData['user_id'])) {
            return false;
        }

        // Check if session is not expired
        if (isset($sessionData['last_accessed_at'])) {
            $lastAccess = \Carbon\Carbon::parse($sessionData['last_accessed_at']);
            if ($lastAccess->diffInHours(now()) > 24) {
                return false;
            }
        }

        return true;
    }
}
