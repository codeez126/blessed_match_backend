<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = [
        'user_id',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'file_mime',
        'file_thumbnail',
        'audio_duration',
        'mediaable_type',
        'mediaable_id'
    ];
}
