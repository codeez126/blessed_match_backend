<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAbout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_image',
        'full_name',
        'dob',
        'gender',
        'marital_status_id',
        'profile_managed_by',
        'status',
        'reason_txt',
        'client_contact',
        'cnic',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

}
