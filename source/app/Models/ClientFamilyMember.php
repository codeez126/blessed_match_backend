<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'full_name',
        'age',
        'gender',
        'martial_status',
        'description',
        'designation',
        'guardian_info',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
