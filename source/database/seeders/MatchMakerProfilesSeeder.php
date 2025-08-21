<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClientAbout;
use App\Models\ClientFamilyMember;
use App\Models\ClientBackground;
use App\Models\ClientNationality;
use App\Models\ClientFamilyInfo;
use App\Models\ClientProfession;
use App\Models\UserBusiness;
use App\Models\ClientIslamicValue;
use App\Models\ClientLifeStyle;
use App\Models\ClientLanguage;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MatchMakerProfilesSeeder extends Seeder
{
    private $faker;
    private $matchMakerIds = [3,4];
    private $maritalStatuses = [1, 2, 3, 4, 5];
    private $familyClasses = [1, 2, 3, 4];
    private $houseStatuses = [1, 2, 3];
    private $houseSizes = [11, 12, 13, 14, 15];
    private $employmentStatuses =  [1, 2, 3];
    private $languages = [1, 2, 3, 4, 5]; // Assuming these language IDs exist
    private $nationalities = [1, 2, 3]; // Assuming these nationality IDs exist
    private $provinces = [1, 2, 3]; // Assuming these province IDs exist
    private $cities = [1, 2, 3, 4, 5]; // Assuming these city IDs exist
    private $areas = [1, 2, 3, 4, 5, 6, 7, 8]; // Assuming these area IDs exist
    private $religions = [1, 2]; // Assuming these religion IDs exist
    private $sects = [1, 2, 3]; // Assuming these sect IDs exist
    private $casts = [1, 2, 3, 4]; // Assuming these cast IDs exist
    private $educations = [1, 2, 3, 4, 5]; // Assuming these education IDs exist
    private $occupations = [1, 2, 3, 4, 5]; // Assuming these occupation IDs exist

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {
        // Get all match maker users (type = 1)
        $this->matchMakerIds = User::where('type', 1)->pluck('id')->toArray();

        if (empty($this->matchMakerIds)) {
            $this->command->error('No match maker users found! Please create match maker users first.');
            return;
        }

        DB::beginTransaction();

        try {
            for ($i = 0; $i < 300; $i++) {
                $this->createProfile();
            }

            DB::commit();
            $this->command->info('Successfully created 300 random profiles for match makers.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Failed to create profiles: ' . $e->getMessage());
        }
    }

    private function createProfile()
    {
        // Get random match maker
        $matchMakerId = $this->faker->randomElement($this->matchMakerIds);

        // Create basic user
        $user = User::create([
            'type' => '0',
            'auth_type' => 'email',
            'match_maker_id' => $matchMakerId,
            'status' => $this->faker->randomElement(['0']),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Default password
        ]);

        // Onboarding 1
        $this->onBoarding1($user);

        // Onboarding 2 & 3
        $this->onBoarding23($user);

        // Onboarding 4
        $this->onBoarding4($user);

        // Onboarding 5
        $this->onBoarding5($user);

        // Onboarding 6
        $this->onBoarding6($user);
    }

    private function onBoarding1($user)
    {
        $hasChildren = $this->faker->boolean(30); // 30% chance of having children
        $children = $hasChildren ? $this->generateChildren() : [];

        ClientAbout::create([
            'user_id' => $user->id,
            'full_name' => $this->faker->name,
            'profile_image' => $this->faker->imageUrl(),
            'gender_id' => $this->faker->randomElement([1,2]),
            'dob' => $this->faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'marital_status_id' => $this->faker->randomElement($this->maritalStatuses),
            'profile_managed_by' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['0', '1']),
            'reason_txt' => $this->faker->sentence,
            'client_contact' => $this->faker->phoneNumber,
//            'number_of_children' => $hasChildren ? count($children) : 0,
        ]);

        // Add children if any
        foreach ($children as $child) {
            ClientFamilyMember::create(array_merge($child, [
                'user_id' => $user->id,
                'type' => '1', // Type 1 for children
            ]));
        }
    }

    private function onBoarding23($user)
    {
        // Onboarding 2 - Background
        $background = ClientBackground::create([
            'user_id' => $user->id,
            'province' => $this->faker->randomElement($this->provinces),
            'city' => $this->faker->randomElement($this->cities),
            'area' => $this->faker->randomElement($this->areas),
            'permanent_address' => $this->faker->address,
            'current_address' => $this->faker->address,
            'house_status_id' => $this->faker->randomElement($this->houseStatuses),
            'house_size' => $this->faker->randomElement($this->houseSizes),
            'background_description' => $this->faker->paragraph,
        ]);

        // Add nationalities
        $nationalityCount = $this->faker->numberBetween(1, 2);
        $nationalities = $this->faker->randomElements($this->nationalities, $nationalityCount);

        foreach ($nationalities as $nationalityId) {
            ClientNationality::create([
                'user_id' => $user->id,
                'nationality_id' => $nationalityId,
            ]);
        }

        // Onboarding 3 - Family Info
        $hasSiblings = $this->faker->boolean(70); // 70% chance of having siblings
        $siblings = $hasSiblings ? $this->generateSiblings() : [];

        ClientFamilyInfo::create([
            'user_id' => $user->id,
            'father_occupation' => $this->faker->jobTitle,
            'mother_occupation' => $this->faker->jobTitle,
            'family_class_id' => $this->faker->randomElement($this->familyClasses),
            'is_father_alive' => $this->faker->boolean(80), // 80% chance father is alive
            'is_mother_alive' => $this->faker->boolean(85), // 85% chance mother is alive
        ]);

        // Add siblings if any
        foreach ($siblings as $sibling) {
            ClientFamilyMember::create(array_merge($sibling, [
                'user_id' => $user->id,
                'type' => '2', // Type 2 for siblings
            ]));
        }
    }

    private function onBoarding4($user)
    {
        $hasBusinesses = $this->faker->boolean(50); // 50% chance of having businesses
        $businessCount = $hasBusinesses ? $this->faker->numberBetween(1, 3) : 0;

        $profession = ClientProfession::create([
            'user_id' => $user->id,
            'occupation' => $this->faker->randomElement($this->occupations),
            'education_id' => $this->faker->randomElement($this->educations),
            'occupation_grade' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'employment_status_id' => $this->faker->randomElement($this->employmentStatuses),
            'avg_income' => $this->faker->numberBetween(30000, 300000),
        ]);

        // Add businesses if any
        for ($i = 0; $i < $businessCount; $i++) {
            UserBusiness::create([
                'user_id' => $user->id,
                'job_title' => $this->faker->jobTitle,
                'business_name' => $this->faker->company,
                'grade' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            ]);
        }
    }

    private function onBoarding5($user)
    {
        ClientIslamicValue::create([
            'user_id' => $user->id,
            'religion_id' => $this->faker->randomElement($this->religions),
            'sect_id' => $this->faker->randomElement($this->sects),
            'cast_id' => $this->faker->randomElement($this->casts),
            'sub_cast_name' => $this->faker->optional(0.3)->lastName, // 30% chance of having sub-cast
            'prayer_frequency' => $this->faker->numberBetween(1, 5),
            'is_where_hijab' => $this->faker->boolean(50),
            'is_where_nikab' => $this->faker->boolean(20),
            'is_have_beared' => $this->faker->boolean(30),
            'quran_memorization' => $this->faker->numberBetween(1, 0), // or whatever valid integer range your table expects
        ]);
    }

    private function onBoarding6($user)
    {
        $lifestyle = ClientLifeStyle::create([
            'user_id' => $user->id,
            'height' => $this->faker->numberBetween(150, 200),
            'weight' => $this->faker->numberBetween(40, 120),
            'skin_color_id' => $this->faker->numberBetween(1, 4),
            'hair' => $this->faker->numberBetween(1, 9),
            'disability' => $this->faker->boolean(10), // 10% chance of having disability
            'disability_details' => $this->faker->optional(0.1)->sentence, // Only if disability is true
            'health_issue' => $this->faker->boolean(15), // 15% chance of health issue
            'health_issue_details' => $this->faker->optional(0.15)->sentence, // Only if health issue is true
            'is_smoking' => $this->faker->boolean(20),
            'is_alcoholic' => $this->faker->boolean(5),
            'is_tobaco_habit' => $this->faker->boolean(15),
            'willing_to_relocate' => $this->faker->boolean(40),
        ]);

        // Add languages
        $languageCount = $this->faker->numberBetween(1, 3);
        $languages = $this->faker->randomElements($this->languages, $languageCount);

        foreach ($languages as $languageId) {
            ClientLanguage::create([
                'user_id' => $user->id,
                'language_id' => $languageId,
            ]);
        }
    }

    private function generateChildren()
    {
        $children = [];
        $count = $this->faker->numberBetween(1, 4);

        for ($i = 0; $i < $count; $i++) {
            $children[] = [
                'full_name' => $this->faker->firstName,
                'age' => $this->faker->numberBetween(1, 18),
                'gender_id' => $this->faker->randomElement([1,2]),
                'martial_status' => $this->faker->randomElement($this->maritalStatuses),
                'description' => $this->faker->optional(0.7)->sentence,
                'designation' => $this->faker->optional(0.5)->jobTitle,
                'guardian_info' => $this->faker->optional(0.3)->name,
            ];
        }

        return $children;
    }

    private function generateSiblings()
    {
        $siblings = [];
        $count = $this->faker->numberBetween(1, 5);

        for ($i = 0; $i < $count; $i++) {
            $siblings[] = [
                'full_name' => $this->faker->firstName,
                'age' => $this->faker->numberBetween(10, 50),
                'gender_id' => $this->faker->randomElement([1,2]),
                'martial_status' => $this->faker->randomElement($this->maritalStatuses),
                'description' => $this->faker->optional(0.7)->sentence,
                'designation' => $this->faker->optional(0.7)->jobTitle,
                'guardian_info' => $this->faker->optional(0.2)->name,
            ];
        }

        return $siblings;
    }
}
