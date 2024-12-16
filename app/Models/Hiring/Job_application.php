<?php

namespace App\Models\Hiring;

use App\Models\Freelancer;
use App\Models\Profile\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_application extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',  // Foreign key pointing to the freelancer
        'job_id',   // Foreign key pointing to the job
        'team_code', //foreign key pointing to the team
        'service_id',      //stores service id
        'status',         // Status of the freelancer's application
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'user_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_code', 'team_code');
    }

    public function event_job()
    {
        return $this->belongsTo(EventJob::class, 'job_id');
    }
}
