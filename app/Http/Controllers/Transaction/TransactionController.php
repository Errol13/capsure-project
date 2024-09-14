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
            ->select('event_id', 'title', 'start_date', 'end_date') // Include start_date and end_date
            ->get();

        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';
        $today = Carbon::now($timezone);

        // Filter events by their date
        $ongoingEvents = $events->filter(function ($event) use ($today) {
            return $event->start_date <= $today && $event->end_date >= $today;
        });

        $upcomingEvents = $events->filter(function ($event) use ($today) {
            return $event->start_date > $today;
        });

        $previousEvents = $events->filter(function ($event) use ($today) {
            return $event->end_date < $today;
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

        // Return the view with grouped transactions by event
        return view('client.c_myTransaction', compact('transactionsByEvent'));
    }




    public function showFreelancerTransact()
    {
        return view('freelancer.f_myTransaction');
    }
}
