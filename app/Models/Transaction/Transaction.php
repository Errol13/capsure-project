<?php

namespace App\Models\Transaction;

use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\Profile\Team;
use App\Models\Transaction\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    // Define the fillable attributes
    protected $fillable = [
        'client_id',
        'freelancer_id',
        'job_id',
        'team_code',
        'payment_amount',
        'payment_status',
        'transaction_status',
        'hiring_request_id',
    ];

    protected $primaryKey = 'transaction_id';

    // Define relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'user_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'user_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_code');
    }

    public function eventjobs()
    {
        return $this->belongsTo(EventJob::class, 'job_id');
    }

    public function event()
    {
        return $this->hasOneThrough(
            Event::class,         // Final model 
            EventJob::class,      // Intermediate model
            'job_id',             // Foreign key on EventJob (connecting to Transaction)
            'event_id',           // Foreign key on Event (connecting to EventJob)
            'job_id',             // Local key on Transaction (connecting to EventJob)
            'event_id'            // Local key on EventJob (connecting to Event)
        );
    }

    public function Hiring_request()
    {
        return $this->belongsTo(Hiring_request::class, 'hiring_request_id');
    }

    public function payment_proofs()
    {
        return $this->hasMany(PaymentProof::class, 'transaction_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'transaction_id');
    }
}
