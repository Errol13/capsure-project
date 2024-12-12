<?php

namespace App\Models\Profile;

use App\Models\Freelancer;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Review;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $primaryKey = 'team_id';

    protected $fillable = [
        'team_code',
        'team_name',
        'team_profilepic',
        'team_leader',
        'team_description',
        'terms_of_services',
        'number_of_projects',
        'package_service',
        'package_price',
        'avg_rating'
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'team_id');
    }

    public function freelancers()
    {
        return $this->belongsToMany(Freelancer::class, 'memberships', 'team_id', 'freelancer_id')->has('membership')
            ->orderByRaw('freelancer_id = ? DESC', [$this->team_leader]) // This ensures the admin is first
            ->orderBy('created_at'); 
    }


    public function jobApplications()
    {
        return $this->hasMany(Job_application::class, 'team_code', 'team_code');
    }

    public function hiringRequests()
    {
        return $this->hasMany(Hiring_request::class, 'team_code', 'team_code');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'team_code', 'team_code');
    }

    public function membersAtTransactionTime($transactionCreatedAt)
    {
        return $this->freelancers()
            ->wherePivot('created_at', '<=', $transactionCreatedAt);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'team_code', 'team_code');
    }

    public function totalReviews(): int
    {
        return $this->reviews()->where('reviewee_role', 'team')->count();
    }

    public function areAllMembersVerified(): bool
    {
        return !$this->memberships()
            ->whereHas('freelancer.user', function ($query) {
                $query->where('isVerified', false);
            })
            ->exists();
    }

    public function hasMinimumMemberships(): bool
    {
        return $this->memberships()->where('status', 'active')->count() >= 5;
    }

    public function membersCount(): int
    {
        return $this->memberships()->count();
    }

    //get the services
    public function getServices()
    {
        // Flatten the services from each membership
        $allServiceIds = $this->memberships->flatMap(function ($membership) {
            // Decode the services JSON string into an array
            $services = $membership->services;

            return is_array($services) ? $services : [];
        })->unique(); // Get unique service IDs

        // If there are no service IDs, return an empty collection
        if ($allServiceIds->isEmpty()) {
            return collect();
        }

        // Fetch services based on the service IDs and filter by availability
        return Service::whereIn('id', $allServiceIds)->get();
    }



    public function isLeader(): bool
    {
        $user = auth()->user(); // Get the currently authenticated user
        return $user && $this->team_leader === $user->freelancer->user_id;
    }

    public function getMyReviews()
    {
        return $this->reviews()->where('reviewee_role', 'team')->get();
    }

    // Update avg_rating
    public function updateAverageRating()
    {
        $average = $this->getMyReviews()->avg('rating');
        $this->avg_rating = round($average, 1);
        $this->save();
    }
}
