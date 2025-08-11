<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBusiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'business_name',
        'grade',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
