<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Example data
        $jobApplications = [
            [
                'freelancer_id' => 2,
                'service_id' => 1,
                'job_id' => 1,
                'status' => 'Accepted',
            ],

            [
                'freelancer_id' => 4,
                'service_id' => 1,
                'job_id' => 2,
                'status' => 'Accepted',
            ],

            [
                'freelancer_id' => 2,
                'service_id' => 2,
                'job_id' => 3,
                'status' => 'Accepted',
            ],

            [
                'freelancer_id' => 4,
                'service_id' => 3,
                'job_id' => 4,
                'status' => 'Accepted',
            ],
            // Add more job applications as needed
        ];

        foreach ($jobApplications as $application) {
            DB::table('job_applications')->insert($application);
        }
    }
}
