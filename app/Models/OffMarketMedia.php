<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffMarketMedia extends Model
{
    protected $guarded = [];
    protected $table = 'off_market_media';

    public function offMarketListing()
    {
        return $this->belongsTo(OffMarketListing::class, 'off_market_listings_id');
    }
}
