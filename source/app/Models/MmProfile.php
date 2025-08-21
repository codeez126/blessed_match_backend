<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'business_name',
        'business_card',
        'gender_id',
        'dob',
        'experience_years',
        'latitude',
        'longitude',
        'address',
        'office_type_id',
        'my_refral_code',
        'business_email',
        'business_contact',
        'is_registered',
        'subscription',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }


}
