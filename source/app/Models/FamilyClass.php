<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyClass extends Model
{

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
    public function clientFamilyInfos()
    {
        return $this->hasMany(ClientFamilyInfo::class);
    }

}
