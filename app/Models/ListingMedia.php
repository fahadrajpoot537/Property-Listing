<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingMedia extends Model
{
    protected $guarded = [];
    protected $table = 'listing_media';

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
