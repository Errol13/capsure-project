<?php

namespace App\Models\Hiring;

use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\Profile\Team;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hiring_request extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',
        'job_id',
        'client_id',
        'team_code',
        'client_pricing',
        'dealer_user_type',
        'freelancer_pricing',
        'status',
    ];

    protected $primaryKey = 'hiring_request_id';

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'hiring_request_id');
    }

    public function eventjob()
    {
        return $this->belongsTo(EventJob::class, 'job_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_code');
    }


    // Relationship to JobApplication through EventJob
    public function getJobApplication()
    {
        if ($this->freelancer_id) {
            // for solo freelancer
            return $this->eventjob
                ->jobApplications()
                ->where('freelancer_id', $this->freelancer_id)
                ->first();
        } elseif ($this->team_id) {
            // If it's for a team, get the job application for the team
            return $this->eventjob
                ->jobApplications()
                ->where('team_id', $this->team_id)
                ->first();
        }

        // Return null if neither freelancer_id nor team_id is set
        return null;
    }


    public function getServiceId()
    {
        // First, try to get the service_id from JobApplication
        $jobApplication = $this->getJobApplication();

        if ($jobApplication) {
            return $jobApplication->service_id;
        }

        // If no JobApplication, try to find a matching service by service_needed
        return $this->getServiceIdFromEventJob();
    }

    public function getServiceIdFromEventJob()
    {
        $eventJob = $this->eventjob; // Access the related EventJob model via the relationship

        if ($eventJob && $eventJob->service_needed) {
            // Find a service that matches the service_needed
            return $this->findMatchingService($eventJob->service_needed);
        }

        return null;
    }


    public function findMatchingService($serviceNeeded)
    {
        $freelancerServices = $this->freelancer->services;
        $bestMatch = null;
        $highestSimilarity = 0;

        foreach ($freelancerServices as $service) {
            similar_text($service->job_title, $serviceNeeded, $percent);

            // If similarity percentage is above a threshold get the best match
            if ($percent > 80 && $percent > $highestSimilarity) {
                $highestSimilarity = $percent;
                $bestMatch = $service->id;
            }
        }

        return $bestMatch;
    }


    public function serviceDetails()
    {
        $serviceId = $this->getServiceId();

        if ($serviceId) {
            return Service::find($serviceId); // Fetch the service details
        }

        return null; // Return null if no service is found
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
