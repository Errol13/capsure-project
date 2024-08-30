<?php

namespace App\Models\Hiring;

use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected $primaryKey = 'event_id';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function event_jobs(){
        return $this->hasMany(EventJob::class, 'event_id');
    }
}
