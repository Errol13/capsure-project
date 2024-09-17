<?php

namespace App\Models;

use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Review;
use App\Models\Profile\Certificates;
use App\Models\Profile\Portfolio;
use App\Models\Profile\Service;
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
}
