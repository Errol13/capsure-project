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
                'status' => 'open',
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
                'status' => 'open',
            ],
            
        ];

        foreach ($events as $event) {
            DB::table('events')->insert($event);
        }
    }
}
