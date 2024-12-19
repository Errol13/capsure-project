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
        $client = [];
        $freelancers = [];
        $admin = [];

        $birthdateAdmin = Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'); // Random age between 20 and 40
        //for admin 

        $admin = [
            'first_name' => 'Admin',
            'last_name' => 'Istrator',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin 1234!'),
            'date_joined' => Carbon::now(),
            'birthdate' => Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'),
            'age' =>  Carbon::parse($birthdateAdmin)->age,
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

         //for client
        $birthdateClient = Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'); // Random age between 20 and 40

        $client = [
            'first_name' => 'Phoebe Marion',
            'last_name' => 'Castro',
            'email' => 'pmcastro@gbox.adnu.edu.ph',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password 1234!'),
            'date_joined' => Carbon::now(),
            'birthdate' => Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'),
            'age' =>  Carbon::parse($birthdateClient)->age,
            'street' => 'Zone 1',
            'barangay' => 'Random.St ' . rand(1, 5),
            'city' => 'Naga City',
            'contact_number' => '09' . rand(100000000, 999999999),
            'isNumberVerified' => true,
            'profile_image' => 'assets/default.svg',
            'isVerified' => false,
            'user_type' => 'client',
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('users')->insert($client);

        for ($i = 3; $i <= 32; $i++) {
            $firstName = "Daisy";
            $lastName = "Smith" . $i;
            $email = strtolower($firstName) . $i . "@example.com";
            $birthdate = Carbon::now()->subYears(rand(20, 40))->format('Y-m-d'); // Random age between 20 and 40
            $age = Carbon::parse($birthdate)->age;
            $isNumberVerified = false;
            $isVerified = true;

            // Create user record without manually setting the ID
            $users[] = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password ' . $i),
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
                'user_type' => 'freelancer',
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }


        // Insert users and retrieve the inserted IDs
        DB::table('users')->insert($users);
        $insertedUsers = DB::table('users')->get();

        // Create associated client or freelancer records using the correct user IDs
        foreach ($insertedUsers as $user) {
            if ($user->user_type === 'freelancer') {
                $freelancers[] = [
                    'user_id' => $user->id,
                ];
            } elseif($user->user_type === 'client'){
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
