<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Job_application;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Notifications\ApplicationReceived;
use App\Notifications\ApplicationRejected;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        Log::info('Apply Job:', $validated);

        // Retrieve the job being applied for
        $eventJob = EventJob::find($validated['apply_as']);

        if (!$eventJob) {
            return response()->json(['error' => 'Invalid job selected.'], 400);
        }

        // Retrieve the event associated with the job
        $event = $eventJob->event;

        // Get the start and end time of the event being applied for
        $jobStartTime = $event->start_date;
        $jobEndTime = $event->end_date;

        // Find all transactions for the freelancer
        $transactions = Transaction::where('freelancer_id', $validated['user_id'])->where('job_id', '!=', $eventJob->job_id)->get();

        foreach ($transactions as $transaction) {
            // Get the event associated with the freelancer's transaction
            $transactionEvent = EventJob::find($transaction->job_id)->event;

            // Check if the event times of the transaction overlap with the job's event time
            if ($transactionEvent->start_date <= $jobEndTime && $transactionEvent->end_date >= $jobStartTime) {

                $start_date = Carbon::parse($transactionEvent->start_date)->format('M j, Y h:i A'); // Month Year
                $end_date = Carbon::parse($transactionEvent->end_date)->format('M j, Y h:i A'); // Full end date with time

                return response()->json([
                    'conflict' => 'Applying to this event results in schedule conflicts.',
                    'event' => $transactionEvent->title,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ], 400);
            }
        }

        // Check if the freelancer has already applied for the same job
        $existingApplication = Job_application::where('job_id', $validated['apply_as'])
            ->where('freelancer_id', $validated['user_id'])
            ->first();

        if ($existingApplication) {
            return response()->json(['warning' => 'You have already applied for this job.'], 400);
        } else {
            Job_application::create([
                'job_id' => $validated['apply_as'],
                'freelancer_id' => $validated['user_id'],
                'service_id' => $validated['service_id'],
                'status' => 'Pending',
            ]);

            // Notify the client about the new applicant
            $client = $event->client->user; //the client who posted the job
            $client->notify(new ApplicationReceived($event));

            Log::info('Application submitted successfully for:', [
                'job_id' => $validated['apply_as'],
                'freelancer_id' => $validated['user_id']
            ]);


            return response()->json(['success' => 'Application submitted successfully']);
        }
    }



    public function rejectApplicant(Request $request, $job_id)
    {
        $freelancerId = $request->query('freelancer_id');

        $jobApplication = Job_application::where('job_id', $job_id)
            ->where(function ($query) use ($freelancerId) {
                if (is_numeric($freelancerId)) {
                    $query->where('freelancer_id', $freelancerId);
                } else {
                    $query->where('team_code', $freelancerId);
                }
            })
            ->first();


        if ($jobApplication) {
            $jobApplication->status = 'Rejected';
            $jobApplication->save();

            // Notify the freelancer about the rejection
            if(is_numeric($freelancerId)){
                $freelancer = $jobApplication->freelancer->user; //get the freelancer
                $freelancer->notify(new ApplicationRejected($jobApplication->eventJob));
            } else {
                $teamLeader = User::where('id', $jobApplication->team->team_leader)->first();
                $teamLeader->notify(new ApplicationRejected($jobApplication->eventJob));
            }
           
            return redirect()->back()->with('success', 'Application rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'Job application not found.');
        }
    }
}
