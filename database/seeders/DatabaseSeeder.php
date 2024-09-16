<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        // Truncate tables
        DB::table('events')->truncate();
        DB::table('event_jobs')->truncate();
        DB::table('job_applications')->truncate();
        DB::table('hiring_requests')->truncate();
        DB::table('transactions')->truncate();
    
        // Seed data
        $this->call(UsersTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventJobsTableSeeder::class);
        $this->call(JobApplicationsTableSeeder::class);
        $this->call(HiringRequestsTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
    }
    
}
