<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone_number',
        'address',
        'latitude',
        'longitude',
        'id_card',
        'passport',
        'company_name',
        'company_registration_number',
        'slug',
        'agency_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password' => 'hashed',
            'company_details' => 'array',
        ];
    }

    /**
     * Get the agency that this user belongs to.
     */
    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    /**
     * Get the team members for this agency/user.
     */
    public function teamMembers()
    {
        return $this->hasMany(User::class, 'agency_id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function offMarketListings()
    {
        return $this->hasMany(OffMarketListing::class);
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function visitorAnalytics()
    {
        return $this->hasMany(VisitorAnalytic::class);
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function savedSearches()
    {
        return $this->hasMany(SavedSearch::class);
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\Auth\ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\Auth\VerifyEmail);
    }
}
