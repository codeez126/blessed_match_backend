<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAudioInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'onboarding_1',
        'onboarding_2',
        'onboarding_3',
        'onboarding_4',
        'onboarding_5',
        'onboarding_6',
        'onboarding_7',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
