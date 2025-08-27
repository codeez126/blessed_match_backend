<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permanent_address',
        'current_address',
        'house_status_id',
        'house_size',
        'background_description',

        'province',
        'city',
        'area',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function houseStatus()
    {
        return $this->belongsTo(HouseStatus::class, 'house_status_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function cityRelation()
    {
        return $this->belongsTo(City::class, 'city');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area');
    }
}

