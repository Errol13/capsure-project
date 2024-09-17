<?php

namespace App\Models\Transaction;

use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewee_role',
        'client_id',
        'freelancer_id',
        'transaction_id',
        'rating',
        'content',
        'review_date',
    ];

    protected $primaryKey = 'review_id';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
