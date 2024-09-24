<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Example data
        $events = [
            [
                'client_id' => 1,
                'title' => 'Birthday Party',
                'description' => 'Description for Event 1',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(15),
                'street' => '123 Main St',
                'barangay' => 'Barangay 1',
                'city' => 'City 1',
                'payment_method' => 'Cash',
                'budget_min' => 500.00,
                'budget_max' => 1500.00,
                'status' => 'Open',
                'created_at' => Carbon::now(), // Adding timestamps
                'updated_at' => Carbon::now(), // Adding timestamps
            ],
            [
                'client_id' => 1,
                'title' => 'Debut',
                'description' => 'Description for Event 2',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(3),
                'street' => '123 Main St',
                'barangay' => 'Barangay 1',
                'city' => 'City 1',
                'payment_method' => 'Cash',
                'budget_min' => 500.00,
                'budget_max' => 1500.00,
                'status' => 'Open',
                'created_at' => Carbon::now(), // Adding timestamps
                'updated_at' => Carbon::now(), // Adding timestamps
            ],
            [
                'client_id' => 1,
                'title' => 'Music Concert',
                'description' => 'An outdoor music concert.',
                'start_date' => Carbon::now()->subDays(10), // 10 days ago
                'end_date' => Carbon::now()->subDays(9), // Ended 9 days ago
                'street' => '789 Concert Blvd',
                'barangay' => 'Barangay 7',
                'city' => 'City 4',
                'payment_method' => 'Cash',
                'budget_min' => 1000.00,
                'budget_max' => 4000.00,
                'status' => 'Closed', // Event is closed
                'created_at' => Carbon::now()->subDays(15), // Created 15 days ago
                'updated_at' => Carbon::now()->subDays(9), // Updated when the event ended
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->insert($event);
        }
    }
}
