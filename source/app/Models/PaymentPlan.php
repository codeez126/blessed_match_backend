<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_days',
        'image',
        'features',
        'is_popular',
        'max_usage_limit',
        'is_active',
        'sort_order',
        'currency',
        'trial_days'
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }
    public function variations()
    {
        return $this->hasMany(PaymentPlanVariation::class);
    }
    /**
     * Scope a query to only include active plans.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include popular plans.
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Get the daily price of the plan.
     */
    public function getDailyPriceAttribute()
    {
        if ($this->duration_days > 0) {
            return $this->price / $this->duration_days;
        }

        return $this->price;
    }

    /**
     * Check if the plan has a trial period.
     */
    public function hasTrial()
    {
        return $this->trial_days > 0;
    }
}
