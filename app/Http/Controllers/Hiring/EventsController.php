<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Transaction;
use App\Models\User;
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

        $eventsWithCounts = $events->map(function ($event) {
            // Initialize counters
            $hiredCount = 0;
            $jobApplicationsCount = 0;
            $hiringRequestsCount = 0;

            // Get all jobs associated with this event
            $jobs = EventJob::where('event_id', $event->event_id)->get();

            foreach ($jobs as $job) {
                // Fetch job applications
                $applications = Job_application::where('job_id', $job->job_id)->get();
                $jobApplicationsCount += $applications->count();

                // Getting hired freelancers count for each job
                $jobApplicantsHired = Transaction::where('job_id', $job->job_id)->get();
                $hiredCount += $jobApplicantsHired->count();

                // Get hiring requests count for the event's jobs
                $hiringRequestsCount += Hiring_request::where('job_id', $job->job_id)->count();
            }

            // Add counts to the event object
            $event->hiredCount = $hiredCount;
            $event->jobApplicationsCount = $jobApplicationsCount;
            $event->hiringRequestsCount = $hiringRequestsCount;

            return $event;
        });

        return view('client.c_myEvents', [
            'events' => $eventsWithCounts,
        ]);
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
        $completedHiredCounts = collect();

        foreach ($jobs as $job) {
            // Fetch the EventJob model for the specific job_id
            $eventJob = EventJob::findOrFail($job->job_id);
            $serviceNeeded = $eventJob->service_needed;

            // Fetch job applications
            $applications = Job_application::where('job_id', $job->job_id)->get();
            $jobApplications = $jobApplications->merge($applications);

            // Fetch freelancers who applied for the job
            $jobApplicants = $job->applicants()->with('services')->get();

            // Iterate over the applicants to include job details
            foreach ($jobApplicants as $applicant) {
                // Get the freelancer's service data
                $freelancerService = $applicant->services()->where('job_title', $serviceNeeded)->first();

                // Assuming the fee is stored in the services table
                $fee = $freelancerService ? $freelancerService->job_fee : null;

                // Add the applicant with additional job details
                $applicants->push([
                    'applicant' => $applicant,
                    'service_needed' => $serviceNeeded,
                    'fee' => $fee,
                ]);
            }

            // Fetch recommendations
            $jobRecommendations = Freelancer::whereHas('services', function ($query) use ($job) {
                $query->where('job_title', $job->service_needed)
                    ->where('job_category', $job->job_category);
            })
                ->with(['user', 'services']) // Eager load the user and services relationships
                ->get();

            $recommendations = $recommendations->merge($jobRecommendations); // Merge recommendations

            // Getting hired freelancers count for each job
            $jobApplicantsHired = Transaction::where('job_id', $job->job_id)->get();
            $hiredCount = $jobApplicantsHired->count();

            // Store the count of hired freelancers for the job
            $completedHiredCounts->put($job->job_id, $hiredCount);
        }


        // Get freelancers who have been sent hiring requests for the event's jobs
        $hiringRequests = Hiring_request::whereIn('job_id', $jobs->pluck('job_id'))->get();
        $invitedFreelancers = Freelancer::whereIn('user_id', $hiringRequests->pluck('freelancer_id'))->get();

        $tabs = [
            'application' => 'Applications',
            'hiring-requests' => 'Hiring Requests',
            'recommendation' => 'Recommendations'
        ];

        $badgeCounts = [
            'application' => $jobApplications->count(),
            'hiring-requests' => $invitedFreelancers->count(),
            'recommendation' => $recommendations->count()
        ];

        
        $user = Auth::user();

        //for freelancers 
        $freelancer = Freelancer::whereHas('services')->where('user_id', $user->id)->first();


        // Event post's client's data
        $clientUser = User::where('id', $event->client_id)->with('client')->first();

        // Count the client's total job posts and hiring success rate
        $clientTotalPosts = Event::where('client_id', $clientUser->id)->count();

        $successfulEvents = Event::where('client_id', $clientUser->id)
            ->whereHas('event_jobs.transactions', function ($query) {
                $query->where('transaction_status', 'successful');
            })
            ->count();

        $hiringSuccessRate = 0;

        if ($successfulEvents > 0) {
            $hiringSuccessRate = ($successfulEvents / $clientTotalPosts) * 100;
        }

        if ($user->user_type === 'client') {
            return view('client.c_viewpost', [
                'event' => $event,
                'eventJobs' => $jobs,
                'jobApplications' => $jobApplications,
                'applicants' => $applicants,
                'hiringRequests' => $invitedFreelancers,
                'recommendations' => $recommendations,
                'completedHiredCounts' => $completedHiredCounts,
                'tabs' => $tabs,
                'badgeCounts' => $badgeCounts
            ]);
        } elseif ($user->user_type === 'freelancer') {
            return view('components.F_Hiring.event_post', [
                'event' => $event,
                'eventJobs' => $jobs,
                'jobApplications' => $jobApplications,
                'completedHiredCounts' => $completedHiredCounts,
                'clientUser' => $clientUser,
                'TotalPosts' => $clientTotalPosts,
                'hiringSuccessRate' => $hiringSuccessRate,
                'freelancer' => $freelancer,
            ]);
        }
    }
}
