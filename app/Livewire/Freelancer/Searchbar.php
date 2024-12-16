<?php

namespace App\Livewire\Freelancer;

use App\Models\Hiring\Event;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Searchbar extends Component
{
    use WithPagination;

    public $query = '';
    public $jobCategory = 'Any Category';
    public $budgetRange = 'any';
    public $location = 'any';
    public $locationLists = []; //this is the lists of all location in City/Municipality

    public function mount()
    {
        //set the $locationLists
        $this->locationLists = Event::select('city')->distinct()->pluck('city')->toArray();
    }

     // Apply filters when search is triggered (search icon clicked)
    public function search()
    {
        $this->sendFilter();
    }

    //apply filters
    public function sendFilter()
    {
        // dispatch an event that sends the filter parameters to the second component (FreelancerHome)
        $this->dispatch('filterParamsUpdated', $this->query, $this->jobCategory, $this->budgetRange, $this->location);

        //dispatch an event to close the modal since we are getting error
        $this->dispatch('close-filter-modal');
    }


    public function render()
    {
        return view('livewire.freelancer.searchbar');
    }
}
