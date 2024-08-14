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
        $users = [];
        $clients = [];
        $freelancers = [];

        for ($i = 1; $i <= 40; $i++) {
            
            $isFreelancer = $i % 2 === 0; // Even IDs for freelancers, odd IDs for clients
            $firstName = $isFreelancer ? "Daisy" : "Will";
            $lastName = "Smith" . $i;
            $email = strtolower($firstName) . $i . "@example.com";
            $birthdate = Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'); // Random age between 20 and 40
            $age = Carbon::parse($birthdate)->age;
            $isNumberVerified = rand(0, 1) === 1;
            $isVerified = rand(0, 1) === 1;

            // Create user record
            $users[] = [
                'id' => $i,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password' . $i),
                'date_joined' => Carbon::now(),
                'birthdate' => $birthdate,
                'age' => $age,
                'street' => rand(100, 999) . ' Random St',
                'barangay' => 'Barangay ' . rand(1, 5),
                'city' => 'Cityville',
                'contact_number' => '09' . rand(100000000, 999999999),
                'isNumberVerified' => $isNumberVerified,
                'profile_image' => 'assets/daisy.svg',
                'isVerified' => $isVerified,
                'user_type' => $isFreelancer ? 'freelancer' : 'client',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Create associated client or freelancer record
            if ($isFreelancer) {
                $freelancers[] = [
                    'user_id' => $i,
                ];
            } else {
                $clients[] = [
                    'user_id' => $i,
                ];
            }
        }

        // Insert users
        DB::table('users')->insert($users);

        // Insert clients
        DB::table('clients')->insert($clients);

        // Insert freelancers
        DB::table('freelancers')->insert($freelancers);
    }
}