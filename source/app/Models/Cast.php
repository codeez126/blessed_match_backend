<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['name', 'religion_id'];

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
    public function subcasts()
    {
        return $this->hasMany(Subcast::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
