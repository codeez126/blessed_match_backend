<?php

namespace Database\Seeders;

use App\Models\OfficeType;
use Illuminate\Database\Seeder;

class OfficeTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Home'],
            ['name' => 'Office'],
            ['name' => 'Virtual'],
        ];

        foreach ($types as $type) {
            OfficeType::create($type);
        }
    }
}
