<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_code',
        'total_earnings',
        'is_verified',
        'otp',
        'otp_expires_at',
        'status',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'otp_expires_at' => 'datetime',
        'total_earnings' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
