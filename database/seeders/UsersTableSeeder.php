<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'isEmailVerified' => true,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password123'),
                'date_joined' => Carbon::now(),
                'age' => 30,
                'street' => '123 Main St',
                'barangay' => 'Barangay 1',
                'city' => 'Cityville',
                'contact_number' => '09123456789',
                'isNumberVerified' => true,
                'profile_image' => 'path/to/profile_image.jpg',
                'isVerified' => true,
                'user_type' => 'client',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'janesmith@example.com',
                'isEmailVerified' => false,
                'email_verified_at' => null,
                'password' => Hash::make('password456'),
                'date_joined' => Carbon::now(),
                'age' => 25,
                'street' => '456 Oak St',
                'barangay' => 'Barangay 2',
                'city' => 'Townsville',
                'contact_number' => '09876543210',
                'isNumberVerified' => false,
                'profile_image' => 'path/to/profile_image2.jpg',
                'isVerified' => false,
                'user_type' => 'freelancer',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more users as needed
        ]);
    }
}
