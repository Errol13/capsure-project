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
                'client_id' => 2,
                'title' => 'Birthday Party',
                'description' => 'Looking for excellent photographer for my nephew\s birthday.',
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
                'client_id' => 2,
                'title' => 'Debut',
                'description' => 'Lf photograpers to hire for my friend\'s debut with a 3 day event celebration.',
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
                'client_id' => 2,
                'title' => 'Music Concert',
                'description' => 'An outdoor music concert.',
                'start_date' => Carbon::now()->addDays(4),
                'end_date' => Carbon::now()->addDays(6),
                'street' => '789 Concert Blvd',
                'barangay' => 'Barangay 7',
                'city' => 'City 4',
                'payment_method' => 'Cash',
                'budget_min' => 1000.00,
                'budget_max' => 4000.00,
                'status' => 'Open', // Event is open
                'created_at' => Carbon::now()->subDays(3), // Created 3 days ago
                'updated_at' => Carbon::now()->subDays(3), // Updated same time as created
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->insert($event);
        }
    }
}
