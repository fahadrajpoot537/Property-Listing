<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffMarketDetail extends Model
{
    protected $guarded = [];
    protected $table = 'off_market_details';
    protected $casts = [
        'key_features' => 'array',
        'tags' => 'array',
    ];

    public function offMarketListing()
    {
        return $this->belongsTo(OffMarketListing::class, 'off_market_listings_id');
    }
}
