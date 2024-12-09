<?php

namespace App\Livewire;

use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Profile\Service;
use App\Models\Profile\Team;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreateEventForm extends Component
{
    public $title, $description, $start_date, $end_date, $street, $barangay, $city, $payment_method, $budget_min, $budget_max;
    public $jobs = [];
    public $jobTitles = [];
    public $selectedCategory;
    public $availableServices = [];

    public function mount()
    {

        /** @var User $user */
        $user = Auth::user();

        // Initialize public properties with user data
        $this->street = $user->street;
        $this->barangay = $user->barangay;
        $this->city = $user->city;

        // Fetch job titles from the services table
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

    public function updatedSelectedCategory($category)
    {
        $this->availableServices = $this->getServicesByCategory($category);
    }

    private function getServicesByCategory($category)
    {
        // Return services based on the selected category using jobTitles
        return isset($this->jobTitles[$category]) ? $this->jobTitles[$category] : [];
    }

    public function updateServiceDropdown($index)
    {
        $selectedCategory = $this->jobs[$index]['job_category'];

        if (array_key_exists($selectedCategory, $this->jobTitles)) {
            $this->jobs[$index]['available_services'] = $this->jobTitles[$selectedCategory];
            // Reset the service_needed when the category changes
            $this->jobs[$index]['service_needed'] = '';
            $this->jobs[$index]['custom_service_needed'] = null;
        } else {
            $this->jobs[$index]['available_services'] = [];
            $this->jobs[$index]['service_needed'] = '';
            $this->jobs[$index]['custom_service_needed'] = null;
        }

        // Reset number_of_people to 1 if category is "package"
        if ($selectedCategory === 'Package') {
            $this->jobs[$index]['number_of_people'] = 1;
        }
    }


    public function checkOthersSelection($index)
    {
        // If "Others" is selected, clear the custom service field
        if ($this->jobs[$index]['service_needed'] === 'Others') {
            $this->jobs[$index]['custom_service_needed'] = '';
        } else {
            // Clear the custom service field if another service is selected
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
            'status' => 'Open'
        ];
        $this->availableServices[] = [];
    }

    public function removeJob($index)
    {
        unset($this->jobs[$index]);
        unset($this->availableServices[$index]);
        $this->jobs = array_values($this->jobs); // Re-index the array to prevent Livewire errors
        $this->availableServices = array_values($this->availableServices);
    }

    public function updatedBudgetMin($value)
    {
        // Ensure budget_min is a positive number
        if ($value < 20 && $this->budget_max > 20) {
            $this->budget_min = 20; //default
            return;
        }

        // Set budget_max dynamically to match budget_min if budget_max is smaller
        if (empty($this->budget_max) || $this->budget_max < $value) {
            $this->budget_max = $value;
        }
    }

    public function updatedBudgetMax($value)
    {
        // Ensure budget_max is not less than budget_min
        if ($value < $this->budget_min) {
            $this->budget_max = $this->budget_min;
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

        Log::info('POST CREATED');


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
            //if the client entered a new service then use that, otherwise the service_needed
            $jobTitle = !empty($job['custom_service_needed']) ? $job['custom_service_needed'] : $job['service_needed'];

            EventJob::create([
                'event_id' => $event->event_id,
                'service_needed' => $jobTitle,
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
