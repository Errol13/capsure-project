<?php

namespace App\Models\Profile;

use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'album_name',
        'image',
        'freelancer_id',
    ];

    protected $casts = [
        'image' => 'array',
    ];


    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'user_id');
    }
}
