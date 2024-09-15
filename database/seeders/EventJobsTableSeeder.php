<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Example data
        $eventJobs = [
            [
                'service_needed' => 'Photographer',
                'job_category' => 'Photography',
                'number_of_people' => 3,
                'status' => 'open',
                'event_id' => 1,
            ],

            [
                'service_needed' => 'Photographer',
                'job_category' => 'Photography',
                'number_of_people' => 3,
                'status' => 'open',
                'event_id' => 2,
            ],
           
        ];

        foreach ($eventJobs as $job) {
            DB::table('event_jobs')->insert($job);
        }
    }
}
