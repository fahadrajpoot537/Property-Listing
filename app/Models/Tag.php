<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }

    public function offMarketListings()
    {
        return $this->belongsToMany(OffMarketListing::class, 'off_market_listing_tag');
    }
}
