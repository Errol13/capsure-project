<?php

namespace App\Models;

use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Review;
use App\Models\Profile\Certificates;
use App\Models\Profile\Membership;
use App\Models\Profile\Portfolio;
use App\Models\Profile\Service;
use App\Models\Profile\Team;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'avg_rating',
        'number_of_projects',
        'terms_and_conditions',
        'skills',
        'isin_A_Team'
    ];

    protected $casts = [
        'skills' => 'array', // Cast 'skills' as an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'freelancer_id');
    }


    public function certificates()
    {
        return $this->hasMany(Certificates::class, 'freelancer_id');
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'freelancer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'freelancer_id');
    }

    // Relationship to EventJob through JobApplications
    public function appliedJobs()
    {
        return $this->belongsToMany(EventJob::class, 'job_applications', 'freelancer_id', 'job_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function jobApplications()
    {
        return $this->hasMany(Job_application::class, 'freelancer_id', 'user_id');
    }

    public function hiringRequests()
    {
        return $this->hasMany(Hiring_request::class, 'freelancer_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'freelancer_id');
    }



    public function membership()
    {
        return $this->hasOne(Membership::class, 'freelancer_id');
    }

    public function team()
    {
        return $this->hasOneThrough(
            Team::class, //final model to access
            Membership::class, //intermediate model 
            'freelancer_id', // Foreign key on memberships table
            'team_id',       // Foreign key on teams table
            'user_id',       // Local key on freelancers table
            'team_id'       // Local key on memberships table
        );
    }

    public function teamTransactions()
    {
        // Check if the freelancer is part of a team
        $team = $this->team;

        if (!$team) {
            // Return an empty collection if the freelancer is not in a team
            return collect();
        }

        // Retrieve transactions associated with the team
        return Transaction::where('team_code', $team->team_code)
            ->with(['event', 'client.user', 'payment_proofs', 'reviews'])
            ->get();
    }


    public function getMyReviews()
    {
        return $this->reviews()->where('reviewee_role', 'freelancer')->get();
    }

    // Update avg_rating
    public function updateAverageRating()
    {
        $average = $this->getMyReviews()->avg('rating');
        $this->avg_rating = round($average, 1);
        $this->save();
    }
}
