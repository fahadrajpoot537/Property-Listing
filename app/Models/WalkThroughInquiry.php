<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkThroughInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'off_market_listing_id',
        'user_id',
        'sender_id',
        'name',
        'email',
        'phone',
        'message',
        'preferred_time',
        'status',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function offMarketListing()
    {
        return $this->belongsTo(OffMarketListing::class, 'off_market_listing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
