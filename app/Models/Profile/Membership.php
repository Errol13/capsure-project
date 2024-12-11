<?php

namespace App\Models\Profile;

use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',
        'team_id',
        'services',
        'status',
    ];

    protected $primaryKey = 'membership_id';

    protected $casts = [
        'services' => 'array',
    ];
    

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function getServices()
    {
        // Retrieve service IDs from the services JSON column
        $serviceIds = $this->services;

        // Fetch the services from the Service model based on those IDs
        $services = Service::whereIn('id', $serviceIds)->where('isAvailable', true)->get();
        // dd($services->count());
        return  $services;

    }

}
