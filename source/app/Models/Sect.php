<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sect extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'religion_id'];

    // Relationship with the Religion model
    public function religion()
    {
        return $this->belongsTo(Religion::class); // Each sect belongs to one religion
    }
}
