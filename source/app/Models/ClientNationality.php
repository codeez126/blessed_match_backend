<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientNationality extends Model
{
    protected $fillable = [
        'user_id',
        'nationality_id',
        'platform',
        'region',
    ];
}
