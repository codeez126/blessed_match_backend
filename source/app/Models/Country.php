<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

}
