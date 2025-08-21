<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfileAvg extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'onboarding1',
        'onboarding2',
        'onboarding3',
        'onboarding4',
        'onboarding5',
        'onboarding6',
        'total_avg',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
