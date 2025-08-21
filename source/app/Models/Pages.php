<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    protected $table='pages';
    const CREATED_AT = 'created_at';
    const UPDATED_AT  = 'updated_at';
    protected $fillable=[

        'page_name',
        'page_url',
        'page_heading',
        'page_content',
        'page_content2',
        'page_banner',
        'page_banner_alt',


        'status',
        'is_index',
        'not_domain_specific',
        'text_direction_right',
        'lang_he',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

}
