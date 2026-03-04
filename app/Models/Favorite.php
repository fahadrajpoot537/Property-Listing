<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Added this line

class Favorite extends Model
{
    use HasFactory; // Added this line

    protected $fillable = [
        'user_id',
        'listing_id',
        'off_market_listing_id',
        'notes', // Added this line
        'status', // Added this line
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function offMarketListing()
    {
        return $this->belongsTo(OffMarketListing::class);
    }
}
