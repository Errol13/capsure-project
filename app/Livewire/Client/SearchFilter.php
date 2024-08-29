<?php

namespace App\Livewire\Client;

use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\User;
use Livewire\Component;

class SearchFilter extends Component
{
    public $query = '';
    public $category = 'any';
    public $feeType = 'any-fee';
    public $freelancerType = 'solo';
    public $feeRange = 'any-range';
    public $rating = 'any-rate';
    public $location = '';

    public function render()
    {
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
                $query->where('avg_rating', '==', $this->rating);
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->get();

        // Load freelancers with the filtered services
        $freelancers = Freelancer::whereIn('user_id', $services->pluck('freelancer_id'))->get();
        $users = User::whereIn('id', $freelancers->pluck('user_id'))->get();

        // Combine freelancers and users into a single collection or map them as needed
        $freelancersWithUsers = $freelancers->map(function ($freelancer) use ($users) {
            $user = $users->firstWhere('id', $freelancer->user_id);
            return [
                'freelancer' => $freelancer,
                'user' => $user
            ];
        });

        return view('livewire.client.search-filter', [
            'freelancersWithUsers' => $freelancersWithUsers
        ]);
    }
}
