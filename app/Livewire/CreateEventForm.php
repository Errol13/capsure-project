<?php

namespace App\Livewire;

use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Profile\Service;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreateEventForm extends Component
{
    public $title, $description, $start_date, $end_date, $street, $barangay, $city, $payment_method, $budget_min, $budget_max;
    public $jobs = [];
    public $services = []; 

    public function mount()
    {

        /** @var User $user */
        $user = Auth::user();

        // Initialize public properties with user data
        $this->street = $user->street;
        $this->barangay = $user->barangay;
        $this->city = $user->city;

        // Fetch job titles from the services table
        $this->services = Service::pluck('job_title')->toArray();
    }

    public function addJob()
    {
        $this->jobs[] = ['service_needed' => '', 'job_category' => '', 'number_of_people' => 1, 'status' => 'open'];
    }

    public function removeJob($index)
    {
        unset($this->jobs[$index]);
        $this->jobs = array_values($this->jobs); // Re-index the array to prevent Livewire errors
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
            'jobs.*.job_category' => 'required|string|max:255',
            'jobs.*.number_of_people' => 'required|integer|min:1',
            'jobs.*.status' => 'required|string|max:50'
        ]);


        /** @var User $user */
        $user = Auth::user();

        $event = Event::create([
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
            'status' => 'Open',
            'client_id' => $user->id,
        ]);

        foreach ($this->jobs as $job) {
            EventJob::create([
                'event_id' => $event->event_id,
                'service_needed' => $job['service_needed'],
                'job_category' => $job['job_category'],
                'number_of_people' => $job['number_of_people'],
                'status' => $job['status'],
            ]);
        }

        session()->flash('message', 'Event created successfully!');
        return redirect()->to('/client-events');
    }

    public function messages()
    {
        return [
            'jobs.*.service_needed.required' => 'Service needed is required.',
            'jobs.*.job_category.required' => 'Job category is required.',
            'jobs.*.number_of_people.required' => 'Number of people is required.',
        ];
    }


    public function render()
    {
        return view('livewire.create-event-form');
    }
}
