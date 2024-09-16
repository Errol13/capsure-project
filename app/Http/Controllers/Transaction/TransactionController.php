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

        // Fetch the client's events with necessary fields
        $events = $user->client->events()
            ->with(['transactions.payment_proofs']) // Get related transactions and payment proofs
            ->select('event_id', 'title', 'start_date', 'end_date') // Include relevant event fields
            ->get();

        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';
        $today = Carbon::now($timezone);

        // Function to sort events by start_date
        $sortEventsByDate = function ($events) {
            return $events->sortBy(function ($event) {
                return Carbon::parse($event->start_date);
            });
        };

        // Filter for ongoing events (start_date <= today <= end_date OR at least one transaction has status 'On-going')
        $ongoingEvents = $events->filter(function ($event) use ($today) {
            $hasOngoingTransaction = $event->transactions->contains(function ($transaction) {
                return $transaction->transaction_status === 'On-going';
            });

            return ($event->start_date <= $today && $event->end_date >= $today) || $hasOngoingTransaction;
        })->map(function ($event) use ($timezone) {
            $event = $this->formatEventDates($event, $timezone);
            $event->transactions = $event->transactions->sortBy('start_date');
            return $event;
        });
        $ongoingEvents = $sortEventsByDate($ongoingEvents);

        // Filter for upcoming events (start_date is in the future)
        $upcomingEvents = $events->filter(function ($event) use ($today) {
            return $event->start_date > $today;
        })->map(function ($event) use ($timezone) {
            $event = $this->formatEventDates($event, $timezone);
            $event->transactions = $event->transactions->sortBy('start_date');
            return $event;
        });
        $upcomingEvents = $sortEventsByDate($upcomingEvents);

        // Filter for previous events (end_date is in the past, and none of the transactions have status 'On-going')
        $previousEvents = $events->filter(function ($event) use ($today) {
            $hasOngoingTransaction = $event->transactions->contains(function ($transaction) {
                return $transaction->transaction_status === 'On-going';
            });

            return $event->end_date < $today && !$hasOngoingTransaction;
        })->map(function ($event) use ($timezone) {
            $event = $this->formatEventDates($event, $timezone);
            $event->transactions = $event->transactions->sortBy('start_date');
            return $event;
        });
        $previousEvents = $sortEventsByDate($previousEvents);

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
            ->format('M j, Y h:i A');

        // Format the end date as 'Month Day, Year h:i A'
        $event->end_date_formatted = Carbon::parse($event->end_date)
            ->timezone($timezone)
            ->format('M j, Y h:i A');

        return $event;
    }





    public function showFreelancerTransact()
    {
        /** @var User $user */
        $user = Auth::user();

        // Get the freelancer's transactions with related event and other necessary relationships
        $transactions = $user->freelancer->transactions()->with(['event', 'client.user', 'payment_proofs'])->get();

        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';
        $today = Carbon::now($timezone);

        // Filter for ongoing transactions
        $ongoingTransactions = $transactions->filter(function ($transaction) use ($today) {
            $startDate = Carbon::parse($transaction->event->start_date);
            $endDate = Carbon::parse($transaction->event->end_date);

            // Include transactions with "On-going" status or that are ongoing by date
            return $transaction->transaction_status === 'On-going' || $today->between($startDate, $endDate);
        })->sortBy(function ($transaction) {
            // Sort by the event's start_date
            return Carbon::parse($transaction->event->start_date);
        });

        // Filter for upcoming transactions (start_date is in the future)
        $upcomingTransactions = $transactions->filter(function ($transaction) use ($today) {
            return Carbon::parse($transaction->event->start_date)->greaterThan($today);
        });

        // Filter for previous transactions (end_date is in the past)
        $previousTransactions = $transactions->filter(function ($transaction) use ($today) {
            return Carbon::parse($transaction->event->end_date)->lessThan($today)
                && $transaction->transaction_status !== 'On-going'; // Exclude "On-going" transactions because of unpaid or unsettled payments or review
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
