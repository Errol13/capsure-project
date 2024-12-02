<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Profile\Service;
use App\Models\Profile\Team;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    public function showEventsForm()
    {
        return view('client.createEvent');
    }

    public function showMyEvents(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Get the status filter from the request, default to 'All' if not provided
        $status = $request->input('status', 'All');

        // Get events for the authenticated user
        $eventsQuery = Event::where('client_id', $user->id)
            ->whereHas('event_jobs')
            ->orderBy('created_at'); //displays from oldest to latest

        // Apply filtering by status if it's not 'All'
        if ($status != 'All') {
            $eventsQuery->where('status', $status);
        }

        $events = $eventsQuery->get();

        // Get counts for each event 
        $eventsWithCounts = $events->map(function ($event) {
            // Initialize counters
            $hiredCount = 0;
            $jobApplicationsCount = 0;
            $hiringRequestsCount = 0;

            // Get all jobs associated with this event
            $jobs = EventJob::where('event_id', $event->event_id)->get();

            foreach ($jobs as $job) {
                // Fetch job applications
                $applications = Job_application::where('job_id', $job->job_id)->where('status', '!=', 'Accepted')
                ->where('status', '!=', 'Rejected')->get();
                $jobApplicationsCount += $applications->count();

                // Getting hired freelancers count for each job
                $jobApplicantsHired = Transaction::where('job_id', $job->job_id)->get();
                $hiredCount += $jobApplicantsHired->count();

                // Get hiring requests count for the event's jobs
                $hiringRequestsCount += Hiring_request::where('job_id', $job->job_id)->where('status', '!=', 'Accepted')
                ->where('status', '!=', 'Rejected')->count();
            }

            // Add counts to the event object
            $event->hiredCount = $hiredCount;
            $event->jobApplicationsCount = $jobApplicationsCount;
            $event->hiringRequestsCount = $hiringRequestsCount;

            return $event;
        });

        return view('client.c_myEvents', [
            'events' => $eventsWithCounts,
            'status' => $status, // Pass current status to view for active filter indication
        ]);
    }




    public function showViewPost($id)
    {
        // Fetch the event by its ID
        $event = Event::findOrFail($id);

        $event->start_date_formatted = Carbon::parse($event->start_date)->format('M j, Y h:i A'); // Month Year
        $event->end_date_formatted = Carbon::parse($event->end_date)->format('M j, Y h:i A'); // Full end date with time

        //compute the event's duration
        $start = Carbon::parse($event->start_date);
        $end = Carbon::parse($event->end_date);
        $durationInHours = $start->diffInHours($end);

        // Get all jobs associated with this event
        $jobs = EventJob::where('event_id', $id)->get(); //eventjob

        // Initialize collections to hold data
        $jobApplications = collect();
        $applicants = collect();
        $recommendations = collect();
        $completedHiredCounts = collect();
        $teamRecommendations = collect();
        $teamApplicants = collect(); // for team applicants


        foreach ($jobs as $job) {

            // Fetch the EventJob model for the specific job_id
            $eventJob = EventJob::findOrFail($job->job_id);
            $serviceNeeded = $eventJob->service_needed;

            // Fetch job applications
            $applications = Job_application::where('job_id', $job->job_id)->get();
            $jobApplications = $jobApplications->merge($applications);

            // Fetch teams who applied for the job
            // $teamApplicantsData = $job->teamApplicants()->withPivot('status')->get();

            // dd($applications);
            // DB::enableQueryLog();
            $teamApplicantsData = $job->teamApplicants();
            // dd(DB::getQueryLog());

            foreach ($teamApplicantsData as $team) {
                $teamData = $team->toArray(); // Convert all fields of the team model into an array

                $teamData['job_id'] = $job->job_id; // Include the job ID
                $teamData['status'] = $team->status; // Job application status

                // Add the enriched team data to the collection
                $teamApplicants->push($teamData);
            }

            // Remove duplicates by `team_code`
            $teamApplicants = $teamApplicants->unique('team_code');

            // Fetch freelancers who applied for the job
            $jobApplicants = $job->applicants()->with('services')->get();

            // Iterate over the applicants to include job details
            foreach ($jobApplicants as $applicant) {

                //Fetch specific Job Applications for a specific freelancer
                $freelancerServiceDetails = Job_application::select(['service_id', 'status'])
                    ->where('job_id', $job->job_id)
                    ->where('freelancer_id', $applicant->user_id)
                    ->first();

                if ($freelancerServiceDetails) {
                    $service = $freelancerServiceDetails->service_id;
                    $status = $freelancerServiceDetails->status;
                } else {
                    $service = null;
                }

                // Get the freelancer's service data
                $freelancerService = $applicant->services()->where('id', $service)->first();

                // Add the applicant with additional job details
                $applicants->push([
                    'applicant' => $applicant,
                    'service_needed' => $serviceNeeded,
                    'service' => $freelancerService,
                    'job_id' => $job->job_id,
                    'status' => $status
                ]);
            }


            // //display the contents for debugging
            // Log::info('Applicants Data: ', $applicants ? $applicants->toArray() : []);

            // Sort applicants by status: 'Pending' first, 'Rejected' last
            $sortedApplicants = $applicants->sortBy(function ($applicant) {
                switch ($applicant['status']) {
                    case 'Pending':
                        return 0; // pending should be first shown
                    case 'Accepted':
                        return 1; // followed by accepted
                    case 'Rejected':
                        return 2; //last those who are rejected
                }
            });


            // Fetch recommendations
            $jobRecommendations = Freelancer::whereHas('services', function ($query) use ($job) {
                $query->where('job_title', $job->service_needed)
                    ->where('job_category', $job->job_category);
            })
                ->whereDoesntHave('appliedJobs', function ($query) use ($job) {
                    $query->where('id', $job->job_id); // Exclude those who applied 
                })
                ->with(['user', 'services']) // Eager load the user and services relationships
                ->orderBy('avg_rating', 'desc') // Sort by avg_rating in descending order
                ->orderBy('user_id', 'asc') // Sort by id in ascending order
                ->get();


            $recommendations = $recommendations->merge($jobRecommendations)->unique('user_id'); // Merge recommendations


            // Fetch team recommendations based on package_service
            $teamRecommendationsForJob = Team::where('package_service', $job->service_needed)
                ->whereDoesntHave('jobApplications', function ($query) use ($job) {
                    $query->where('id', $job->job_id);
                })
                ->with('memberships')
                ->orderBy('avg_rating', 'desc') // Sort by team rating
                ->get();

            // Merge team recommendations into the main collection
            $teamRecommendations = $teamRecommendations->merge($teamRecommendationsForJob);

            // Getting hired freelancers count for each job
            $jobApplicantsHired = Transaction::where('job_id', $job->job_id)->get();
            $hiredCount = $jobApplicantsHired->count();

            //delete the remaining pending hiring requests and job applications if full
            if ($eventJob->number_of_people === $hiredCount) {

                //fdelete the pending hiring requests
                $eventJob->hiringRequests()->where('status', 'Pending')->delete();

                //delete the job applications that are pending for this job
                $eventJob->jobApplications()->where('status', 'Pending')->delete();
            }

            // Store the count of hired freelancers for the job
            $completedHiredCounts->put($job->job_id, $hiredCount);
        }


        // Get freelancers who have been sent hiring requests for the event's jobs
        $hiringRequests = Hiring_request::whereIn('job_id', $jobs->pluck('job_id'))->get();

        //Attach service details to each hiring request
        $hiringRequests->each(function ($hiringRequest) {
            $serviceDetails = $hiringRequest->serviceDetails();
            $hiringRequest->serviceDetails = $serviceDetails;
        });

        $invitedFreelancers = Freelancer::with('user')->whereIn('user_id', $hiringRequests->pluck('freelancer_id'))->get();

        // Attach service details to each freelancer
        $invitedFreelancers->each(function ($freelancer) use ($hiringRequests) {
            // Find the hiring request for the current freelancer
            $hiringRequest = $hiringRequests->firstWhere('freelancer_id', $freelancer->user_id);
            if ($hiringRequest) {
                $freelancer->serviceDetails = $hiringRequest->serviceDetails;
                $freelancer->hiringRequestData = $hiringRequest; // Attach the hiring request data

                //display the contents for debugging
                Log::info('Hiring Request Data: ', $freelancer->hiringRequestData ? $freelancer->hiringRequestData->toArray() : []);
            }
        });

        // Get team hiring requests
        $teamHiringRequests = Hiring_request::whereIn('job_id', $jobs->pluck('job_id'))
            ->whereNotNull('team_code')
            ->get();

        // Get invited teams based on team_code
        $invitedTeams = Team::with('memberships')
            ->whereIn('team_code', $teamHiringRequests->pluck('team_code'))
            ->get();

        // Attach relevant details from the team table to each team
        $invitedTeams->each(function ($team) use ($teamHiringRequests) {
            $hiringRequest = $teamHiringRequests->firstWhere('team_code', $team->team_code);
            if ($hiringRequest) {
                $team->hiringRequestData = $hiringRequest;

                // Retrieve only the fillable attributes
                $teamDetails = $team->only([
                    'team_code',
                    'team_name',
                    'team_profilepic',
                    'team_leader',
                    'team_description',
                    'terms_of_services',
                    'number_of_projects',
                    'package_service',
                    'package_price',
                    'avg_rating'
                ]);

                // Attach the details for frontend use
                $team->details = $teamDetails;
            }
        });


        $tabs = [
            'application' => 'Applications',
            'hiring-requests' => 'Hiring Requests',
            'recommendation' => 'Recommendations'
        ];

        $badgeCounts = [
            'application' => $jobApplications->count(),
            'hiring-requests' => $invitedFreelancers->count() + $invitedTeams->count(),
            'recommendation' => $recommendations->count() + $teamRecommendations->count()
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
                $query->where('transaction_status', 'Done');
            })
            ->count();

        $hiringSuccessRate = 0;

        if ($successfulEvents > 0) {
            $hiringSuccessRate = ($successfulEvents / $clientTotalPosts) * 100;
        }
        // Log::info('Successfull Events:' . $successfulEvents);
        // Log::info('Hiring SUccess:' . $hiringSuccessRate);


        if ($user->user_type === 'client') {
            return view('client.c_viewpost', [
                'event' => $event,
                'eventJobs' => $jobs,
                'jobApplications' => $jobApplications,
                'applicants' => $sortedApplicants,
                'hiringRequests' => $invitedFreelancers,
                'recommendations' => $recommendations,
                'completedHiredCounts' => $completedHiredCounts,
                'tabs' => $tabs,
                'badgeCounts' => $badgeCounts,
                'durationInHours' => $durationInHours,
                'teamRecommendations' => $teamRecommendations,
                'teamApplicants' => $teamApplicants,
                'teamHiringRequests' => $invitedTeams
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

    //cancel event post

    public function closeEventPost($eventId)
    {

        //fetch the event
        $event = Event::where('event_id', $eventId)->first();

        if ($event) {
            $event->status = 'Closed';
            $event->save();

            return redirect()->back()->with('success', 'Event Post successfully closed.');
        } else {
            return redirect()->back()->with('error', 'Cannot found the event post.');
        }
    }

    //edit the post
    public function editPost($event_id) {}
}
