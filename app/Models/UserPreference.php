<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'auth_user_id',
        'preferred_language',
        'preferred_currency',
        'favorite_categories',
        'recently_viewed',
        'search_history',
        'email_notifications',
        'sms_notifications',
        'theme',
        'custom_settings',
    ];

    protected $casts = [
        'favorite_categories' => 'array',
        'recently_viewed' => 'array',
        'search_history' => 'array',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'custom_settings' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }

    public function addRecentlyViewed(int $productId): void
    {
        $recentlyViewed = $this->recently_viewed ?? [];
        
        // Remove if already exists
        $recentlyViewed = array_filter($recentlyViewed, fn($id) => $id !== $productId);
        
        // Add to beginning
        array_unshift($recentlyViewed, $productId);
        
        // Keep only last 20
        $recentlyViewed = array_slice($recentlyViewed, 0, 20);
        
        $this->update(['recently_viewed' => $recentlyViewed]);
    }

    public function addSearchTerm(string $term): void
    {
        $searchHistory = $this->search_history ?? [];
        
        $searchHistory[] = [
            'term' => $term,
            'timestamp' => now()->toISOString(),
        ];
        
        // Keep only last 50 searches
        $searchHistory = array_slice($searchHistory, -50);
        
        $this->update(['search_history' => $searchHistory]);
    }
}
