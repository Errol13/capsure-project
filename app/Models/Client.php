<?php

namespace App\Models;

use App\Models\Hiring\Hiring_request;
use App\Models\Hiring\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'total_job_posted',
        'total_successful_hiring',
        'hiring_rate',
        'avg_rating',
        'favorites'
    ];

    protected $casts = [
        'favorites' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function hiringRequests()
    {
        return $this->hasMany(Hiring_request::class, 'client_id');
    }
}
