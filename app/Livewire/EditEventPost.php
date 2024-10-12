<?php

namespace App\Livewire;

use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\hiring\Job_application;
use App\Models\Hiring\JobApplication;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditEventPost extends Component
{
    public $eventId; // The ID of the event being edited
    public $title, $description, $start_date, $end_date, $street, $barangay, $city, $payment_method, $budget_min, $budget_max;
    public $jobs = [];
    public $canEditFields = true;
    public $canRemoveJobs = true;

    public function mount($eventId)
    {
        $this->eventId = $eventId;

        // Fetch existing event data
        $event = Event::findOrFail($this->eventId);
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

        // Fetch associated jobs
        $this->jobs = $event->event_jobs; 

        // Check conditions for editing fields and jobs
        $this->checkEditConditions();
    }

    public function checkEditConditions()
    {
        // Check if there are any applications for this event
        $applications = Job_application::whereHas('eventJob', function ($query) {
            $query->where('event_id', $this->eventId);
        })->count();

        // Determine if fields can be edited and jobs can be removed
        $this->canEditFields = ($applications === 0);
        $this->canRemoveJobs = ($applications === 0 && EventJob::where('event_id', $this->eventId)->where('hired', true)->count() === 0);
    }

    public function addJob()
    {
        // Only allow adding jobs if there are hired freelancers
        if ($this->canRemoveJobs) {
            $this->jobs[] = [
                'service_needed' => '',
                'job_category' => '',
                'custom_service_needed' => '',
                'number_of_people' => 1,
                'status' => 'Open'
            ];
        }
    }

    public function removeJob($index)
    {
        if ($this->canRemoveJobs) {
            unset($this->jobs[$index]);
            $this->jobs = array_values($this->jobs); // Re-index the array
        }
    }

    public function saveEvent()
    {
        // Validate the data
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

        // Update the event
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
            'budget_max' => $this->budget_max,
        ]);

        // Update jobs
        foreach ($this->jobs as $job) {
            EventJob::updateOrCreate(
                ['event_id' => $this->eventId, 'service_needed' => $job['service_needed']],
                [
                    'job_category' => $job['job_category'],
                    'number_of_people' => $job['number_of_people'],
                    'status' => $job['status'],
                ]
            );
        }

        session()->flash('message', 'Event updated successfully!');
        return redirect()->to('/client-events');
    }

    public function render()
    {
        return view('livewire.edit-event-post');
    }
}
