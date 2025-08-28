<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientIslamicValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'religion_id',
        'sect_id',
        'cast_id',
        'sub_cast_name',
        'prayer_frequency',
        'is_where_hijab',
        'is_where_nikab',
        'is_have_beared',
        'quran_memorization',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function sect()
    {
        return $this->belongsTo(Sect::class);
    }

    public function cast()
    {
        return $this->belongsTo(Cast::class, 'cast_id');
    }


}
