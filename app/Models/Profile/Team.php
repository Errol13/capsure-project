<?php

namespace App\Models\Profile;

use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $primaryKey = 'team_id';

    protected $fillable = [
        'team_code',
        'team_name',
        'team_leader',
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
}
