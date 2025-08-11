<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name'];

    public function casts()
    {
        return $this->hasMany(Cast::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function sects()
    {
        return $this->hasMany(Sect::class); // One religion can have many sects
    }
}
