<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'client_nationalities');
    }


}
