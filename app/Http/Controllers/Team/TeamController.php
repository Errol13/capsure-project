<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\Hiring\Job_application;
use App\Models\Profile\Membership;
use App\Models\Profile\Team;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Notifications\ApplicationReceived;
use App\Notifications\HiringRequestSent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    //create team
    public function createTeam(Request $request)
    {

        // Validate the input data
        $validatedData = $request->validate([
            'team_name' => 'required|string|max:255',
            'package_service' => 'required|string|max:255',
            'package_price' => 'required|numeric|min:500',
            'team_description' => 'required|string|max:500',
            'team_profilepic' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $exists = Team::where('team_name', $request->team_name)->exists();

        if ($exists) {
            return redirect()->back()->with('failed', 'Team name is already taken');
        }

        //get authenticated user data
        $user = Auth::user();

        // Generate the team_code
        $teamCode = $this->generateTeamCode();

        // Handle the profile picture upload
        $profilePicFile = $request->file('team_profilepic');
        $originalName = pathinfo($profilePicFile->getClientOriginalName(), PATHINFO_FILENAME); // get the filename
        $extension = $profilePicFile->getClientOriginalExtension(); //get the extension
        $fileName = $originalName . '_' . $teamCode . '.' . $extension;

        $filePath = $profilePicFile->storeAs('team_profiles', $fileName, 'public'); //store in the team_profiles folder


        // Create the team
        $team = Team::create([
            'team_code' => $teamCode,
            'team_name' => $validatedData['team_name'],
            'team_profilepic' => $filePath,
            'team_leader' => $user->id,
            'team_description' => $validatedData['team_description'],
            'package_service' => $validatedData['package_service'],
            'package_price' => $validatedData['package_price'],
        ]);


        //get the services of the one joining the team
        $freelancerServices = $user->freelancer->services()->pluck('id')->toArray();

        // Create a membership record for the team leader
        Membership::create([
            'freelancer_id' => $user->id, // add in the membership
            'team_id' => $team->team_id,
            'services' => json_encode($freelancerServices), // Populate with freelancer's services
        ]);

        return redirect()->route('team-profile');
    }

    private function generateTeamCode()
    {
        do {
            $code = Str::upper(Str::random(6)); // Generate 6-character alphanumeric code
        } while (Team::where('team_code', $code)->exists()); // Ensure uniqueness

        return $code;
    }

    //showTeamPage
    public function showTeamProfile()
    {
        //get the authenticated's team
        $user = Auth::user();
        $team = $user->freelancer->team;

        //check if team exists
        if ($team) {
            // Fetch the applied jobs for the team, including related event_jobs and events
            $appliedJobs = $team->jobApplications()
                ->with('event_job.event') // Eager load event_job and its associated event
                ->get()
                ->map(function ($jobApplication) {
                    // Access the event from the event_job relationship
                    $event = $jobApplication->event_job->event;

                    // Format the event's start and end dates
                    $event->start_date_formatted = Carbon::parse($event->start_date)->format('M j, Y h:i A');
                    $event->end_date_formatted = Carbon::parse($event->end_date)->format('M j, Y h:i A');

                    return $jobApplication;
                });


            //for the hiring requests
            $hiringRequests = $team->hiringRequests()
                ->with(['eventjob.event'])
                ->get();

            foreach ($hiringRequests as $eachEvent) {
                $eachEvent->eventjob->event->start_date_formatted = Carbon::parse($eachEvent->eventjob->event->start_date)->format('M j, Y h:i A');
                $eachEvent->eventjob->event->end_date_formatted = Carbon::parse($eachEvent->eventjob->event->end_date)->format('M j, Y h:i A');
            }

            //the count badge of application
            $appliedJobsCount = $appliedJobs->count();

            //for the recommendations
            $eventRecommendations = Event::with('event_jobs')
                ->where('status', 'Open')
                ->whereHas('event_jobs', function ($query) use ($team) {
                    $query->where('service_needed', $team->package_service)
                        ->orWhere('job_category', 'Package');
                })
                ->whereDoesntHave('transactions', function ($query) use ($team) {
                    // Exclude events where the team has transactions 
                    $query->where('team_code', $team->team_code);
                })
                ->whereDoesntHave('event_jobs.jobApplications', function ($query) use ($team) {
                    // Exclude events where the team has already applied
                    $query->where('team_code', $team->team_code);
                })
                ->get();


            foreach ($eventRecommendations as $event) {
                $event->start_date_formatted = Carbon::parse($event->start_date)->format('M j, Y h:i A');
                $event->end_date_formatted = Carbon::parse($event->end_date)->format('M j, Y h:i A');
            }
            $allMembersVerified = $team->areAllMembersVerified();

            //get the freelancer's reviews made by the clients
            $reviews = $team->reviews()->with('transaction.event')->where('reviewee_role', 'team')->take(2)->get();

            //get the members
            $teamMembers = $team->freelancers;
            $membersCount = $teamMembers->count();
            $hiringRequestsCount = $hiringRequests->count();
            $eventsCount = $eventRecommendations->count();
            return view('freelancer.Team_profile', compact(
                'team',
                'allMembersVerified',
                'teamMembers',
                'membersCount',
                'eventRecommendations',
                'eventsCount',
                'appliedJobs',
                'appliedJobsCount',
                'hiringRequests',
                'hiringRequestsCount',
                'reviews'
            ));
        } else {
            return redirect()->back()->with('error', 'There is no team found!');
        }
    }

    public function viewTeamProfile($id)
    {
        //get the team
        $team = Team::find($id);

        //check if team exists
        if ($team) {
            $allMembersVerified = $team->areAllMembersVerified();
            //get the freelancer's reviews made by the clients
            $reviews = $team->reviews()->with('transaction.event')->where('reviewee_role', 'team')->take(2)->get();

            // Retrieve the events for the authenticated user
            $events = auth()->user()->events()->where('status', 'Open')->get();
            $events = $events->isEmpty() ? null : $events;

            //get the members
            $teamMembers = $team->freelancers;
            $membersCount = $teamMembers->count();
            return view('freelancer.team_view_profile', compact(
                'team',
                'allMembersVerified',
                'teamMembers',
                'membersCount',
                'reviews',
                'events'
            ));
        } else {
            return redirect()->back()->with('error', 'There is no team found!');
        }
    }

    //join team 
    public function joinTeam(Request $request)
    {
        $validated = $request->validate([
            'team_code' =>  'required|string|min:6|regex:/^[a-zA-Z0-9]+$/',
        ]);

        $team_code = Str::upper($validated['team_code']);


        //check if there is a team with that code
        $foundTeam = Team::where('team_code', $team_code)->first();

        //user data
        $user = Auth::user();
        //if there is, join the membership
        if ($foundTeam) {

            //if rejoining 
            $membershipExists = $foundTeam->memberships()->where('freelancer_id', $user->id)->exists();

            if ($membershipExists) {
                $membership = Membership::where('freelancer_id', $user->id)->where('team_id', $foundTeam->team_id)->first();
                $membership->services = $user->freelancer->services->pluck('id');
                $membership->created_at = Carbon::now('Asia/Manila');
                $membership->status = 'active'; // re-activate membership
                $membership->save();
            } else {
                //get the services of the one joining the team
                $freelancerServices = $user->freelancer->services()->pluck('id')->toArray();

                // Create a membership record for the team leader
                Membership::create([
                    'freelancer_id' => $user->id, // add in the membership
                    'team_id' => $foundTeam->team_id,
                    'services' => $freelancerServices, // Populate with freelancer's services
                ]);

                //isin_A_Team to true
                $user->freelancer->isin_A_Team = true;
                $user->freelancer->save();
            }

            //then redirect to the team profile
            return redirect()->route('team-profile');
        } else {
            return back()->withErrors(['team_code' => 'The provided team code does not exist.'])->withInput();
        }
    }

    //team apply 
    public function applyAsATeam(Request $request)
    {

        $validated = $request->validate([
            'job_available' => 'required|exists:event_jobs,job_id', // the job id
            'user_id' => 'required', // the team code
            'team_service_id' => 'required', //this is the team id
        ]);


        // Retrieve the job being applied for
        $eventJob = EventJob::find($validated['job_available']);

        if (!$eventJob) {
            return response()->json(['error' => 'Invalid job selected.'], 400);
        }

        // Retrieve the event associated with the job
        $event = $eventJob->event;

        // Get the start and end time of the event being applied for
        $jobStartTime = $event->start_date;
        $jobEndTime = $event->end_date;


        // Find all transactions for the team
        $transactions = Transaction::where('team_code', $validated['user_id'])->where('job_id', '!=', $eventJob->job_id)->get();

        if ($transactions->isNotEmpty()) {
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
        }

        // Check if the freelancer has already applied for the same job
        $existingApplication = Job_application::where('job_id', $validated['job_available'])
            ->where('team_code', $validated['user_id'])
            ->first();

        if ($existingApplication) {
            return response()->json(['warning' => 'You have already applied for this job.'], 400);
        } else {
            Job_application::create([
                'job_id' => $validated['job_available'],
                'team_code' => $validated['user_id'], //this is the team_code
                'service_id' => $validated['team_service_id'], //this is the team_id
                'status' => 'Pending',
            ]);

            // Notify the client about the new applicant
            $client = $event->client->user; //the client who posted the job
            $client->notify(new ApplicationReceived($event));

            // Log::info('Application submitted successfully for:', [
            //     'job_id' => $validated['apply_as'],
            //     'freelancer_id' => $validated['user_id']
            // ]);

            return response()->json(['success' => 'Application submitted successfully']);
        }
    }

    public function cancelTeamApplication(Request $request)
    {

        $validated = $request->validate([
            'job_id' => 'required',
        ]);

        /** @var User */
        $user = Auth::user();
        $team = $user->freelancer->team;

        if ($team) {
            // Delete only the application for the specific job and freelancer
            Job_application::where('job_id', $validated['job_id'])
                ->where('team_code', $team->team_code)
                ->delete();

            return redirect()->back()->with('success', 'Job Application deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Team not found');
        }
    }

    //team hiring request
    public function teamHiringRequest(Request $request)
    {
        // Clean and convert client_pricing and freelancer_pricing
        $clientPricing = str_replace(['₱', ','], '', $request->input('client_pricing'));
        $freelancerPricing = str_replace(['₱', ','], '', $request->input('freelancer_pricing'));

        // Convert cleaned values to float
        $cleanedData = [
            'client_pricing' => (float) $clientPricing,
            'freelancer_pricing' => (float) $freelancerPricing,
        ];

        // Log::info('PRICES TEAM:', $cleanedData);
        // Validate the request data with cleaned values
        $validated = $request->merge($cleanedData)->validate([
            'team_code' => 'required',
            'job_id' => 'required|exists:event_jobs,job_id',
            'client_id' => 'required|exists:clients,user_id',
            'client_pricing' => 'required|numeric|min:1',
            'freelancer_pricing' => 'required|numeric|min:1',
        ]);


        // Log::info('Validated Data Team:', $validated);

        $eventJob = EventJob::find($validated['job_id']);
        $event = $eventJob->event;

        $jobStartTime = $event->start_date;
        $jobEndTime = $event->end_date;

        // Log::info('Validated Data:', $event->toArray());

        // Prevent duplication of hiring request
        $hiringRequestExists = Hiring_request::where('team_code', $validated['team_code'])
            ->where('job_id', $validated['job_id'])
            ->where('client_id', $validated['client_id'])
            ->exists();

        if ($hiringRequestExists) {
            return  response()->json(['error' => 'You already hired this freelancer.'], 400);
        }

        // dd('TRIGERED');
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

        $hasTransactions = Transaction::where('team_code', $validated['team_code'])->exists();

        if ($hasTransactions) {
            // Check for overlapping transactions
            $overlappingTransaction = Transaction::where('team_code', $validated['team_code'])
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
            'team_code' => $validated['team_code'],
            'job_id' => $validated['job_id'],
            'client_id' => $validated['client_id'],
            'client_pricing' => $validated['client_pricing'],
            'freelancer_pricing' => $validated['freelancer_pricing'],
            'dealer_user_type' => 'client',
            'status' => 'Pending'
        ]);


        // Update job application status
        $acceptedJobApplication = Job_application::where('job_id', $eventJob->job_id)
            ->where('team_code', $validated['team_code'])
            ->first();

        //if there is a job application update the status
        if ($acceptedJobApplication) {
            $acceptedJobApplication->update(['status' => 'Accepted']);
        }

        // Retrieve client and event details
        $client = User::find($validated['client_id']);
        $eventTitle = $eventJob->event->title;

        // Notify the team leader
        $team = Team::find($validated['team_code']);
        $teamLeader = User::where('id', $team->team_leader)->first();
        $teamLeader->notify(new HiringRequestSent($client->first_name, $eventTitle));

        if ($request->ajax()) {
            // Return JSON response for async requests
            return response()->json(['success' => 'Hired successfully.'], 200);
        }

        return redirect()->route('client-viewpost', ['id' => $event->event_id])->with('success', 'Hiring request was sent successfully!');
    }

    public function editTeam(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,team_id',
            'team_name' => 'nullable|string|max:255',
            'package_service' => 'nullable|string|max:255',
            'package_price' => 'nullable|numeric|min:500',
            'team_description' => 'nullable|string|max:500',
            'team_profilepic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // dd($validated);

        // Find the team
        $team = Team::find($validated['team_id']);

        // Handle profile picture upload
        if ($request->hasFile('team_profilepic')) {
            // Delete the old profile picture if it exists
            if ($team->team_profilepic) {
                $oldFilePath = public_path('storage/' . $team->team_profilepic);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Delete the old file
                }
            }

            // Upload the new profile picture
            $profilePicFile = $request->file('team_profilepic');
            $originalName = pathinfo($profilePicFile->getClientOriginalName(), PATHINFO_FILENAME); // Get the original filename
            $extension = $profilePicFile->getClientOriginalExtension(); // Get the extension
            $fileName = $originalName . '_' . $team->team_code . '.' . $extension;

            // Store the new profile picture in the 'team_profiles' folder
            $filePath = $profilePicFile->storeAs('team_profiles', $fileName, 'public');

            // Update the team with the new profile picture path
            $validated['team_profilepic'] = 'team_profiles/' . $fileName;
        }

        $team->update($validated);

        return redirect()->back()->with('success', 'Team edited successfully');
    }


    public function editService(Request $request)
    {
        // Fetch the authenticated user's freelancer data
        $user = Auth::user();
        $freelancer = $user->freelancer;

        // Get the member's current services offered to the team
        $member = $freelancer->membership->first();


        $currentServices = $member->services ?? [];
        // dd($currentServices);
        // Retrieve selected services from the form submission
        $selectedServices = array_keys($request->input('services', []));

        // dd($selectedServices);
        // Determine services to add and remove
        $servicesToAdd = array_diff($selectedServices, $currentServices);
        $servicesToRemove = array_diff($currentServices, $selectedServices);

        // dd('Selected:', $selectedServices, 'To be Removed:', $servicesToRemove);
        // Update the services JSON
        $updatedServices = array_diff($currentServices, $servicesToRemove); // Remove unchecked services
        $updatedServices = array_merge($updatedServices, $servicesToAdd); // Add newly selected services

        // Save the updated services back to the member
        $member->services = $updatedServices;
        // dd($member->services); 
        $member->save();

        return redirect()->back()->with('success', 'Service availability updated successfully.');
    }

    public function editTerms(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,team_id',
            'terms_of_services' => 'nullable|string|max:500',
        ]);

        // Find the team
        $team = Team::find($validated['team_id']);
        $team->update($validated);

        return redirect()->back()->with('success', 'Service availability updated successfully.');
    }

    //change admin 
    public function changeAdmin(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,team_id',
            'freelancer_id' => 'required',
        ]);

        //change the tean's admin to the new freelancer/member
        $team = Team::find($validated['team_id']);
        $team->team_leader = $validated['freelancer_id'];
        $team->save();

        return redirect()->back()->with('success', 'Admin changed successfully!');
    }

    //leave team
    public function leaveTeam()
    {
        $freelancer = auth()->user()->freelancer;
        $membership = $freelancer->membership()->first();


        if ($freelancer->user_id === $membership->team->team_leader) {
            // Get the next oldest member with active status
            $nextAdmin = $membership->team->memberships()
                ->where('status', 'active')
                ->where('freelancer_id', '!=', $freelancer->user_id)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($nextAdmin) {
                // Assign the nextAdmin as the new team leader
                $membership->team->team_leader = $nextAdmin->freelancer_id;
                $membership->team->save();
            }
        }

        $freelancer->isin_A_Team = false;
        $freelancer->save();
        $membership->services = [];
        $membership->status = 'inactive';
        $membership->save();

        return redirect()->route('freelancer-homepage');
    }

    //remove member
    public function removeMember(Request $request)
    {
        //leader's current team
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,team_id',
            'freelancer_id' => 'required',
        ]);
        $team = Team::find($validated['team_id']);

        //remove the memebr
        $membership = $team->memberships()->where('freelancer_id', $validated['freelancer_id'])->first();
        $membership->services = [];
        $membership->status = 'inactive'; // this remove status or not in the team anymore
        $membership->save();

        return redirect()->back()->with('success', 'Removed from team successfully!');
    }


    //close team 
    public function closeTeam() {}
}
