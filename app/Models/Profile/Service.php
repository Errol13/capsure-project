<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_category',
        'job_title',
        'fee_type',
        'isAvailable',
        'job_fee',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'user_id');
    }
}
