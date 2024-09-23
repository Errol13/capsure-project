<?php

namespace App\Models;

use App\Models\Hiring\Event;
use App\Models\Hiring\Hiring_request;
use App\Models\Transaction\Review;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'total_job_posted',
        'total_successful_hiring',
        'hiring_rate',
        'avg_rating',
        'favorites'
    ];

    protected $casts = [
        'favorites' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'client_id');
    }

    public function hiringRequests()
    {
        return $this->hasMany(Hiring_request::class, 'client_id');
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'client_id');
    }

    public function getMyReviews()
    {
        return $this->reviews()->where('reviewee_role', 'client')->get();
    }

    //update avg_rating
    public function updateAverageRating()
    {
        $average = $this->getMyReviews()->avg('rating');
        $this->avg_rating = round($average, 1);
        $this->save();
    }
}
