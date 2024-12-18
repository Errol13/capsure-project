<?php

namespace App\Livewire\Client;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SearchFilter extends Component
{
    public $showFilters = false;
    public $query = '';
    public $category = 'any';
    public $feeType = 'any-fee';
    public $freelancerType = 'solo';
    public $feeRange = 'any-range';
    public $rating = 'any-rate';
    public $location = '';
    public $locationLists = [];

    public function mount(){
         //set the $locationLists
         $this->locationLists = User::where('user_type', 'freelancer')->select('city')->distinct()->pluck('city')->toArray();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function search()
    {
        $this->applyFilters();
    }

    public function applyFilters()
    {
        $filters = [
            'query' => $this->query,
            'category' => $this->category,
            'feeType' => $this->feeType,
            'freelancerType' => $this->freelancerType,
            'feeRange' => $this->feeRange,
            'rating' => $this->rating,
            'location' => $this->location,
        ];

        // Log::info('Filters Applied:', $filters);

        $this->dispatch('filtersApplied', $filters);


        // Optionally dispatch an event to close the modal
        $this->dispatch('closeModal');
    }


    public function render()
    {
        return view('livewire.client.search-filter');
    }
}
