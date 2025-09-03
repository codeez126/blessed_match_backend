<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Preference;

class PreferenceSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'ClientAge', //not model
            'ClientHeight', //not model
            'ClientWeight', //not model
            'MonthlySalary', //not model
            'MaritalStatus', //Model
            'Nationality', //Model
            'City', //Model
            'FamilyClass', //Model
            'HouseStatus', //Model
            'HouseSize', //Model
            'Occupation', //Model
            'Education', //Model
            'EmploymentStatus', //Model
            'Religion', //Model
            'Sect', //Model
            'Cast', //Model
        ];

        foreach ($names as $name) {
            Preference::create(['name' => $name]);
        }
    }
}
