<?php

namespace App\Models;

use App\Models\Profile\Service;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_joined',
        'birthdate',
        'age',
        'street',
        'barangay',
        'city',
        'contact_number',
        'isNumberVerified',
        'profile_image',
        'isVerified',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_joined' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function freelancer()
    {
        return $this->hasOne(Freelancer::class, 'user_id');
    }

    public function socmed(){
        return $this->hasMany(SocialMediaAccount::class, 'user_id');
    }
}
