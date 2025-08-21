<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_type',
        'payment_logo',
        'account_title',
        'account_no',
        'account_iban',
        'status',
        'sort_order',
        'description'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
