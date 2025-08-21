<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseStatus extends Model
{
    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
    public function clientBackgrounds()
    {
        return $this->hasMany(ClientBackground::class, 'house_status_id');
    }


}

