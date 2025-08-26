<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPayment extends Model
{
    use HasFactory;

    // Payment type constants
    const TYPE_PLAN_PURCHASE = 1;
    const TYPE_OTHER_PAYMENT = 2;

    // Payment status constants
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_FAILED = 2;
    const STATUS_REFUNDED = 3;
    const STATUS_REJECTED = 4;

    // Payment method constants
    const METHOD_CARD = 0;
    const METHOD_PAYPAL = 1;
    const METHOD_BANK_TRANSFER = 2;
    const METHOD_STRIPE = 3;
    const METHOD_CASH = 4;

    protected $fillable = [
        'user_id',
        'type',
        'type_id',
        'variation_id',
        'amount',
        'currency',
        'payment_method',
        'payment_proof',
        'transaction_id',
        'user_note',
        'admin_note',
        'status',
        'payment_details',
        'paid_at',
        'refunded_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    /**
     * Get the user that made the payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function paymentPlan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class, 'type_id');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(PaymentPlanVariation::class, 'variation_id');
    }

    /**
     * Scope a query to only include plan purchase payments.
     */
    public function scopePlanPurchases($query)
    {
        return $query->where('type', self::TYPE_PLAN_PURCHASE);
    }

    /**
     * Scope a query to only include other payments.
     */
    public function scopeOtherPayments($query)
    {
        return $query->where('type', self::TYPE_OTHER_PAYMENT);
    }

    /**
     * Scope a query to only include completed payments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Check if the payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the payment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the payment is failed.
     */
    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if the payment is refunded.
     */
    public function isRefunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    /**
     * Mark payment as completed.
     */
    public function markAsCompleted(string $transactionId = null, array $details = null): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'transaction_id' => $transactionId ?? $this->transaction_id,
            'payment_details' => $details ?? $this->payment_details,
            'paid_at' => now()
        ]);
    }

    /**
     * Mark payment as failed.
     */
    public function markAsFailed(string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'admin_note' => $reason ? ($this->admin_note ? $this->admin_note . ' | ' . $reason : $reason) : $this->admin_note
        ]);
    }

    /**
     * Mark payment as refunded.
     */
    public function markAsRefunded(string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_REFUNDED,
            'refunded_at' => now(),
            'admin_note' => $reason ? ($this->admin_note ? $this->admin_note . ' | Refund: ' . $reason : 'Refund: ' . $reason) : $this->admin_note
        ]);
    }

    /**
     * Get payment type as string.
     */
    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_PLAN_PURCHASE => 'Plan Purchase',
            self::TYPE_OTHER_PAYMENT => 'Other Payment',
            default => 'Unknown',
        };
    }

    /**
     * Get payment status as string.
     */
    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_REFUNDED => 'Refunded',
            default => 'Unknown',
        };
    }
    public function getTypeIdNameAttribute()
    {
        $methods = [
            self::METHOD_CARD => 'Card',
            self::METHOD_PAYPAL => 'PayPal',
            self::METHOD_BANK_TRANSFER => 'Bank Transfer',
            self::METHOD_STRIPE => 'Stripe',
            self::METHOD_CASH => 'Cash',
        ];

        return $methods[$this->type_id] ?? 'Unknown';
    }

    /**
     * Get formatted amount with currency.
     */
}
