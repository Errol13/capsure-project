<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HiringRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Example data
        $hiringRequests = [
            [
                'freelancer_id' => 2,
                'job_id' => 1,
                'client_id' => 1,
                'client_pricing' => 1000.00,
                'freelancer_pricing' => 800.00,
                'dealer_user_type' => 'Client',
                'status' => 'Accepted',
            ],

            [
                'freelancer_id' => 4,
                'job_id' => 2,
                'client_id' => 1,
                'client_pricing' => 1000.00,
                'freelancer_pricing' => 800.00,
                'dealer_user_type' => 'Freelancer',
                'status' => 'Accepted',
            ],
            // Add more hiring requests as needed
        ];

        foreach ($hiringRequests as $request) {
            DB::table('hiring_requests')->insert($request);
        }
    }
}
