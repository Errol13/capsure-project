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
        $admin = [];

        for ($i = 1; $i <= 40; $i++) {
            $isFreelancer = $i % 2 === 0; // Even IDs for freelancers, odd IDs for clients
            $firstName = $isFreelancer ? "Daisy" : "Will";
            $lastName = "Smith" . $i;
            $email = strtolower($firstName) . $i . "@example.com";
            $birthdate = Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'); // Random age between 20 and 40
            $age = Carbon::parse($birthdate)->age;
            $isNumberVerified = false;
            $isVerified = false;

            // Create user record without manually setting the ID
            $users[] = [
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
                'profile_image' => 'assets/default.svg',
                'isVerified' => $isVerified,
                'user_type' => $isFreelancer ? 'freelancer' : 'client',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        

        // Insert users and retrieve the inserted IDs
        DB::table('users')->insert($users);
        $insertedUsers = DB::table('users')->get();

        //for admin 

        $admin = [
            'first_name' => 'Admin',
            'last_name' => 'Istrator',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin 1234!'),
            'date_joined' => Carbon::now(),
            'birthdate' => Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'),
            'age' =>  Carbon::parse($birthdate)->age,
            'street' => rand(100, 999) . ' Random St',
            'barangay' => 'Barangay ' . rand(1, 5),
            'city' => 'Cityville',
            'contact_number' => '09' . rand(100000000, 999999999),
            'isNumberVerified' => true,
            'profile_image' => 'assets/default.svg',
            'isVerified' => true,
            'user_type' => 'admin',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('users')->insert($admin);

        // Create associated client or freelancer records using the correct user IDs
        foreach ($insertedUsers as $user) {
            if ($user->user_type === 'freelancer') {
                $freelancers[] = [
                    'user_id' => $user->id,
                ];
            } else {
                $clients[] = [
                    'user_id' => $user->id,
                ];
            }
        }

        // Insert clients and freelancers
        DB::table('clients')->insert($clients);
        DB::table('freelancers')->insert($freelancers);

        // Define social media platforms
        $socialMediaAccounts = [
            ['platform' => 'Facebook', 'url' => ''],
            ['platform' => 'LinkedIn', 'url' => ''],
            ['platform' => 'Instagram', 'url' => '']
        ];

        // Create social media records for each user
        $socialMedia = [];
        foreach ($insertedUsers as $user) {
            foreach ($socialMediaAccounts as $socialMediaAccount) {
                $socialMedia[] = [
                    'user_id' => $user->id,
                    'platform' => $socialMediaAccount['platform'],
                    'url' => $socialMediaAccount['url'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // Insert social media accounts
        DB::table('social_media_accounts')->insert($socialMedia);
    }
}
