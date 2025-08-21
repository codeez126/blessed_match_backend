<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        User::create([
            'phone' => '00000000000',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),  // Hash the password
            'type' => 2,  // Set type to 1 (for admin)
        ]);
    }
}
