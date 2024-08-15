<?php

namespace App\Models\Hiring;

use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_needed',       // Service needed by the client
        'job_category',         // Job category of the freelancer's service
        'number_of_people',     // Number of people required for the job
        'status',               // Freelancer's application status (accepted, rejected, pending)
        'event_id',             // Foreign key to the events table
    ];

    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }

    // Relationship to Freelancer through JobApplications
    public function applicants()
    {
        return $this->belongsToMany(Freelancer::class, 'job_applications', 'job_id', 'freelancer_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function hiringRequests()
    {
        return $this->hasMany(Hiring_request::class, 'job_id');
    }
}
