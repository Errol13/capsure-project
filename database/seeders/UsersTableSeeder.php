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
        $users =
            [
                [
                    'id' => '1',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'johndoe@example.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password123'),
                    'date_joined' => Carbon::now(),
                    'birthdate' => '2000-06-13',
                    'age' => 24,
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
                    'id' => '2',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'email' => 'janesmith@example.com',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password456'),
                    'date_joined' => Carbon::now(),
                    'birthdate' => '2002-11-06',
                    'age' => 22,
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
                // Add more users 
            ];

        DB::table('users')->insert($users);

        // Seeding clients table
        DB::table('clients')->insert([
            [
                'user_id' => 1, 
            ],
            // Add more clients 
        ]);

        // Seeding freelancers table
        DB::table('freelancers')->insert([
            [
                'user_id' => 2, 
            ],
            // Add more freelancers
        ]);
    }
}
