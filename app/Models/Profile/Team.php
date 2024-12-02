<?php

namespace App\Models\Profile;

use App\Models\Freelancer;
use App\Models\Hiring\Hiring_request;
use App\Models\hiring\Job_application;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $primaryKey = 'team_id';

    protected $fillable = [
        'team_code',
        'team_name',
        'team_profilepic',
        'team_leader',
        'team_description',
        'terms_of_services',
        'number_of_projects',
        'package_service',
        'package_price',
        'avg_rating'
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'team_id');
    }


    public function freelancers()
    {
        return $this->belongsToMany(Freelancer::class, 'memberships', 'team_id', 'freelancer_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(Job_application::class,'team_code', 'team_code');
    }
    
    public function hiringRequests()
    {
        return $this->hasMany(Hiring_request::class, 'team_code');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'team_code');
    }

    public function areAllMembersVerified(): bool
    {
        return !$this->memberships()
            ->whereHas('freelancer.user', function ($query) {
                $query->where('isVerified', false);
            })
            ->exists();
    }

    public function isLeader(): bool
    {
        $user = auth()->user(); // Get the currently authenticated user
        return $user && $this->team_leader === $user->freelancer->user_id;
    }
    
}
