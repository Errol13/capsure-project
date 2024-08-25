<?php

namespace App\Models\Transaction;

use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Specify the table name if it is not the plural form of the model name
    protected $table = 'transactions';

    // Define the fillable attributes
    protected $fillable = [
        'client_id',
        'freelancer_id',
        'job_id',
        'payment_amount',
        'payment_status',
        'transaction_status',
        'hiring_request_id',
    ];

    // Define relationships
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'user_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'user_id');
    }

    public function eventjobs()
    {
        return $this->belongsTo(EventJob::class, 'job_id');
    }

    public function Hiring_request()
    {
        return $this->belongsTo(Hiring_request::class, 'hiring_request_id');
    }
}
