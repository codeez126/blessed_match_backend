<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HouseStatus;

class HouseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $statuses = ['Own', 'Rent', 'Government'];

        $statuses = [
            'Own House',
            'Rent',
            'Government Accommodation',
            'Family House (Joint Family)',
            'Separate Portion in Family House',
            'Living Abroad',
            'Company Provided Housing',
            'Farmhouse / Agricultural Land',
            'Flat / Apartment',
            'Under Construction (Future Home)',
            'Living with Relatives',
            'Military / Armed Forces Accommodation',
            'Shared Apartment / Roommate',
            'Migratory (Temporary Residence)'
        ];

        foreach ($statuses as $status) {
            HouseStatus::create(['name' => $status]);
        }
    }

}
