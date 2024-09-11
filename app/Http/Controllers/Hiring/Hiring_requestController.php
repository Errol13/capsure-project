<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Hiring_requestController extends Controller
{
    // Hire freelancer
    public function hireFreelancer(Request $request)
    {

        // Clean and convert client_pricing and freelancer_pricing
        $clientPricing = str_replace(['₱', ','], '', $request->input('client_pricing'));

        // Convert cleaned value to float
        $cleanedData = [
            'client_pricing' => (float) $clientPricing,
        ];

        // Validate the request data
        $validated = $request->validate([
            'freelancer_id' => 'required|exists:freelancers,user_id',
            'job_id' => 'required|exists:event_jobs,job_id',
            'client_id' => 'required|exists:clients,user_id',
            'client_pricing' => 'required|numeric|min:0',
            'freelancer_pricing' => 'required|numeric|min:0',
        ]);
        

        // Merge cleaned data with validated data
        $validated = array_merge($validated, $cleanedData);

        Log::info('Validated Data:', $validated);

        // Get the event job
        $eventJob = EventJob::find($validated['job_id']);
        $event = $eventJob->event;

        // Get the start and end time of the event being applied for
        $jobStartTime = $event->start_time;
        $jobEndTime = $event->end_time;

        // Find all transactions for the freelancer
        $transactions = Transaction::where('freelancer_id', $validated['freelancer_id'])->get();

        foreach ($transactions as $transaction) {
            // Get the event associated with the freelancer's transaction
            $transactionEvent = EventJob::find($transaction->job_id)->event;

            // Check if the event times of the transaction overlap with the job's event time
            if ($transactionEvent->start_time < $jobEndTime && $transactionEvent->end_time > $jobStartTime) {
                return response()->json(['error' => 'The freelancer was already hired for the same schedule.'], 400);
            }
        }

        // If available, store and send the hiring request
        Hiring_request::create([
            'freelancer_id' => $validated['freelancer_id'],
            'job_id' => $validated['job_id'],
            'client_id' => $validated['client_id'],
            'client_pricing' => $validated['client_pricing'],
            'freelancer_pricing' => $validated['freelancer_pricing'],
            'status' => 'Pending'
        ]);

        return redirect()->back()->with('success', 'Hiring request was sent successfully!');
    }
}
