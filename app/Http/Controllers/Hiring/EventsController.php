<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function showEventsForm()
    {
        return view('client.createEvent');
    }

    public function showMyEvents()
    {
        /** @var User $user */
        $user = Auth::user();

        // Get events for the authenticated user that have associated event_jobs
        $events = Event::where('client_id', $user->id)
            ->whereHas('event_jobs') // Ensure the event has associated event_jobs
            ->orderBy('created_at') // Order by creation time
            ->get();

        return view('client.c_myEvents', compact('events'));
    }


    public function showViewPost($id)
    {
        // Fetch the event by its ID
        $event = Event::findOrFail($id);

        
        $event->start_date_formatted = Carbon::parse($event->start_date)->format('F j, Y h:i A'); // Month Year
        $event->end_date_formatted = Carbon::parse($event->end_date)->format('F j, Y h:i A'); // Full end date with time

        // Get all jobs associated with this event
        $jobs = EventJob::where('event_id', $id)->get();

        // Initialize collections to hold data
        $jobApplications = collect();
        $applicants = collect();
        $recommendations = collect();

        $recommendations = collect(); 

        foreach ($jobs as $job) {
            // Fetch job applications
            $applications = Job_application::where('job_id', $job->job_id)->get();
            $jobApplications = $jobApplications->merge($applications);

            // Fetch freelancers who applied for the job
            foreach ($applications as $application) {
                $freelancer = Freelancer::where('freelancer_id', $application->freelancer_id)->first();
                if ($freelancer) {
                    $applicants->push($freelancer);
                }
            }

            // Fetch recommendations
            $jobRecommendations = Freelancer::whereHas('services', function ($query) use ($job) {
                $query->where('job_title', $job->service_needed);
            })->get();

            $recommendations = $recommendations->merge($jobRecommendations); // Merge recommendations
        }


        // Get freelancers who have been sent hiring requests for the event's jobs
        $hiringRequests = Hiring_request::whereIn('job_id', $jobs->pluck('job_id'))->get();
        $invitedFreelancers = Freelancer::whereIn('user_id', $hiringRequests->pluck('freelancer_id'))->get();

        // Check transactions to see how many hires, completed jobs, and no hires
        $transactions = Transaction::whereIn('job_id', $jobs->pluck('job_id'))->get();

        // Determine hiring status counts
        $hiredCount = $transactions->count();
        $completedCount = $transactions->where('transaction_status', 'completed')->count();
        $noHireCount = $jobs->count() - $hiredCount;

        $tabs = [
            'application' => 'Applications',
            'hiring-requests' => 'Hiring Requests',
            'recommended' => 'Recommendations'
        ];

        $badgeCounts = [
            'application' => $jobApplications->count(),
            'hiring-requests' => $invitedFreelancers->count(),
            'recommended' => $transactions->where('transaction_status', 'completed')->count()
        ];

        return view('client.c_viewpost', [
            'event' => $event,
            'eventJobs' => $jobs,
            'jobApplications' => $jobApplications,
            'applicants' => $applicants,
            'hiringRequests' => $invitedFreelancers,
            'recommendations' => $recommendations,
            'hiredCount' => $hiredCount,
            'completedCount' => $completedCount,
            'noHireCount' => $noHireCount,
            'tabs' => $tabs,
            'badgeCounts' => $badgeCounts
        ]);
    }
}
