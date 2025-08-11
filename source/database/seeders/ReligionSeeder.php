<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    public function run()
    {
        // Insert religions
        $religions = [
            'Islam',
            'Christianity',
            'Hinduism',
            'Sikhism',
            'Other'
        ];

        foreach ($religions as $religion) {
            Religion::create([
                'name' => $religion
            ]);
        }
    }
}

