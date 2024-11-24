<?php

namespace App\Livewire\Freelancer;

use App\Models\Hiring\Event;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class FreelancerHome extends Component
{
    public $filtersApplied = false;
    public $query = '';
    public $jobCategory = 'any';
    public $budgetRange = 'any';
    public $location = 'any';
    public $loading = false; //for spinner
    public $resultsCount;

    public function fetchAllEvents()
    {
        return Event::with(['client.user', 'event_jobs'])->paginate(9);
    }

    #[On('filterParamsUpdated')]
    public function receivedFilteredEvents($query, $jobCategory, $budgetRange, $location)
    {
        
        $this->query = $query;
        $this->jobCategory = $jobCategory;
        $this->budgetRange = $budgetRange;
        $this->location = $location;

        // Apply the filtering logic here
        $this->applyFilters();

       // dd('HEY');
    }

    // //find the events that match the filters
    // public function filteredEvents()
    // {
    //     return Event::query()->where('title', 'like', '%' . $this->query . '%')
    //         ->orWhere('description', 'like', '%' . $this->query . '%')->get();
    // }

    // Apply filters based on the received parameters
    public function applyFilters()
    {
        $this->loading = true;

        $filteredResults = Event::query();

        // Apply search if a query exists
        if (!empty($this->query)) {
            $filteredResults->where(function ($query) {
                $query->where('title', 'like', '%' . $this->query . '%')
                    ->orWhere('description', 'like', '%' . $this->query . '%');
            });
        }

        // Filter by job category
        if ($this->jobCategory !== 'Any Category') {
            $filteredResults->whereHas('event_jobs', function ($query) {
                $query->where('job_category', $this->jobCategory);
            });
        }

        // Filter by budget range
        if ($this->budgetRange !== 'any') {
            switch ($this->budgetRange) {
                case '1000':
                    $filteredResults->where(function ($query) {
                        $query->where('budget_max', '<=', 1000)
                            ->orWhere('budget_min', '<=', 1000);
                    });
                    break;
                case '5000':
                    $filteredResults->whereBetween('budget_max', [1000, 5000])
                        ->orWhereBetween('budget_min', [1000, 5000]);
                    break;
                case '10000':
                    $filteredResults->whereBetween('budget_max', [5000, 10000])
                        ->orWhereBetween('budget_min', [5000, 10000]);
                    break;
                case 'above':
                    $filteredResults->where(function ($query) {
                        $query->where('budget_max', '>', 10000)
                            ->orWhere('budget_min', '>', 10000);
                    });
                    break;
            }
        }

        // Filter by location
        if ($this->location !== 'any') {
            $filteredResults->where('city', $this->location);
        }

        $this->filtersApplied = true;

        $this->loading = false;
        // return the filtered events
        return $filteredResults->with(['client.user', 'event_jobs'])->paginate(9);

    }


    public function render()
    {
        if ($this->query === '' && $this->filtersApplied === false) {
            $events = $this->fetchAllEvents();
            $this->resultsCount = $events->count();
        } else {
            $events = $this->applyFilters();
            $this->resultsCount = $events->count();
          // dd($events);
        }

        return view('livewire.freelancer.freelancer-home', ['events' => $events]);
    }
}
