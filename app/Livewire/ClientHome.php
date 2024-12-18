<?php

namespace App\Livewire;

use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
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
    public $loading = false; //for spinner
    public $resultsCount;

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    #[On('filtersApplied')]
    public function updateFilters($filters)
    {
        // Log::info('updateFilters called');
        // Log::info('Filters Updated:', $filters);

        $this->loading = true;

        // Update properties with the new filters
        $this->query = $filters['query'] ?? $this->query;
        $this->category = $filters['category'] ?? $this->category;
        $this->feeType = $filters['feeType'] ?? $this->feeType;
        $this->freelancerType = $filters['freelancerType'] ?? $this->freelancerType;
        $this->feeRange = $filters['feeRange'] ?? $this->feeRange;
        $this->rating = $filters['rating'] ?? $this->rating;
        $this->location = $filters['location'] ?? $this->location;
        $this->firstDisplay = false;

        $this->loading = false;
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
            ->where('users.id', '!=', auth()->id())
            ->orderBy('freelancers.avg_rating', 'desc')
            ->orderBy('number_of_projects', 'desc')
            ->orderBy('user_id')
            ->select('users.*')
            ->paginate(9);
    }


    private function fetchFilteredUsers()
    {
        $nameParts = explode(' ', $this->query);

        $firstNamePart = $nameParts[0] ?? '';
        $lastNamePart = $nameParts[1] ?? '';

        $query = User::query();

        // Only include users who are freelancers
        $query->whereHas('freelancer', function ($freelancerQuery) use ($firstNamePart, $lastNamePart) {
            $freelancerQuery->where(function ($freelancerSubQuery) use ($firstNamePart, $lastNamePart) {
                // Apply name filter
                $freelancerSubQuery->when($firstNamePart, function ($nameQuery) use ($firstNamePart, $lastNamePart) {
                    $nameQuery->whereHas('user', function ($userQuery) use ($firstNamePart, $lastNamePart) {
                        $userQuery->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower($firstNamePart) . '%']);
                        if ($lastNamePart) {
                            $userQuery->whereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower($lastNamePart) . '%']);
                        }
                    });
                });
            });

            $jobtitle = $this->query ?? '';

            if (!empty($jobtitle)) {
                $keywords = explode(' ', strtolower($jobtitle)); // Split the query into keywords
                //  dd($keywords);
                $freelancerQuery->orWhereHas('services', function ($serviceQuery) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $serviceQuery->whereRaw('LOWER(job_title) LIKE ?', '%' . $keyword . '%'); // for each word, it searches for match
                        // dd($serviceQuery);
                    }
                });
            }

            // Apply job_category filter if selected
            $freelancerQuery->when($this->category !== 'any', function ($categoryQuery) {
                $categoryQuery->whereHas('services', function ($serviceQuery) {
                    $serviceQuery->where('job_category', $this->category);
                });
            });

            // Apply fee type filter if selected
            $freelancerQuery->when($this->feeType !== 'any-fee', function ($feeTypeQuery) {
                $feeTypeQuery->whereHas('services', function ($serviceQuery) {
                    $serviceQuery->where('fee_type', $this->feeType);
                });
            });

            // Apply freelancer type (solo/team)
            $freelancerQuery->when($this->freelancerType !== 'solo', function ($teamQuery) {
                $teamQuery->where('isin_A_Team', true);
            });

            // Apply fee range filter if selected
            $freelancerQuery->when($this->feeRange !== 'any-range', function ($feeRangeQuery) {
                $feeRangeQuery->whereHas('services', function ($serviceQuery) {
                    $serviceQuery->whereBetween('job_fee', $this->getFeeRange());
                });
            });

            //apply rating filter if selected lower or equal to 2
            if ($this->rating <= 2) {
                $freelancerQuery->when($this->rating !== 'any-rate', function ($ratingQuery) {
                    $ratingQuery->where('avg_rating', '<=', $this->rating);
                });
            } else {
                // Apply rating filter if selected higher than 2
                $freelancerQuery->when($this->rating !== 'any-rate', function ($ratingQuery) {
                    $ratingQuery->where('avg_rating', '>=', $this->rating);
                });
            }


            // Apply location filter if selected
            $freelancerQuery->when($this->location, function ($locationQuery) {
                $locationQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('city', 'like', '%' . $this->location . '%');
                });
            });
        });

        // Eager load freelancer and services
        $users = $query->with('freelancer.services')->where('id', '!=', auth()->id())->paginate(9);

        // If no results, return empty collection
        if ($users->isEmpty()) {
            $users = collect();
        }

        return $users;
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

            //total if pagination otherwise count
            if ($users instanceof LengthAwarePaginator || $users instanceof Paginator) {
                $this->resultsCount = $users->total();
            } else {
                $this->resultsCount = $users->count();
            }
        } else {
            $users = $this->fetchFilteredUsers();
            //total if pagination otherwise count
            if ($users instanceof LengthAwarePaginator || $users instanceof Paginator) {
                $this->resultsCount = $users->total();
            } else {
                $this->resultsCount = $users->count();
            }
            // If no results
            if ($users->isEmpty()) {
                // return empty results
                $users = collect();
            }
        }

        // Log::info('category: ' . $this->category);

        return view('livewire.client-home', [
            'users' => $users,
            'category' => $this->category
        ]);
    }
}
