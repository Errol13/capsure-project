<?php

namespace App\Models\hiring;

use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_application extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',  // Foreign key pointing to the freelancer
        'job_id',   // Foreign key pointing to the job
        'service_id',      //stores service id
        'status',         // Status of the freelancer's application
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'user_id');
    }

}
