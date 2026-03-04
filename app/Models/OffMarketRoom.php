<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffMarketRoom extends Model
{
    protected $guarded = [];
    protected $table = 'off_market_rooms';

    public function offMarketListing()
    {
        return $this->belongsTo(OffMarketListing::class, 'off_market_listings_id');
    }
}
