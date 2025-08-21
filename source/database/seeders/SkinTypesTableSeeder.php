<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinType;

class SkinTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skinTones = [
            ['label' => 'Fair', 'color_code' => '#FDEFD4'],
            ['label' => 'Light Wheatish', 'color_code' => '#E7CCAE'],
            ['label' => 'Medium Wheatish', 'color_code' => '#EEBC99'],
            ['label' => 'Olive', 'color_code' => '#D8A37B'],
            ['label' => 'Tan/Brown', 'color_code' => '#BF836B'],
            ['label' => 'Deep Brown', 'color_code' => '#88563D'],
        ];

        foreach ($skinTones as $tone) {
            SkinType::create([
                'label' => $tone['label'],
                'color_code' => $tone['color_code'],
            ]);
        }
    }
}
