<?php

namespace App\Models\Profile;


use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',
        'job_category',
        'job_title',
        'fee_type',
        'isAvailable',
        'job_fee',
    ];

     protected $casts = [
        'skills' => 'array', 
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
