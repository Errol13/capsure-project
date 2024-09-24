<?php

namespace App\Models;

use App\Models\Hiring\Event;
use App\Models\Profile\Chat;
use App\Models\Profile\Otp;
use App\Models\Profile\Report;
use App\Models\Profile\Service;
use App\Models\Profile\SocialMediaAccount;
use App\Models\Profile\Suspension;
use App\Models\Profile\Verification;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        return $this->user_type === 'admin' && $this->hasVerifiedEmail(); // Access control for Filament
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

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'sender');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'recipient');
    }

    public function otp()
    {
        return $this->hasOne(Otp::class, 'user_id');
    }

    public function verification()
    {
        return $this->hasOne(Verification::class, 'user_id');
    }

    public function submittedReports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function suspension()
    {
        return $this->hasOne(Suspension::class, 'user_id');
    }


    public function getProfileImageUrlAttribute()
    {
        
        $filePath = 'storage/' . $this->profile_image;
        
        if ($this->profile_image && Storage::disk('public')->exists($this->profile_image)) {
            return asset(str_replace(' ', '%20', $filePath)); 
        }
    
        return asset('assets/daisy.svg'); 
    }
    

}
