<?php

namespace App\Models\Hiring;

use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'street',
        'barangay',
        'city',
        'payment_method',
        'budget_min',
        'budget_max',
        'status',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function eventjobs(){
        return $this->hasMany(EventJob::class, 'event_id');
    }
}
