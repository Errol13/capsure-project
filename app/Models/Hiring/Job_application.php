<?php

namespace App\Models\hiring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_application extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',  // Foreign key pointing to the freelancer
        'job_id',         // Foreign key pointing to the job
        'status',         // Status of the freelancer's application
    ];
}
