<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['name' => 'Urdu', 'code' => 'ur'],
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Punjabi', 'code' => 'pa'],
            ['name' => 'Pashto', 'code' => 'ps'],
            ['name' => 'Sindhi', 'code' => 'sd'],
            ['name' => 'Balochi', 'code' => 'bc'],
            ['name' => 'Saraiki', 'code' => 'skr'],
            ['name' => 'Kashmiri', 'code' => 'ks'],
            ['name' => 'Brahui', 'code' => 'br'],
            ['name' => 'Hindko', 'code' => 'hnd'],
            ['name' => 'Shina', 'code' => 'shn'],
            ['name' => 'Khowar', 'code' => 'khw'],
            ['name' => 'Balti', 'code' => 'bt'],
            ['name' => 'Makrani', 'code' => 'mk'],
            ['name' => 'Wakhi', 'code' => 'wkh'],
            ['name' => 'Gujarati', 'code' => 'gu'],
            ['name' => 'Balochi (Makrani)', 'code' => 'bmk'],
            ['name' => 'Dari', 'code' => 'fa'],
        ];

        foreach ($languages as $language) {
            Language::create([
                'name' => $language['name'],
                'code' => $language['code']
            ]);
        }
    }
}
