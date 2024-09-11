<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Notifications\HiringRequestSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Hiring_requestController extends Controller
{
    // Hire freelancer
    public function hireFreelancer(Request $request)
    {
        Log::info('Request Data:', $request->all());

        // Clean and convert client_pricing and freelancer_pricing
        $clientPricing = str_replace(['₱', ','], '', $request->input('client_pricing'));
        $freelancerPricing = str_replace(['₱', ','], '', $request->input('freelancer_pricing'));

        Log::info('Cleaned client_pricing:', ['client_pricing' => $clientPricing]);
        Log::info('Cleaned freelancer_pricing:', ['freelancer_pricing' => $freelancerPricing]);

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
            'client_pricing' => 'required|numeric|min:0',
            'freelancer_pricing' => 'required|numeric|min:0',
        ]);

        Log::info('Validated Data:', $validated);

        $eventJob = EventJob::find($validated['job_id']);
        $event = $eventJob->event;

        $jobStartTime = $event->start_time;
        $jobEndTime = $event->end_time;

        $transactions = Transaction::where('freelancer_id', $validated['freelancer_id'])->get();

        foreach ($transactions as $transaction) {
            $transactionEvent = EventJob::find($transaction->job_id)->event;

            if ($transactionEvent->start_time < $jobEndTime && $transactionEvent->end_time > $jobStartTime) {
                return response()->json(['error' => 'The freelancer was already hired for the same schedule.'], 400);
            }
        }

        Hiring_request::create([
            'freelancer_id' => $validated['freelancer_id'],
            'job_id' => $validated['job_id'],
            'client_id' => $validated['client_id'],
            'client_pricing' => $validated['client_pricing'],
            'freelancer_pricing' => $validated['freelancer_pricing'],
            'status' => 'Pending'
        ]);

        //make the job_application status to accepted
        $acceptedJobApplication = Job_application::where('job_id', $eventJob->job_id)->where('freelancer_id', $validated['freelancer_id'])->first();
        $acceptedJobApplication->status = 'Accepted';
        $acceptedJobApplication->save();

        // Retrieve client and event details
        $client = User::find($validated['client_id']);
        $eventTitle = $eventJob->event->title; // Adjust if you use a different field for event title

        // Notify the freelancer
        $freelancer = User::find($validated['freelancer_id']); // Assuming User model is used
        $freelancer->notify(new HiringRequestSent($client->first_name, $eventTitle));

        return redirect()->back()->with('success', 'Hiring request was sent successfully!');
    }


    //edit the offer, negotiation
    public function negotiatePrice(){

    }
}
