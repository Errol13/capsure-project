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

        $completedHiredCounts = collect();

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
                $query->where('job_title', $job->service_needed)
                    ->where('job_category', $job->job_category);
            })
                ->with(['user', 'services']) // Eager load the user and services relationships
                ->get();

            $recommendations = $recommendations->merge($jobRecommendations); // Merge recommendations

            //getting hired freelaners count for each job
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

        if ($user->user_type === 'client'){
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
            ]);
        }
    }
}
