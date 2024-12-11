<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Profile\Membership;
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
            ->with(['transactions.payment_proofs', 'transactions.reviews']) // Include reviews in the transactions
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

        $ongoingEvents = $events->filter(function ($event) use ($today) {

            if ($event->transactions->isEmpty()) {
                return false; // Exclude events with no transactions
            }

            // Check if the event is currently ongoing
            $isOngoing = $event->start_date <= $today && $event->end_date >= $today;

            // Check if there is at least one pending transaction
            $hasOngoingTransaction = $event->transactions->contains(function ($transaction) {
                return $transaction->transaction_status === 'Ongoing';
            });

            // Check if the client has made a review for each transaction
            $clientMadeReviews = $event->transactions->every(function ($transaction) {
                // Check if the client has reviewed the freelancer for this transaction
                return $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
            });

            // Only include the event if it is ongoing or if it has ongoing transactions but is not upcoming
            return $isOngoing || ($hasOngoingTransaction && !$clientMadeReviews) || (!$isOngoing && $hasOngoingTransaction  && !$clientMadeReviews);
        })->map(function ($event) use ($timezone) {
            $event = $this->formatEventDates($event, $timezone);
            $event->transactions = $event->transactions->sortBy('start_date');
            return $event;
        });


        // Log::info('Ongoing V: ', $ongoingEvents->toArray());

        $ongoingEvents = $sortEventsByDate($ongoingEvents);


        // Filter for upcoming events (start_date is in the future)
        $upcomingEvents = $events->filter(function ($event) use ($today) {
            if ($event->transactions->isEmpty()) {
                return false; // Exclude events with no transactions
            }
            return $event->start_date > $today;
        })->map(function ($event) use ($timezone) {
            $event = $this->formatEventDates($event, $timezone);
            $event->transactions = $event->transactions->sortBy('start_date');
            return $event;
        });
        $upcomingEvents = $sortEventsByDate($upcomingEvents);

        // Filter for previous events (end_date is in the past, and none of the transactions have status 'On-going', and client has made reviews)
        $previousEvents = $events->filter(function ($event) use ($today) {
            if ($event->transactions->isEmpty()) {
                return false; // Exclude events with no transactions
            }


            $hasOngoingTransaction = $event->transactions->contains(function ($transaction) {
                return $transaction->transaction_status === 'Ongoing';
            });

            // Check if the client has made a review for each transaction
            $clientMadeReviews = $event->transactions->every(function ($transaction) {
                // Check if the client has reviewed the freelancer for this transaction
                if ($transaction->freelancer) {
                    return $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
                } elseif ($transaction->team) {
                    return $transaction->reviews()->where('reviewee_role', 'team')->exists();
                }
            });

            // dd($clientMadeReviews);

            return $event->end_date < $today && (!$hasOngoingTransaction && $clientMadeReviews) || ($hasOngoingTransaction && $clientMadeReviews);
        })->map(function ($event) use ($timezone) {
            $event = $this->formatEventDates($event, $timezone);
            $event->transactions = $event->transactions->sortBy('start_date');
            return $event;
        });
        $previousEvents = $sortEventsByDate($previousEvents);

        // Fetch members of the team for each event, filtered by the transaction's created_at
        $events->each(function ($event) {
            $event->transactions->each(function ($transaction) {
                // Only fetch members if the transaction has a team_code (i.e., it is not a solo freelancer)
                if ($transaction->team_code) {
                    // Fetch team members based on team_code and the transaction's created_at
                    $members = Membership::where('team_id', $transaction->team->team_id)
                        ->where('created_at', '<=', $transaction->created_at)
                        ->get();

                    // For each member, fetch the associated services
                    $members->each(function ($member) {
                        // Fetch services for the member using the getServices method
                        $member->services = $member->getServices();
                    });

                    $transaction->members = $members; // Add members with services to each transaction
                } else {
                    // If it's a solo freelancer, you can set the members to an empty collection or null
                    $transaction->members = collect(); // No members for solo freelancers
                }
            });
        });


        // dd($previousEvents->count());
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

        // dd($ongoingEvents->map(function ($event) {
        //     return [
        //         'event' => $event,
        //         'transactions' => $event->transactions
        //     ];
        // }));


        // Log for debugging 
        //Log::info('Ongoing: ', $transactionsByEvent['ongoing']->toArray());

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

        // Get the freelancer's transactions with related event and clients (eager load user table) as well as paymentproofs
        $soloTransactions = $user->freelancer->transactions()
            ->with(['event', 'client.user', 'payment_proofs', 'reviews'])
            ->get();

        // Get team transactions
        $teamTransactions = $user->freelancer->teamTransactions();

        // dd($teamTransactions);
        // Merge solo and team transactions
        $transactions = $soloTransactions->merge($teamTransactions);
        // dd($transactions->count());
        // Set the timezone to Asia/Manila
        $timezone = 'Asia/Manila';
        $today = Carbon::now($timezone);

        // Filter for ongoing transactions
        $ongoingTransactions = $transactions->filter(function ($transaction) use ($today) {
            $startDate = Carbon::parse($transaction->event->start_date);
            $endDate = Carbon::parse($transaction->event->end_date);

            $madeaReview = null;

            //if its team
            if ($transaction->team_code) {
                $madeaReview =  $transaction->reviews()->where('reviewee_role', 'client')->exists();
            } elseif ($transaction->freelancer_id) {
                //check if the freelancer made a review
                $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists();
            }

            // Include transactions with "On-going" status or that is ongoing by date
            return ($transaction->transaction_status === 'Ongoing' && $madeaReview !== true) || $today->between($startDate, $endDate);
        })->sortBy(function ($transaction) {
            // Sort by the event's start_date
            return Carbon::parse($transaction->event->start_date);
        });

        // Filter for upcoming transactions (start_date is in the future)
        $upcomingTransactions = $transactions->filter(function ($transaction) use ($today) {
            return Carbon::parse($transaction->event->start_date)->greaterThan($today) && $transaction->transaction_status === 'Pending';
        });

        // Filter for previous transactions (end_date is in the past)
        $previousTransactions = $transactions->filter(function ($transaction) use ($today) {


            $madeaReview = null;
            //if its team
            if ($transaction->team_code) {
                $madeaReview =  $transaction->reviews()->where('reviewee_role', 'team')->exists();
            } elseif ($transaction->freelancer_id) {
                //check if the freelancer made a review
                $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists();
            }

            return Carbon::parse($transaction->event->end_date)->lessThan($today)
                && $transaction->transaction_status !== 'Ongoing' && $madeaReview; // Exclude "On-going" transactions because of unpaid or unsettled payments or review unless freelancer's transaction is done
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
