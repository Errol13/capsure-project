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
        'path',
        'freelancer_id',
    ];

    protected $primaryKey = 'portfolio_id';

    public $incrementing = true;

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
