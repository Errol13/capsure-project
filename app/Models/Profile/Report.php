<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reported_user_id',
        'reason',
        'details',
        'proof_img',
        'isArchived',
        'reporter_id',
    ];

    public function reporterUser(){
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
