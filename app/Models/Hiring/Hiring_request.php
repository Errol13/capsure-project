<?php

namespace App\Models\Hiring;

use App\Models\Freelancer;
use App\Models\Profile\Service;
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
        'client_pricing',
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

    // Relationship to JobApplication through EventJob
    public function getJobApplication()
    {
        return $this->eventjob->jobApplications()->where('freelancer_id', $this->freelancer_id)->first();
    }

    public function getServiceId()
    {
        $jobApplication = $this->getJobApplication(); // Use the new method

        return $jobApplication ? $jobApplication->service_id : null;
    }

    public function serviceDetails()
    {
        $serviceId = $this->getServiceId();

        if ($serviceId) {
            return Service::find($serviceId);
        }

        return null;
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
