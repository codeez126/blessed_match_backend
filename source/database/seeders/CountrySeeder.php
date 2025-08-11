<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $country = Country::create(['name' => 'Pakistan']);

        $provinces = ['Punjab', 'Sindh', 'Khyber Pakhtunkhwa', 'Balochistan', 'Gilgit-Baltistan', 'Azad Kashmir', 'Islamabad Capital Territory'];

        foreach ($provinces as $province) {
            \App\Models\Province::create([
                'name' => $province,
                'country_id' => $country->id,
            ]);
        }    }

}
