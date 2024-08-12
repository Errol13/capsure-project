<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Get IDs of users with user_type 'freelancer'
       $freelancerIds = DB::table('users')
       ->where('user_type', 'freelancer')
       ->pluck('id');

   // Insert services for each freelancer
   foreach ($freelancerIds as $freelancerId) {
       DB::table('services')->insert([
           [
               'user_id' => $freelancerId,
               'job_category' => 'Videography', // Replace with actual service names or logic
               'job_title' => 'Videographer',
               'fee_type' => '/project',
               'isAvailable' => true,
               'job_fee' => 500.00,
           ],
           // Add more services as needed
       ]);
   }
    }
}
