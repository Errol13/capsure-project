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

        // Prepare data for bulk insert
        $services = [];

        foreach ($freelancerIds as $freelancerId) {
            // multiple services for some freelancers
            $services[] = [
                'freelancer_id' => $freelancerId,
                'job_category' => 'Videography',
                'job_title' => 'Videographer',
                'fee_type' => '/project',
                'isAvailable' => true,
                'job_fee' => 500.00,
            ];

            // Add more services for certain freelancers
            if ($freelancerId % 2 == 0) { //every 2nd freelancer gets an additional service
                $services[] = [
                    'freelancer_id' => $freelancerId,
                    'job_category' => 'Photography',
                    'job_title' => 'Photographer',
                    'fee_type' => '/hour',
                    'isAvailable' => true,
                    'job_fee' => 300.00,
                ];
            }

            if ($freelancerId % 5 == 0) { //every 5th freelancer gets another service
                $services[] = [
                    'freelancer_id' => $freelancerId,
                    'job_category' => 'Art',
                    'job_title' => 'Portrait Artist',
                    'fee_type' => '/project',
                    'isAvailable' => false,
                    'job_fee' => 1250.00,
                ];
            }
        }

        // Bulk insert services
        DB::table('services')->insert($services);
    }
}
