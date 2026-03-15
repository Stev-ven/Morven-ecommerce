<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbandonedCart extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'auth_user_id',
        'email',
        'cart_data',
        'cart_total',
        'items_count',
        'delivery_option',
        'abandoned_at',
        'recovered_at',
        'recovery_email_sent',
        'recovery_email_sent_at',
        'status',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'cart_total' => 'decimal:2',
        'abandoned_at' => 'datetime',
        'recovered_at' => 'datetime',
        'recovery_email_sent' => 'boolean',
        'recovery_email_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }

    public function markAsRecovered(): void
    {
        $this->update([
            'status' => 'recovered',
            'recovered_at' => now(),
        ]);
    }

    public function markRecoveryEmailSent(): void
    {
        $this->update([
            'recovery_email_sent' => true,
            'recovery_email_sent_at' => now(),
        ]);
    }

    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned');
    }

    public function scopeRecent($query, $hours = 24)
    {
        return $query->where('abandoned_at', '>=', now()->subHours($hours));
    }
}
