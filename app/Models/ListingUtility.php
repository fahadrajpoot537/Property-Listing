<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingUtility extends Model
{
    protected $guarded = [];
    protected $table = 'listing_utilities';

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
