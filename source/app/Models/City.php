<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'province_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function areas()
    {
        return $this->hasMany(Area::class);
    }


}
