<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function showClientTransact()
    {
        /** @var User $user */
        $user = Auth::user();

        // Fetch the client's transactions
        $transactions = $user->client->transactions;

        // Log::info('transactions: ', $transactions->toArray());

        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';

        // Get the current date and time in the specified timezone
        $today = Carbon::now($timezone);


        // Log the current local and UTC times
        Log::info('Current Local Time:', ['local' => $today->toDateTimeString()]);

        // Filter ongoing transactions
        $ongoing = $transactions->filter(function ($transaction) use ($today) {
            // Parse start_date and end_date, and set to UTC
            $startDate = $transaction->event->start_date;
            $endDate = $transaction->event->end_date;

            // Log transaction details
            Log::info('Transaction Dates:', [
                'startDateUTC' => $startDate,
                'endDateUTC' => $endDate
            ]);

            // Determine if the transaction is ongoing
            return $startDate <= $today && $endDate >= $today;
        });

        // Log ongoing transactions
        Log::info('Ongoing: ', $ongoing->toArray());

        // Filter upcoming transactions
        $upcoming = $transactions->filter(function ($transaction) use ($today) {
            return $transaction->event->start_date > $today;
        });

         // Log ongoing transactions
        Log::info('Upcoming: ', $upcoming->toArray());

        // Filter previous transactions
        $history = $transactions->filter(function ($transaction) use ($today) {
            return $transaction->event->end_date < $today;
        });
        Log::info('Previous: ', $history->toArray());

        // Return the view with filtered transactions
        return view('client.c_myTransaction', compact('ongoing', 'upcoming', 'history'));
    }



    public function showFreelancerTransact()
    {
        return view('freelancer.f_myTransaction');
    }
}
