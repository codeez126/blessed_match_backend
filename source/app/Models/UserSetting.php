<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'is_notifiable',
        'dark_theme',
        'language',
        'show_online_status',
        'receive_promotions',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

