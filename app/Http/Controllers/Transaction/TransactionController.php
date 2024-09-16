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

        // Fetch the client's events with only the necessary fields
        $events = $user->client->events()
            ->with(['transactions.payment_proofs'])
            ->select('event_id', 'title', 'start_date', 'end_date') // Include start_date and end_date
            ->get();

        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';
        $today = Carbon::now($timezone);

        // Filter and format events by their date
        $ongoingEvents = $events->filter(function ($event) use ($today) {
            return $event->start_date <= $today && $event->end_date >= $today;
        })->map(function ($event) use ($timezone) {
            return $this->formatEventDates($event, $timezone);
        });

        $upcomingEvents = $events->filter(function ($event) use ($today) {
            return $event->start_date > $today;
        })->map(function ($event) use ($timezone) {
            return $this->formatEventDates($event, $timezone);
        });

        $previousEvents = $events->filter(function ($event) use ($today) {
            return $event->end_date < $today;
        })->map(function ($event) use ($timezone) {
            return $this->formatEventDates($event, $timezone);
        });

        // Get transactions for each event category
        $transactionsByEvent = [
            'ongoing' => $ongoingEvents->map(function ($event) {
                return [
                    'event' => $event,
                    'transactions' => $event->transactions
                ];
            }),
            'upcoming' => $upcomingEvents->map(function ($event) {
                return [
                    'event' => $event,
                    'transactions' => $event->transactions
                ];
            }),
            'previous' => $previousEvents->map(function ($event) {
                return [
                    'event' => $event,
                    'transactions' => $event->transactions
                ];
            }),
        ];

        Log::info('Previous: ', $transactionsByEvent['previous']->toArray());

        // Return the view with grouped transactions by event
        return view('client.c_myTransaction', compact('transactionsByEvent'));
    }

    /**
     * Format the start and end date of the event.
     *
     * @param  \App\Models\Event  $event
     * @param  string  $timezone
     * @return \App\Models\Event
     */
    private function formatEventDates($event, $timezone)
    {
        // Format the start date as 'Month Day, Year'
        $event->start_date_formatted = Carbon::parse($event->start_date)
            ->timezone($timezone)
            ->format('M j, Y');

        // Format the end date as 'Month Day, Year h:i A'
        $event->end_date_formatted = Carbon::parse($event->end_date)
            ->timezone($timezone)
            ->format('M j, Y');

        return $event;
    }





    public function showFreelancerTransact()
    {

        /** @var User $user */
        $user = Auth::user();

        //get the freelancer's transactions
        $transactions = $user->freelancer->transactions()->with(['event', 'client.user', 'payment_proofs'])->get();

        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';
        $today = Carbon::now($timezone);


        // Filter for upcoming transactions (start_date is in the future)
        $upcomingTransactions = $transactions->filter(function ($transaction) use ($today) {
            return Carbon::parse($transaction->event->start_date)->greaterThan($today);
        });

        // Filter for ongoing transactions (today is between start_date and end_date)
        $ongoingTransactions = $transactions->filter(function ($transaction) use ($today) {
            $startDate = Carbon::parse($transaction->event->start_date);
            $endDate = Carbon::parse($transaction->event->end_date);
            return $today->between($startDate, $endDate);
        });

        // Filter for previous transactions (end_date is in the past)
        $previousTransactions = $transactions->filter(function ($transaction) use ($today) {
            return Carbon::parse($transaction->event->end_date)->lessThan($today);
        });

        return view(
            'freelancer.f_myTransaction',
            [
                'ongoing' => $ongoingTransactions,
                'upcoming' => $upcomingTransactions,
                'previous' => $previousTransactions
            ]
        );
    }
}
