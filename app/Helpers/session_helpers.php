<?php

use App\Models\UserPreference;
use App\Models\SessionAnalytic;

if (!function_exists('user_preferences')) {
    /**
     * Get user preferences for current session
     */
    function user_preferences(): ?UserPreference
    {
        $userId = session('user_id');
        if (!$userId) {
            return null;
        }

        return UserPreference::where('user_id', $userId)->first();
    }
}

if (!function_exists('track_product_view')) {
    /**
     * Track product view in user preferences
     */
    function track_product_view(int $productId): void
    {
        $preferences = user_preferences();
        if ($preferences) {
            $preferences->addRecentlyViewed($productId);
        }
    }
}

if (!function_exists('track_search')) {
    /**
     * Track search term in user preferences
     */
    function track_search(string $term): void
    {
        $preferences = user_preferences();
        if ($preferences) {
            $preferences->addSearchTerm($term);
        }
    }
}

if (!function_exists('session_analytics')) {
    /**
     * Get session analytics for current session
     */
    function session_analytics(): ?SessionAnalytic
    {
        $sessionId = session()->getId();
        return SessionAnalytic::where('session_id', $sessionId)->first();
    }
}
