<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeaderinfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('headerinfo')->insert([
            'logo1' => 'logo1.png',
            'logo2' => 'logo2.png',
            'logo1alt' => 'Logo 1 Alt Text',
            'logo2alt' => 'Logo 2 Alt Text',
            'siteName' => 'Blessed Match',
            'siteUrl' => 'https://www.blessedmatch.com',
            'siteEmail' => 'contact@blessedmatch.com',
            'sitePhone' => '+1234567890',
            'address' => '123 Blessed Street, City, Country',
            'themecolor1' => '#ff5733',
            'themecolor2' => '#33ff57',
            'themecolor3' => '#3357ff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
