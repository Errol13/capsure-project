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
    ];

    protected $primaryKey = 'membership_id';

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
