<?php

namespace Database\Seeders;

use App\Models\HouseSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['name' => '3 Marla', 'marla' => 3],
            ['name' => '5 Marla', 'marla' => 5],
            ['name' => '7 Marla', 'marla' => 7],
            ['name' => '10 Marla', 'marla' => 10],
            ['name' => '1 Kanal', 'marla' => 20],
        ];

        foreach ($sizes as $size) {
            HouseSize::create($size);
        }
    }
}
