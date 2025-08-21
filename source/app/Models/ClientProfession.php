<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'occupation',
        'occupation_grade',
        'education_id',
        'employment_status_id',
        'avg_income',
        'platform',
        'region',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
    public function occupation()
    {
        return $this->belongsTo(Occupation::class, 'occupation');
    } public function occupationRelation()
    {
        return $this->belongsTo(Occupation::class, 'occupation');
    }
    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class);
    }


}
