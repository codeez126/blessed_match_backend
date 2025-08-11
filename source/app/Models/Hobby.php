<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'type',
        'main_hobby_id',
        'name',
        'emoji',
        'color'
    ];
    protected $with = ['subHobbies']; // Optional: always eager load

    public function mainHobby()
    {
        return $this->belongsTo(Hobby::class, 'main_hobby_id');
    }

    public function subHobbies()
    {
        return $this->hasMany(self::class, 'main_hobby_id')->where('type', 1);
    }
    public function associatedHobbies()
    {
        return $this->hasMany(Hobby::class, 'main_hobby_id');
    }

}
