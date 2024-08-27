<?php

namespace App\Models\Hiring;

use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewee_role',
        'client_id',
        'freelancer_id',
        'rating',
        'content',
        'review_date',
    ];


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
