<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientFamilyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'father_occupation',
        'mother_occupation',
        'family_class_id',
        'is_father_alive',
        'is_mother_alive',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function familyClass()
    {
        return $this->belongsTo(FamilyClass::class);
    }

}
