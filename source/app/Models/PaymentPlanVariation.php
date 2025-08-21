<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPlanVariation extends Model
{
    protected $fillable = [
        'payment_plan_id',
        'type',
        'duration_days',
        'price',
    ];

    public function paymentPlan()
    {
        return $this->belongsTo(PaymentPlan::class);
    }
}
