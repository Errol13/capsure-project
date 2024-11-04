<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp_code',
        'expires_at',
        'isUsed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verification()
    {
        return $this->belongsTo(Verification::class, 'verification_id');
    }
}
