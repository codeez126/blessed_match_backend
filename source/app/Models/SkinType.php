<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkinType extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'label',
        'color_code',
    ];
    public function clientLifeStyles()
    {
        return $this->hasMany(ClientLifeStyle::class, 'skin_color_id');
    }

}
