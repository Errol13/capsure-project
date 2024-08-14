<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;

    protected $fillable = [
        'cert_id',
        'title',
        'date',
        'image',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'user_id');
    }
}
