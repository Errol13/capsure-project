<?php

namespace App\Models;

use App\Models\Hiring\Event;
use App\Models\Profile\Service;
use App\Models\Profile\SocialMediaAccount;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasName
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
    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
   

    public function canAccessFilament(): bool
    {
        return $this->user_type === 'admin'&& $this->hasVerifiedEmail(); // Access control for Filament
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Your logic for access control
        return str_ends_with($this->email, 'admin@gmail.com') && $this->hasVerifiedEmail();
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, Client::class, 'user_id', 'client_id');
    }

    public function freelancer()
    {
        return $this->hasOne(Freelancer::class, 'user_id');
    }

    public function socmed()
    {
        return $this->hasMany(SocialMediaAccount::class, 'user_id');
    }

}
