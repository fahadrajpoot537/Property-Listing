<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
        'id_card',
        'passport',
        'company_details',
        'slug',
        'agency_id',
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
}
