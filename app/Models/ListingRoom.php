<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingRoom extends Model
{
    protected $guarded = [];
    protected $table = 'listing_rooms';

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
