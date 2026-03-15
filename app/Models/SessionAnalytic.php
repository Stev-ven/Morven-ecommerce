<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionAnalytic extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'auth_user_id',
        'ip_address',
        'user_agent',
        'current_page',
        'referrer',
        'page_views',
        'total_page_views',
        'first_visit_at',
        'last_activity_at',
        'session_duration',
        'is_suspicious',
        'device_type',
        'browser',
        'platform',
    ];

    protected $casts = [
        'page_views' => 'array',
        'first_visit_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'is_suspicious' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }

    public function addPageView(string $url): void
    {
        $pageViews = $this->page_views ?? [];
        $pageViews[] = [
            'url' => $url,
            'timestamp' => now()->toISOString(),
        ];
        
        $this->update([
            'page_views' => $pageViews,
            'total_page_views' => count($pageViews),
            'current_page' => $url,
            'last_activity_at' => now(),
        ]);
    }

    public function updateSessionDuration(): void
    {
        if ($this->first_visit_at) {
            $this->update([
                'session_duration' => now()->diffInSeconds($this->first_visit_at),
            ]);
        }
    }
}
