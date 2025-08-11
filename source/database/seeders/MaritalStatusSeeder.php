<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Single',
            'Married',
            'Divorced',
            'Separated',
            'Widowed',
            'Khula',
            'Faskh-e-Nikah',
            'Engaged (To be Married)',
            'Divorcee (with Iddah Period)',
            'Widow/Widower',
            'Second Marriage (Already Married)',

        ];
        foreach ($statuses as $status) {
            MaritalStatus::create(['name' => $status]);
        }
    }
}
