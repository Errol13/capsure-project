<?php

namespace App\Livewire;

use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ClientHome extends Component
{
    use WithPagination;

    public $query = '';
    public $category = 'any';
    public $feeType = 'any-fee';
    public $freelancerType = 'solo';
    public $feeRange = 'any-range';
    public $rating = 'any-rate';
    public $location = '';
    public $showFilters = false;
    public $firstDisplay = true;

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    #[On('filtersApplied')]
    public function updateFilters($filters)
    {
        Log::info('updateFilters called');
        Log::info('Filters Updated:', $filters);

        // Update properties with the new filters
        $this->query = $filters['query'] ?? $this->query;
        $this->category = $filters['category'] ?? $this->category;
        $this->feeType = $filters['feeType'] ?? $this->feeType;
        $this->freelancerType = $filters['freelancerType'] ?? $this->freelancerType;
        $this->feeRange = $filters['feeRange'] ?? $this->feeRange;
        $this->rating = $filters['rating'] ?? $this->rating;
        $this->location = $filters['location'] ?? $this->location;
        $this->firstDisplay = false;

        // Call a method to update the users after filters are applied
        $this->fetchFilteredUsers();
    }

    private function getFeeRange()
    {
        switch ($this->feeRange) {
            case '100':
                return [0, 100];
            case '500':
                return [101, 500];
            case '1000':
                return [501, 1000];
            case 'above':
                return [1001, PHP_INT_MAX];
            default:
                return [0, PHP_INT_MAX]; // Default range for 'any-range'
        }
    }

    private function fetchAllFreelancers()
    {
        return User::whereHas('freelancer')
            ->with('freelancer')
            ->join('freelancers', 'users.id', '=', 'freelancers.user_id')
            ->orderBy('freelancers.avg_rating', 'desc')
            ->orderBy('number_of_projects', 'desc')
            ->orderBy('user_id')
            ->select('users.*') 
            ->paginate(9);
    }


    private function fetchFilteredUsers()
    {
        // Log filter parameters
        Log::info('Filters Applied Home:', [
            'query' => $this->query,
            'category' => $this->category,
            'feeType' => $this->feeType,
            'freelancerType' => $this->freelancerType,
            'feeRange' => $this->feeRange,
            'rating' => $this->rating,
            'location' => $this->location
        ]);

        // Filter services based on user input
        $services = Service::query()
            ->when($this->query, function ($query) {
                $query->where('job_title', 'like', '%' . $this->query . '%');
            })
            ->when($this->category !== 'any', function ($query) {
                $query->where('job_category', $this->category);
            })
            ->when($this->feeType !== 'any-fee', function ($query) {
                $query->where('fee_type', $this->feeType);
            })
            ->when($this->freelancerType !== 'solo', function ($query) {
                $query->whereHas('freelancer', function ($query) {
                    $query->where('in_A_Team', true);
                });
            })
            ->when($this->feeRange !== 'any-range', function ($query) {
                $query->whereBetween('job_fee', $this->getFeeRange());
            })
            ->when($this->rating !== 'any-rate', function ($query) {
                $query->whereHas('freelancer', function ($query) {
                    $query->where('avg_rating', '>=', $this->rating);
                });
            })
            ->when($this->location, function ($query) {
                $query->whereHas('freelancer', function ($query) {
                    $query->whereHas('user', function ($query) {
                        $query->where('city', 'like', '%' . $this->location . '%');
                    });
                });
            })
            ->get();

        // Log the filtered services
        Log::info('Filtered Services:', $services->toArray());

        // Get the user IDs associated with the filtered services
        $userIds = $services->pluck('freelancer_id');

        // Load users with eager loading for the freelancer relationship
        return User::whereIn('id', $userIds)
            ->with('freelancer') // Eager load the freelancer relationship
            ->paginate(9);

        Log::info('Filtered User Count: ' . $this->users->count());
    }

    public function toggleFavorite($freelancerId)
    {
        $client = auth()->user()->client;

        if ($client->isFavorite($freelancerId)) {
            $client->removeFavorite($freelancerId);
        } else {
            $client->addFavorite($freelancerId);
        }
    }

    public function render()
    {
        // Initially fetch all freelancers
        if ($this->query === '' && $this->firstDisplay) {
            $users = $this->fetchAllFreelancers();
            Log::info('Filtered User Count: ', $users->toArray());
        } else {
            $users = $this->fetchFilteredUsers();

            // If no results
            if ($users->isEmpty()) {
                // return empty results
                $users = collect(); 
            }
        }

        Log::info('category: ' . $this->category);

        return view('livewire.client-home', [
            'users' => $users,
            'category' => $this->category
        ]);
    }
}
