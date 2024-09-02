<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Hiring\EventJob;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Transaction;
use Illuminate\Http\Request;

class Job_applicationController extends Controller
{
    //applying jobs

    public function applyJob(Request $request)
    {
        $validated = $request->validate([
            'apply_as' => 'required|exists:event_jobs,job_id',
            'user_id' => 'required|exists:freelancers,user_id',
            'service_id' => 'required|exists:services,id',
        ]);

        // Retrieve the job being applied for
        $eventJob = EventJob::find($validated['apply_as']);

        if (!$eventJob) {
            return response()->json(['error' => 'Invalid job selected.'], 400);
        }

        // Retrieve the event associated with the job
        $event = $eventJob->event;

        // Get the start and end time of the event being applied for
        $jobStartTime = $event->start_time;
        $jobEndTime = $event->end_time;

        // Find all transactions for the freelancer
        $transactions = Transaction::where('freelancer_id', $validated['user_id'])->get();

        foreach ($transactions as $transaction) {
            // Get the event associated with the freelancer's transaction
            $transactionEvent = EventJob::find($transaction->job_id)->event;

            // Check if the event times of the transaction overlap with the job's event time
            if ($transactionEvent->start_time < $jobEndTime && $transactionEvent->end_time > $jobStartTime) {
                return redirect()->back()->with([
                    'error' => 'Applying to this event results in schedule conflicts.',
                    'conflicting_event' => $transactionEvent
                ]);
            }
        }

        // Check if the freelancer has already applied for the same job
        $existingApplication = Job_application::where('job_id', $validated['apply_as'])
            ->where('freelancer_id', $validated['user_id'])
            ->first();

        if ($existingApplication) {
            return response()->json(['error' => 'You have already applied for this job.'], 400);
        }

        Job_application::create([
            'job_id' => $validated['apply_as'],
            'freelancer_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully');
    }
}
