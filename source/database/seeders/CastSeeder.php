<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Religion;
use App\Models\Cast;
use App\Models\Subcast;

class CastSeeder extends Seeder
{
    public function run()
    {
        // Get the religions
        $islam = Religion::where('name', 'Islam')->first();
        $hinduism = Religion::where('name', 'Hinduism')->first();
        $christianity = Religion::where('name', 'Christianity')->first();
        $sikhism = Religion::where('name', 'Sikhism')->first();
        $other = Religion::where('name', 'Other')->first();

        // Casts for Islam
        $islamCasts = [
            ['name' => 'Jatt', 'religion_id' => $islam->id, 'subcasts' => [
                'Bajwa', 'Cheema', 'Sandhu', 'Gill', 'Virk', 'other'
            ]],
            ['name' => 'Arain', 'religion_id' => $islam->id, 'subcasts' => [
                'Chaudhry', 'Mian', 'Mehar', 'Malik', 'Bhutto', 'other'
            ]],
            ['name' => 'Rajput', 'religion_id' => $islam->id, 'subcasts' => [
                'Bhatti', 'Manj', 'Variyaan', 'Rana', 'Rao', 'Chaudhry', 'other'
            ]],
            ['name' => 'Pathan', 'religion_id' => $islam->id, 'subcasts' => [
                'Yousufzai', 'Afridi', 'Khattak', 'Khan', 'other'
            ]],
            ['name' => 'Awan', 'religion_id' => $islam->id, 'subcasts' => [
                'Malik', 'Chaudhry', 'other'
            ]],
            ['name' => 'Gujjar', 'religion_id' => $islam->id, 'subcasts' => [
                'Chaudhry', 'other'
            ]],
            ['name' => 'Syed', 'religion_id' => $islam->id, 'subcasts' => [
                'Shah', 'Bukhari', 'Quadri', 'Rizvi', 'other'
            ]],
            ['name' => 'Baloch', 'religion_id' => $islam->id, 'subcasts' => [
                'Bugti', 'Marri', 'Rind', 'Sardar', 'other'
            ]],
            ['name' => 'Sheikh', 'religion_id' => $islam->id, 'subcasts' => [
                'Siddiqui', 'other'
            ]],
            ['name' => 'Qureshi', 'religion_id' => $islam->id, 'subcasts' => [
                'Hashmi', 'other'
            ]],
            ['name' => 'Butt', 'religion_id' => $islam->id, 'subcasts' => [
                'Mir', 'other'
            ]],
            ['name' => 'Kashmiri', 'religion_id' => $islam->id, 'subcasts' => [
                'Butt', 'Dar', 'other'
            ]],
            ['name' => 'Mughal', 'religion_id' => $islam->id, 'subcasts' => [
                'Mirza', 'Baig', 'Mistry', 'other'
            ]],
            ['name' => 'Malik', 'religion_id' => $islam->id, 'subcasts' => [
                'Chaudhry', 'other'
            ]],
            ['name' => 'Mehar', 'religion_id' => $islam->id, 'subcasts' => [
                'Chaudhry', 'other'
            ]],
            ['name' => 'Mistri', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'Nai', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'Mochi', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'Kumhar', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'Lohar', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'Tarkhan', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'Bazigar', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
            ['name' => 'other', 'religion_id' => $islam->id, 'subcasts' => [
                'other'
            ]],
        ];
        foreach ($islamCasts as $castData) {
            $cast = Cast::create([
                'name' => $castData['name'],
                'religion_id' => $castData['religion_id']
            ]);

            if (isset($castData['subcasts'])) {
                foreach ($castData['subcasts'] as $subcastName) {
                    Subcast::create([
                        'name' => $subcastName,
                        'cast_id' => $cast->id
                    ]);
                }
            }
        }

        $hinduismCasts = [
            ['name' => 'Brahmin', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Kanyakubja', 'Saryupareen', 'Maithil', 'Gaud', 'Sharma', 'Mishra', 'Joshi', 'Pandit', 'Other'
            ]],
            ['name' => 'Rajput', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Rathore', 'Chauhan', 'Solanki', 'Bhatti', 'Other'
            ]],
            ['name' => 'Bania', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Agarwal', 'Gupta', 'Maheshwari', 'Khandelwal', 'Other'
            ]],
            ['name' => 'Lohana', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Thakur', 'Bhatia', 'Lalwani', 'Other'
            ]],
            ['name' => 'Khatri', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Kapoor', 'Mehra', 'Khanna', 'Malhotra', 'Other'
            ]],
            ['name' => 'Gujjar', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Chaudhry', 'Kasana', 'Other'
            ]],
            ['name' => 'Arora', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Chawla', 'Batra', 'Sethi', 'Other'
            ]],
            ['name' => 'Meghwar', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Other'
            ]],
            ['name' => 'Kohli', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Other'
            ]],
            ['name' => 'Bheel', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Other'
            ]],
            ['name' => 'Kumhar', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Prajapati', 'Other'
            ]],
            ['name' => 'Jogi', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Other'
            ]],
            ['name' => 'Suthar', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Other'
            ]],
            ['name' => 'other', 'religion_id' => $hinduism->id, 'subcasts' => [
                'Other'
            ]],
        ];

        foreach ($hinduismCasts as $castData) {
            $cast = Cast::create([
                'name' => $castData['name'],
                'religion_id' => $castData['religion_id']
            ]);

            if (isset($castData['subcasts'])) {
                foreach ($castData['subcasts'] as $subcastName) {
                    Subcast::create([
                        'name' => $subcastName,
                        'cast_id' => $cast->id
                    ]);
                }
            }
        }

        // Casts for Christianity
        $christianityCasts = [
            ['name' => 'Punjabi Christian', 'religion_id' => $christianity->id, 'subcasts' => [
                'Masih', 'Gill', 'Sardar', 'Lal', 'Other'
            ]],
            ['name' => 'Chuhra', 'religion_id' => $christianity->id, 'subcasts' => [
                'Masih', 'Lal', 'Other'
            ]],
            ['name' => 'Jatt Christian', 'religion_id' => $christianity->id, 'subcasts' => [
                'Gill', 'Sandhu', 'Bajwa', 'Other'
            ]],
            ['name' => 'Arora Christian', 'religion_id' => $christianity->id, 'subcasts' => [
                'Chawla', 'Batra', 'Sethi', 'Other'
            ]],
            ['name' => 'Khatri Christian', 'religion_id' => $christianity->id, 'subcasts' => [
                'Kapoor', 'Mehra', 'Khanna', 'Other'
            ]],
            ['name' => 'Rajput Christian', 'religion_id' => $christianity->id, 'subcasts' => [
                'Bhatti', 'Rathore', 'Chauhan', 'Other'
            ]],
            ['name' => 'Other', 'religion_id' => $christianity->id, 'subcasts' => [
                 'Other'
            ]],
        ];

        foreach ($christianityCasts as $castData) {
            $cast = Cast::create([
                'name' => $castData['name'],
                'religion_id' => $castData['religion_id']
            ]);

            if (isset($castData['subcasts'])) {
                foreach ($castData['subcasts'] as $subcastName) {
                    Subcast::create([
                        'name' => $subcastName,
                        'cast_id' => $cast->id
                    ]);
                }
            }
        }

        // Casts for Sikhism
        $sikhismCasts = [
            ['name' => 'Jatt Sikh', 'religion_id' => $sikhism->id, 'subcasts' => [
                'Gill', 'Sandhu', 'Sidhu', 'Bajwa', 'Cheema', 'Other'
            ]],
            ['name' => 'Khatri Sikh', 'religion_id' => $sikhism->id, 'subcasts' => [
                'Kapoor', 'Khanna', 'Malhotra', 'Mehra', 'Chopra', 'Other'
            ]],
            ['name' => 'Arora Sikh', 'religion_id' => $sikhism->id, 'subcasts' => [
                'Chawla', 'Batra', 'Sethi', 'Kohli', 'Other'
            ]],
            ['name' => 'Ramgarhia', 'religion_id' => $sikhism->id, 'subcasts' => [
                'Matharu', 'Saini', 'Tarkhan', 'Other'
            ]],
            ['name' => 'Rajput Sikh', 'religion_id' => $sikhism->id, 'subcasts' => [
                'Bhatti', 'Rathore', 'Chauhan', 'Other'
            ]],
            ['name' => 'Other', 'religion_id' => $sikhism->id, 'subcasts' => [
                'Other'
            ]],
        ];

        foreach ($sikhismCasts as $castData) {
            $cast = Cast::create([
                'name' => $castData['name'],
                'religion_id' => $castData['religion_id']
            ]);

            if (isset($castData['subcasts'])) {
                foreach ($castData['subcasts'] as $subcastName) {
                    Subcast::create([
                        'name' => $subcastName,
                        'cast_id' => $cast->id
                    ]);
                }
            }
        }

        // Casts for "Others" religion
        $otherCasts = [
            ['name' => 'Other', 'religion_id' => $other->id],
        ];

        foreach ($otherCasts as $castData) {
            Cast::create([
                'name' => $castData['name'],
                'religion_id' => $castData['religion_id']
            ]);
        }
    }
}
