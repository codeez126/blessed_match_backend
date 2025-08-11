<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\HeaderInfo;
use App\Models\HouseSize;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PagesTableSeeder::class,
            AdminUserSeeder::class,
            HeaderinfoSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            ReligionSeeder::class,
            SectSeeder::class,
            CastSeeder::class,
            EducationSeeder::class,
            OccupationSeeder::class,
            LanguageSeeder::class,
            NationalitySeeder::class,
            HobbySeeder::class,
             MaritalStatusSeeder::class,
             FamilyClassSeeder::class,
             HouseStatusSeeder::class,
             EmploymentStatusSeeder::class,
             HouseSizeSeeder::class,
        ]);

    }
}
