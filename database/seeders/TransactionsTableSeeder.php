<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        // Example data
        $transactions = [
            [
                'client_id' => 1,
                'freelancer_id' => 2,
                'job_id' => 1,
                'hiring_request_id' => 1,
                'payment_amount' => 1000.00,
                'payment_status' => 'Unpaid',
                'transaction_status' => 'Pending',
            ],

            [
                'client_id' => 1,
                'freelancer_id' => 4,
                'job_id' => 2,
                'hiring_request_id' => 2,
                'payment_amount' => 800.00,
                'payment_status' => 'Unpaid',
                'transaction_status' => 'Pending',
            ],

            [
                'client_id' => 1,
                'freelancer_id' => 2,
                'job_id' => 3,
                'hiring_request_id' => 3,
                'payment_amount' => 805.00,
                'payment_status' => 'Unpaid',
                'transaction_status' => 'Ongoing',
            ],

            [
                'client_id' => 1,
                'freelancer_id' => 4,
                'job_id' => 4,
                'hiring_request_id' => 4,
                'payment_amount' => 800.00,
                'payment_status' => 'Unpaid',
                'transaction_status' => 'Ongoing',
            ],
           
        ];

        foreach ($transactions as $transaction) {
            DB::table('transactions')->insert($transaction);
        }
    }
}
