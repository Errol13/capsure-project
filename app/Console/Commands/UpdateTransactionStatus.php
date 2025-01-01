<?php

namespace App\Console\Commands;

use App\Models\Transaction\Transaction;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-transaction-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of transactions from Pending to Ongoing if the event start date has passed.';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now('Asia/Manila');

        // Get all transactions with Pending status
        $pendingTransactions = Transaction::where('transaction_status', 'Pending')->get();

        $this->info('Starting to update transaction statuses.');

        foreach ($pendingTransactions as $transaction) {
            $event = $transaction->event; // Fetch related event

            //if the event start today begins, then it became Ongoing
            if ($event && $event->start_date <= $today) {
                $transaction->transaction_status = 'Ongoing';
                $transaction->save();
                $this->info("Updated transaction {$transaction->id} to Ongoing.");
            } else {
                $this->info("Transaction {$transaction->id} remains Pending.");
            }
        }

        $this->info('Transaction statuses updated successfully.');
    }
}
