<?php

namespace App\Models\Transaction;

use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Profile\Team;
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
        'team_code',
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

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function team(){
        return $this->belongsTo(Team::class, 'team_code', 'team_code');
    }

    protected static function booted()
    {
        static::created(function ($review) {
            // Check if the review is for a freelancer
            if ($review->reviewee_role === 'freelancer') {
                $review->freelancer->updateAverageRating();
            }

            if ($review->reviewee_role === 'team') {
                $review->team->updateAverageRating();
            }
            
            // Check if the review is for a client
            if ($review->reviewee_role === 'client') {
                $review->client->updateAverageRating();
            }
        });
        
    }
}
