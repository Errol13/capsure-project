<?php

namespace App\Livewire\Freelancer;

use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\hiring\Job_application;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class MyJobs extends Component
{
    public $activeTab = 'application'; // Default tab

    public function mount()
    {
        // Initialize or restore the active tab from session 
        $this->activeTab = session()->get('activeTab', 'application');
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        session()->put('activeTab', $tab); // Store active tab in session
    }

    public function render()
    {
        // user authenticated
        /** @var User */
        $user = Auth::user();
        $freelancer = Freelancer::where('user_id', $user->id)->with('services')->first();

        // get the applied jobs
        $appliedJobs = $freelancer->appliedJobs()->with('event')->get()->map(function ($job) {
            $job->event->start_date_formatted = Carbon::parse($job->event->start_date)->format('M j, Y h:i A');
            $job->event->end_date_formatted = Carbon::parse($job->event->end_date)->format('M j, Y h:i A');
            return $job;
        });

        //fetch how many applications and requests
        $appliedJobsCount = $appliedJobs->count();
        $hiringRequestsCount = $freelancer->hiringRequests()->count();

        //get available recommendations 
        $eventRecommendations = Event::with('event_jobs')
            ->where('status', 'Open')
            ->whereHas('event_jobs', function ($query) use ($freelancer) {
                $query->whereIn('job_category', $freelancer->services->pluck('job_category'));
            })->get();

        //format the date for each event
        foreach ($eventRecommendations as $event) {
            $event->start_date_formatted = Carbon::parse($event->start_date)->format('M j, Y h:i A');
            $event->end_date_formatted = Carbon::parse($event->end_date)->format('M j, Y h:i A');
        }

        // Get hiring requests with related event job and event data through eventjob
        $hiringRequests = $freelancer->hiringRequests()
            ->with(['eventjob.event'])
            ->get();

        //format the date for each event
        foreach ($hiringRequests as $eachEvent) {
            $eachEvent->eventjob->event->start_date_formatted = Carbon::parse($eachEvent->eventjob->event->start_date)->format('M j, Y h:i A');
            $eachEvent->eventjob->event->end_date_formatted = Carbon::parse($eachEvent->eventjob->event->end_date)->format('M j, Y h:i A');
        }


        $eventRecommendationsCount = $eventRecommendations->count();


        return view('livewire.freelancer.my-jobs', [
            'appliedJobs' => $appliedJobs,
            'appliedJobsCount' => $appliedJobsCount,
            'hiringRequestsCount' => $hiringRequestsCount,
            'eventRecommendations' => $eventRecommendations,
            'recommendationsCount' => $eventRecommendationsCount,
            'hiringRequests' => $hiringRequests
        ]);
    }
}
