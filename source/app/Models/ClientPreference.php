<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPreference extends Model
{
    protected $fillable = ['user_id', 'preference_type', 'type_id', 'min_value', 'max_value'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preference(): BelongsTo
    {
        return $this->belongsTo(Preference::class, 'preference_type');
    }

    public function typeModel(): BelongsTo
    {
        if (!$this->preference) {
            return $this->belongsTo(Preference::class, 'type_id')->whereRaw('0=1');
        }

        $map = [
            'MaritalStatus'     => \App\Models\MaritalStatus::class,
            'Nationality'       => \App\Models\Nationality::class,
            'City'              => \App\Models\City::class,
            'FamilyClass'       => \App\Models\FamilyClass::class,
            'HouseStatus'       => \App\Models\HouseStatus::class,
            'HouseSize'         => \App\Models\HouseSize::class,
            'Occupation'        => \App\Models\Occupation::class,
            'Education'         => \App\Models\Education::class,
            'EmploymentStatus'  => \App\Models\EmploymentStatus::class,
            'Religion'          => \App\Models\Religion::class,
            'Sect'              => \App\Models\Sect::class,
            'Cast'              => \App\Models\Cast::class,
        ];

        $modelName = $map[$this->preference->name] ?? null;

        return $modelName
            ? $this->belongsTo($modelName, 'type_id')
            : $this->belongsTo(Preference::class, 'type_id')->whereRaw('0=1');
    }


    public function getTypeModelAttribute()
    {
        if (!$this->preference || !$this->type_id) {
            return null;
        }

        $map = [
            'MaritalStatus'     => \App\Models\MaritalStatus::class,
            'Nationality'       => \App\Models\Nationality::class,
            'City'              => \App\Models\City::class,
            'FamilyClass'       => \App\Models\FamilyClass::class,
            'HouseStatus'       => \App\Models\HouseStatus::class,
            'HouseSize'         => \App\Models\HouseSize::class,
            'Occupation'        => \App\Models\Occupation::class,
            'Education'         => \App\Models\Education::class,
            'EmploymentStatus'  => \App\Models\EmploymentStatus::class,
            'Religion'          => \App\Models\Religion::class,
            'Sect'              => \App\Models\Sect::class,
            'Cast'              => \App\Models\Cast::class,
        ];

        $modelName = $map[$this->preference->name] ?? null;

        return $modelName
            ? $modelName::find($this->type_id)
            : null;
    }
}
