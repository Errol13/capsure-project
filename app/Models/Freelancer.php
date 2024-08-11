<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'avg_rating', 'number_of_projects', 'terms_and_conditions', 'skills', 'isin_A_Team'
    ];

    protected $casts = [
        'skills' => 'array', // Cast 'skills' as an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'user_id');
    }
}
