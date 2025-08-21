<?php

namespace Database\Seeders;
use App\Models\FamilyClass;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = ['Lower Middle', 'Middle Class', 'Upper Middle', 'Upper Class','Elite'];

        foreach ($classes as $class) {
            FamilyClass::create(['name' => $class]);
        }
    }
}
