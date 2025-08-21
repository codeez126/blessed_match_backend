<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPlan extends Model
{
    use HasFactory;

    // Plan status constants
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_EXPIRED = 2;
    const STATUS_CANCELED = 3;

    protected $fillable = [
        'user_id',
        'payment_plan_id',
        'status',
        'expired_at',
        'started_at',
        'canceled_at',
        'cancellation_reason',
        'auto_renew'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'started_at' => 'datetime',
        'canceled_at' => 'datetime',
        'auto_renew' => 'boolean',
    ];

    /**
     * Get the user that owns the plan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment plan details.
     */
    public function paymentPlan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class);
    }

    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope a query to only include expired plans.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', self::STATUS_EXPIRED);
    }

    /**
     * Check if the plan is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the plan is expired.
     */
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED ||
            ($this->expired_at && $this->expired_at->isPast());
    }

    /**
     * Check if the plan will expire soon (within 7 days).
     */
    public function willExpireSoon(): bool
    {
        return $this->expired_at &&
            $this->expired_at->isFuture() &&
            $this->expired_at->diffInDays(now()) <= 7;
    }

    /**
     * Get the remaining days of the plan.
     */
    public function remainingDays(): int
    {
        if (!$this->expired_at || $this->expired_at->isPast()) {
            return 0;
        }

        return $this->expired_at->diffInDays(now());
    }

    /**
     * Activate the plan.
     */
    public function activate(): void
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'started_at' => now(),
            'canceled_at' => null
        ]);
    }

    /**
     * Cancel the plan.
     */
    public function cancel(string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_CANCELED,
            'canceled_at' => now(),
            'cancellation_reason' => $reason,
            'auto_renew' => false
        ]);
    }

    /**
     * Mark the plan as expired.
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }
}
