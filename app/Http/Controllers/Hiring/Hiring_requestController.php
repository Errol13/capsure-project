<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Profile\Team;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Notifications\AcceptedOffer;
use App\Notifications\HiringRequestSent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Hiring_requestController extends Controller
{
    // Hire freelancer
    public function hireFreelancer(Request $request)
    {
        // Log::info('Request Data LO:', $request->all());

        // Clean and convert client_pricing and freelancer_pricing
        $clientPricing = str_replace(['₱', ','], '', $request->input('client_pricing'));
        $freelancerPricing = str_replace(['₱', ','], '', $request->input('freelancer_pricing'));


        // Log::info('Cleaned client_pricing:', ['client_pricing' => $clientPricing]);
        // Log::info('Cleaned freelancer_pricing:', ['freelancer_pricing' => $freelancerPricing]);

        // Convert cleaned values to float
        $cleanedData = [
            'client_pricing' => (float) $clientPricing,
            'freelancer_pricing' => (float) $freelancerPricing,
        ];


        // Validate the request data with cleaned values
        $validated = $request->merge($cleanedData)->validate([
            'freelancer_id' => 'required|exists:freelancers,user_id',
            'job_id' => 'required|exists:event_jobs,job_id',
            'client_id' => 'required|exists:clients,user_id',
            'client_pricing' => 'required|numeric|min:1',
            'freelancer_pricing' => 'required|numeric|min:0',
        ]);

        // Log::info('Validated Data LO:', $validated);


        $eventJob = EventJob::find($validated['job_id']);
        $event = $eventJob->event;

        $jobStartTime = $event->start_date;
        $jobEndTime = $event->end_date;


        // Log::info('Validated Data:', $event->toArray());

        // Prevent duplication of hiring request
        $hiringRequestExists = Hiring_request::where('freelancer_id', $validated['freelancer_id'])
            ->where('job_id', $validated['job_id'])
            ->where('client_id', $validated['client_id'])
            ->exists();

        if ($hiringRequestExists) {
            return  response()->json(['error' => 'You already hired this freelancer.'], 400);
        }

        //count the hired for this job, if full return error if not then proceed
        $completedHiredCounts = Transaction::where('job_id', $validated['job_id'])->count();

        //find the event job and compare the number of people needed
        $findEventJob = $event->event_jobs()->where('job_id', $validated['job_id'])->first();
        $numberOfPeople = $findEventJob->number_of_people;

        // Check if there are available slots for hiring
        $noAvailableSlot = $numberOfPeople <= $completedHiredCounts;

        if ($noAvailableSlot) {
            return response()->json(['error' => 'No available slots for this job.'], 400);
        }

        $hasTransactions = Transaction::where('freelancer_id', $validated['freelancer_id'])->exists();

        if ($hasTransactions) {
            // Check for overlapping transactions
            $overlappingTransaction = Transaction::where('freelancer_id', $validated['freelancer_id'])
                ->join('event_jobs', 'transactions.job_id', '=', 'event_jobs.job_id')
                ->join('events', 'event_jobs.event_id', '=', 'events.event_id')
                ->whereNotNull('events.start_date')
                ->whereNotNull('events.end_date')
                ->where(function ($query) use ($jobStartTime, $jobEndTime) {
                    $query->where(function ($q) use ($jobStartTime, $jobEndTime) {
                        $q->where('events.start_date', '<', $jobEndTime)
                            ->where('events.end_date', '>', $jobStartTime);
                    });
                })
                ->exists();

            if ($overlappingTransaction) {
                return response()->json(['error' => 'The freelancer was already hired for the same schedule.'], 400);
            }
        }

        Hiring_request::create([
            'freelancer_id' => $validated['freelancer_id'],
            'job_id' => $validated['job_id'],
            'client_id' => $validated['client_id'],
            'client_pricing' => $validated['client_pricing'],
            'freelancer_pricing' => $validated['freelancer_pricing'],
            'dealer_user_type' => 'client',
            'status' => 'Pending'
        ]);


        // Update job application status
        $acceptedJobApplication = Job_application::where('job_id', $eventJob->job_id)
            ->where('freelancer_id', $validated['freelancer_id'])
            ->first();

        //if there is a job application update the status
        if ($acceptedJobApplication) {
            $acceptedJobApplication->update(['status' => 'Accepted']);
        }

        // Retrieve client and event details
        $client = User::find($validated['client_id']);
        $eventTitle = $eventJob->event->title;

        // Notify the freelancer
        $freelancer = User::find($validated['freelancer_id']);
        $freelancer->notify(new HiringRequestSent($client->first_name, $eventTitle));

        if ($request->ajax()) {
            // Return JSON response for async requests
            return response()->json(['success' => 'Hired successfully.'], 200);
        }

        return redirect()->route('client-viewpost', ['id' => $event->event_id])->with('success', 'Hiring request was sent successfully!');
    }


    //edit the offer, negotiation
    public function negotiatePrice(Request $request)
    {
        // Log::info('Request Data:', $request->all());

        // Clean and convert client_pricing and freelancer_pricing
        $clientPricing = str_replace(['₱', ','], '', $request->input('client_pricing'));

        // Convert cleaned values to float
        $cleanedData = [
            'client_pricing' => (float) $clientPricing,
        ];

        // Validate the request data with cleaned values
        $validated =  $request->merge($cleanedData)->validate([
            'hiring_request_id' => 'required|exists:hiring_requests,hiring_request_id',
            'client_pricing' => 'required|numeric|min:0',
        ]);

        // Log::info('Validated Data:', $validated);

        //get the hiring request
        $hiringRequest = Hiring_request::find($validated['hiring_request_id']);

        $hiringRequest->client_pricing = $validated['client_pricing'];
        $hiringRequest->save();

        return redirect()->back()->with('success', 'Price was modified successfully.');
    }

    //cancel the offer

    public function cancelOffer($hiring_request_id)
    {
       
        
        //get the hiring request
        $hiringRequest = Hiring_request::find($hiring_request_id);

        //update the application change it from accepted to pending
        $jobApplication = $hiringRequest->getJobApplication();
       
        if ($jobApplication) {
            $jobApplication->status = 'Pending';
            $jobApplication->save();
            // Log::info('Retrieved Job App:', $jobApplication->toArray());
        }

        //delete the record
        $hiringRequest->delete();

        return redirect()->back()->with('success', 'Hiirng request was successfully cancelled.');
    }

    //decline an offer, action by freelancer
    public function declineOffer($hiring_request_id)
    {
        //get the hiring request
        $hiringRequest = Hiring_request::find($hiring_request_id);

        //update the hiring status from pending to rejected
        $hiringRequest->status = 'Rejected';
        $hiringRequest->save();

        return redirect()->back()->with('success', 'Hiring request was successfully cancelled.');
    }

    //accept the offer 

    public function acceptOffer($hiring_request_id)
    {

        //find the request
        $hiringRequest = Hiring_request::find($hiring_request_id);

        $completedHiredCounts = Transaction::where('job_id', $hiringRequest->eventjob->job_id)->count();

        //find the event job and compare the number of people needed
        $numberOfPeople = $hiringRequest->eventjob->number_of_people;

        // Check if there are available slots for hiring
        $noAvailableSlot = $numberOfPeople <= $completedHiredCounts;

        if ($noAvailableSlot) {
            return response()->json(['error' => 'No available slots for this job.'], 400);
        }
        //check if its existing

        if ($hiringRequest) {
            $hiringRequest->status = 'Accepted';
            $hiringRequest->save();

            //payment amount
            $paymentAmount = 0.0;

            if ($hiringRequest->dealer_user_type === 'client') {
                $paymentAmount = $hiringRequest->client_pricing;
            } elseif ($hiringRequest->dealer_user_type === 'freelancer') {
                $paymentAmount = $hiringRequest->freelancer_pricing;
            }

            //for freelancer solo
            if ($hiringRequest->freelancer_id) {
                Transaction::create([
                    'client_id' => $hiringRequest->client_id,
                    'freelancer_id' => $hiringRequest->freelancer_id,
                    'job_id' => $hiringRequest->job_id,
                    'hiring_request_id' => $hiringRequest->hiring_request_id,
                    'payment_amount' => $paymentAmount,
                    'payment_status' => 'Unpaid',
                    'transaction_status' => 'Pending'
                ]);

                /** @var User */
                $user = Auth::user();

                // Check if the user is a freelancer or client
                if ($user->user_type === 'client') {
                    $freelancer = User::where('id', $hiringRequest->freelancer_id)->first();
                    if ($freelancer) {
                        Log::info('Notifying freelancer: ' . $freelancer->email);
                        $freelancer->notify(new AcceptedOffer($hiringRequest, $user));
                    }
                } elseif ($user->user_type === 'freelancer') {
                    $client = User::where('id', $hiringRequest->client_id)->first();
                    if ($client) {
                        Log::info('Notifying client: ' . $client->email);
                        $client->notify(new AcceptedOffer($hiringRequest, $user));
                    }
                }
            } elseif ($hiringRequest->team_code) {
                Transaction::create([
                    'client_id' => $hiringRequest->client_id,
                    'team_code' => $hiringRequest->team_code,
                    'job_id' => $hiringRequest->job_id,
                    'hiring_request_id' => $hiringRequest->hiring_request_id,
                    'payment_amount' => $paymentAmount,
                    'payment_status' => 'Unpaid',
                    'transaction_status' => 'Pending'
                ]);

                /** @var User */
                $user = Auth::user();

                // Check if the user is a freelancer or client
                if ($user->user_type === 'client') {
                    $team = Team::where('team_code', $hiringRequest->team_code)->first();
                    $teamLeader = User::find($team->team_leader);
                    if ($teamLeader) {
                        // Log::info('Notifying freelancer: ' . $teamLeader->email);
                        $teamLeader->notify(new AcceptedOffer($hiringRequest, $user));
                    }
                } elseif ($user->user_type === 'freelancer') {
                    $client = User::where('id', $hiringRequest->client_id)->first();
                    if ($client) {
                        // Log::info('Notifying client: ' . $client->email);
                        $client->notify(new AcceptedOffer($hiringRequest, $user));
                    }
                }
            }

            return redirect()->back()->with('success', 'Offer accepted!');
        } else {
            return redirect()->back()->with('failed', 'No hiring request found');
        }
    }
}
