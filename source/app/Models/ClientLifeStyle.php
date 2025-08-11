<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLifeStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'skin_color',
        'hair',
        'disability',
        'disability_details',
        'health_issue',
        'health_issue_details',
        'is_smoking',
        'is_alcoholic',
        'is_tobaco_habit',
        'willing_to_relocate',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
