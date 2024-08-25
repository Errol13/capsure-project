<?php

namespace App\Models\Hiring;

use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hiring_request extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',
        'job_id',
        'client_id',
        'client_pricing',
        'freelancer_pricing',
        'status',
        'date_created',
        'date_modified',
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'hiring_request_id');
    }
}
