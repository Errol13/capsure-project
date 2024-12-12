<?php

namespace App\Livewire;

use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\hiring\Job_application;
use App\Models\Profile\Service;
use App\Models\Profile\Team;
use App\Models\Transaction\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditEventPost extends Component
{
    public $eventId;
    public $title, $description, $start_date, $end_date, $street, $barangay, $city, $payment_method, $budget_min, $budget_max;
    public $jobs = [];
    public $canEditFields = true;
    public $canRemoveJobs = true;
    public $jobTitles = [];
    public $selectedCategory;
    public $availableServices = [];

    public function mount($eventReceivedId)
    {
        $this->eventId = $eventReceivedId;

        try {
            $event = Event::findOrFail($this->eventId);
            $this->authorizeEdit($event);
            $this->fillEventData($event);
            $this->setTheJobTitles();
        } catch (\Exception $e) {
            session()->flash('error', 'Event not found or unauthorized.');
            return redirect()->to('/client-events');
        }

        $this->checkEditConditions();
    }

    private function fillEventData($event)
    {
        $this->title = $event->title;
        $this->description = $event->description;
        $this->start_date = $event->start_date;
        $this->end_date = $event->end_date;
        $this->street = $event->street;
        $this->barangay = $event->barangay;
        $this->city = $event->city;
        $this->payment_method = $event->payment_method;
        $this->budget_min = $event->budget_min;
        $this->budget_max = $event->budget_max;
        $this->jobs = $event->event_jobs->map(function ($job) {
            // Pre-populate values for each job
            $job->available_services = $this->getServicesByCategory($job->job_category); // Assuming this method fetches available services based on category
            $job->service_needed = $job->service_needed; // Keep the pre-selected service
            $job->number_of_people = $job->number_of_people ?? 0; // Default to 0 if number_of_people is not set
            return $job;
        })->toArray();
    }

    private function authorizeEdit($event)
    {
        if ($event->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function setTheJobTitles()
    {
        // Define default job titles for each category
        $defaultJobTitles = [
            'Arts' => ['Painter', 'Sculptor', 'Illustrator'],
            'Entertainment' => ['Actor', 'Musician', 'Dancer', 'Choreographer', 'Comedian', 'Clown Artist'],
            'Event Planner' => ['Wedding Coordinator', 'Corporate Event Planner'],
            'Food Service' => ['Chef', 'Food Caterer'],
            'Handicrafts' => ['Craft Maker', 'Jewelry Designer', 'Beader'],
            'Online Services' => ['Virtual Assistant', 'SEO Specialist', 'Tutor'],
            'Photography' => ['Photographer', 'Photo Editor'],
            'Styling' => ['Fashion Stylist', 'Makeup Artist'],
            'Videography' => ['Event Videographer', 'Corporate Videographer', 'Videographer'],
            'Voice Talent' => ['Narrator', 'Singer', 'Host', 'Voice Actor'],
            'Package' => ['Food Package', 'Birthday Package'],
        ];

        // Fetch existing job titles from the database
        $existingJobTitles = Service::select('job_category', 'job_title')
            ->groupBy('job_category', 'job_title')
            ->get()
            ->groupBy('job_category')
            ->toArray();

        // Fetch existing package services from the Team model
        $teamServices = Team::select('package_service')
            ->distinct() // Avoid duplicates in the query result
            ->pluck('package_service')
            ->toArray();

        // Merge default and existing job titles (no duplicates)
        foreach ($defaultJobTitles as $category => $titles) {
            // Existing titles for this category
            $existingTitles = isset($existingJobTitles[$category])
                ? array_column($existingJobTitles[$category], 'job_title')
                : [];

            // Merge default and existing titles, remove duplicates
            $this->jobTitles[$category] = array_unique(array_merge($titles, $existingTitles));
        }

        // Merge team services under the 'Package' category
        if (!isset($this->jobTitles['Package'])) {
            $this->jobTitles['Package'] = []; // Ensure the 'Package' category exists
        }

        // Add team services to the 'Package' category and remove duplicates
        $this->jobTitles['Package'] = array_unique(array_merge(
            $this->jobTitles['Package'],
            $teamServices
        ));
    }

    public function checkEditConditions()
    {
        // Check if there are already job applications
        $applications = Job_application::whereHas('event_job', function ($query) {
            $query->where('event_id', $this->eventId);
        })->count();

        $transactions = Transaction::whereHas('eventjobs.event', function ($query) {
            $query->where('event_id', $this->eventId);
        })->exists();

        $this->canEditFields = ($applications === 0);
        $this->canRemoveJobs = ($applications === 0 && $transactions);
    }

    private function getServicesByCategory($category)
    {
        return isset($this->jobTitles[$category]) ? $this->jobTitles[$category] : [];
    }

    public function updatedSelectedCategory($category)
    {

        $this->availableServices = $this->getServicesByCategory($category);
    }

    public function updateServiceDropdown($index)
    {
        $selectedCategory = $this->jobs[$index]['job_category'];

        if (array_key_exists($selectedCategory, $this->jobTitles)) {
            $this->jobs[$index]['available_services'] = $this->jobTitles[$selectedCategory];
            $this->jobs[$index]['service_needed'] = '';
            $this->jobs[$index]['custom_service_needed'] = null;
        } else {
            $this->jobs[$index]['available_services'] = [];
            $this->jobs[$index]['service_needed'] = '';
            $this->jobs[$index]['custom_service_needed'] = null;
        }

        if ($selectedCategory === 'Package') {
            $this->jobs[$index]['number_of_people'] = 1;
        }
    }

    public function checkOthersSelection($index)
    {
        if ($this->jobs[$index]['service_needed'] === 'Others') {
            $this->jobs[$index]['custom_service_needed'] = '';
        } else {
            $this->jobs[$index]['custom_service_needed'] = null;
        }
    }

    public function addJob()
    {
        $this->jobs[] = [
            'service_needed' => '',
            'job_category' => '',
            'custom_service_needed' => '',
            'number_of_people' => 1,
            'status' => 'Open',
            'available_services' => []  // Initialize available_services directly for each job
        ];
    }


    public function removeJob($index)
    {
        if ($this->canRemoveJobs) {
            unset($this->jobs[$index]);
            unset($this->availableServices[$index]);
            $this->jobs = array_values($this->jobs);
            $this->availableServices = array_values($this->availableServices);
        }
    }

    public function saveEvent()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment_method' => 'required|string|max:50',
            'budget_min' => 'required|numeric|min:0',
            'budget_max' => 'required|numeric|min:0|gte:budget_min',
            'jobs' => 'required|array|min:1',
            'jobs.*.service_needed' => 'required|string|max:255',
            'jobs.*.custom_service_needed' => 'nullable|string|max:255',
            'jobs.*.job_category' => 'required|string|max:255',
            'jobs.*.number_of_people' => 'required|integer|min:1',
            'jobs.*.status' => 'required|string|max:50'
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Update the existing event
        $event = Event::findOrFail($this->eventId);
        $event->update([
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'street' => $this->street,
            'barangay' => $this->barangay,
            'city' => $this->city,
            'payment_method' => $this->payment_method,
            'budget_min' => $this->budget_min,
            'budget_max' => $this->budget_max
        ]);

        foreach ($this->jobs as $jobData) {
            $job = EventJob::updateOrCreate(
                ['event_id' => $this->eventId, 'service_needed' => $jobData['service_needed']],
                $jobData
            );
        }

        session()->flash('success', 'Event has been updated successfully.');
        return redirect()->route('events');
    }

    public function render()
    {
        return view('livewire.edit-event-post');
    }
}
