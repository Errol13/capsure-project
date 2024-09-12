<?php

namespace App\Livewire\Freelancer;

use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class MyJobs extends Component
{
    public $activeTab = 'application'; // Default tab
    public $showModal = false; // For controlling modal visibility
    public $jobId;

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

    public function openModal($jobId)
    {
        $this->jobId = $jobId;
        $this->showModal = true;
        $this->dispatch('show-modal');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('hide-modal');
    }

    public function confirmCancellation()
    {
        /** @var User */
        $user = Auth::user();
        $freelancer = Freelancer::where('user_id', $user->id)->first();

        if ($freelancer) {
            // Delete only the application for the specific job and freelancer
            Job_application::where('job_id', $this->jobId)
                ->where('freelancer_id', $freelancer->user_id)
                ->delete();

            $this->closeModal();
            session()->flash('success', 'Cancelled Job Application successfully.');
        } else {
            session()->flash('error', 'Freelancer not found.');
        }
    }



    public function render()
    {
        /** @var User */
        $user = Auth::user();
        $freelancer = Freelancer::where('user_id', $user->id)->with('services')->first();

        $appliedJobs = $freelancer->appliedJobs()->with('event')->get()->map(function ($job) {
            $job->event->start_date_formatted = Carbon::parse($job->event->start_date)->format('M j, Y h:i A');
            $job->event->end_date_formatted = Carbon::parse($job->event->end_date)->format('M j, Y h:i A');
            return $job;
        });

        $appliedJobsCount = $appliedJobs->count();
        $hiringRequestsCount = $freelancer->hiringRequests()->count();

        //completedHiredCounts
        $completedHiredCounts = collect();

        $eventRecommendations = Event::with('event_jobs')
            ->where('status', 'Open')
            ->whereHas('event_jobs', function ($query) use ($freelancer) {
                $query->whereIn('job_category', $freelancer->services->pluck('job_category'));
            })->get();

        foreach ($eventRecommendations as $event) {
            $event->start_date_formatted = Carbon::parse($event->start_date)->format('M j, Y h:i A');
            $event->end_date_formatted = Carbon::parse($event->end_date)->format('M j, Y h:i A');

            //completedHiredCounts for each event job
            foreach ($event->event_jobs as $job) {
                // Getting hired freelancers count for each job
                $jobApplicantsHired = Transaction::where('job_id', $job->id)->get();
                $hiredCount = $jobApplicantsHired->count();

                // Store the count of hired freelancers for the job
                $completedHiredCounts->put($job->id, $hiredCount);
            }
        }

        $hiringRequests = $freelancer->hiringRequests()
            ->with(['eventjob.event'])
            ->get();

        //Attach service details to each hiring request
        $hiringRequests->each(function ($hiringRequest) {
            $serviceDetails = $hiringRequest->serviceDetails();

            Log::info('service details:', $serviceDetails->toArray()); // the details are correctly retrieved
            $hiringRequest->serviceDetails = $serviceDetails;
        });

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
            'hiringRequests' => $hiringRequests,
            'freelancer' => $freelancer,
            'completedHiredCounts' => $completedHiredCounts
        ]);
    }
}
