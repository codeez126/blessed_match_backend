<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'educations';  // Ensure it's plural

    protected $fillable = ['name', 'level'];
    public function clientProfessions()
    {
        return $this->hasMany(ClientProfession::class);
    }
}
