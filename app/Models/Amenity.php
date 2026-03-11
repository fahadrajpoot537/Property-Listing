<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }

    public function offMarketListings()
    {
        return $this->belongsToMany(OffMarketListing::class, 'amenity_off_market_listing');
    }
}
