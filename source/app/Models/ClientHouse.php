<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientHouse extends Model
{
    protected $fillable = [
        'user_id',
        'province_id',
        'city_id',
        'area_id',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}

