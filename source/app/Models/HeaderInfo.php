<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderInfo extends Model
{
    use HasFactory;
    protected $table='headerinfo';
    const CREATED_AT = 'created_at';
    const UPDATED_AT  = 'updated_at';
    protected $fillable=[
        'logo1',
        'logo2',
        'logo1alt',
        'logo2alt',
        'siteName',
        'siteUrl',
        'siteEmail',
        'sitePhone',
        'address',
        'themecolor1',
        'themecolor2',
        'themecolor3',
    ];
}
