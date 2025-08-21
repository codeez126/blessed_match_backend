<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sect;
use App\Models\Religion;

class SectSeeder extends Seeder
{
    public function run()
    {
        // Get the religion IDs from the database
        $islam = Religion::where('name', 'Islam')->first();
        $hinduism = Religion::where('name', 'Hinduism')->first();
        $christianity = Religion::where('name', 'Christianity')->first();
        $sikhism = Religion::where('name', 'Sikhism')->first();

        // Insert sects for Islam
        $sects = [
            // Major Sects
            ['name' => 'Ahle Sunnat ', 'religion_id' => $islam->id],
            ['name' => 'Deobandi', 'religion_id' => $islam->id],
            ['name' => 'Barelvi', 'religion_id' => $islam->id],
            ['name' => 'Ahl-e-Hadith', 'religion_id' => $islam->id],
            ['name' => 'Shia', 'religion_id' => $islam->id],
            ['name' => 'other', 'religion_id' => $islam->id],
 ];


        // Insert sects for Hinduism (sub-castes or communities, not strictly sects)
        $sects[] = ['name' => 'Dalit', 'religion_id' => $hinduism->id];
        $sects[] = ['name' => 'Brahmin', 'religion_id' => $hinduism->id];
        $sects[] = ['name' => 'Vaishya', 'religion_id' => $hinduism->id];
        $sects[] = ['name' => 'Kshatriya', 'religion_id' => $hinduism->id];
        $sects[] = ['name' => 'other', 'religion_id' => $hinduism->id];

        // Insert sects for Christianity
        $sects[] = ['name' => 'Catholic', 'religion_id' => $christianity->id];
        $sects[] = ['name' => 'Protestant', 'religion_id' => $christianity->id];
        $sects[] = ['name' => 'Orthodox', 'religion_id' => $christianity->id];
        $sects[] = ['name' => 'other', 'religion_id' => $christianity->id];

/////////////////////////sikh/////////////////////
        $sects[] = ['name' => 'Khalsa Sikhs', 'religion_id' => $sikhism->id];
        $sects[] = ['name' => 'Nanakpanthi Sikhs', 'religion_id' => $sikhism->id];
        $sects[] = ['name' => 'Nirmala Sikhs', 'religion_id' => $sikhism->id];
        $sects[] = ['name' => 'Udasi Sikhs', 'religion_id' => $sikhism->id];
        $sects[] = ['name' => 'Sehajdhari Sikhs', 'religion_id' => $sikhism->id];
        $sects[] = ['name' => 'other', 'religion_id' => $sikhism->id];


        // Insert all sects into the database
        foreach ($sects as $sect) {
            Sect::create($sect);
        }
    }
}



