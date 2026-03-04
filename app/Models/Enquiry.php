<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Listing;
use App\Models\OffMarketListing;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listing_id',
        'off_market_listing_id',
        'agent_email',
        'message',
        'status',
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
