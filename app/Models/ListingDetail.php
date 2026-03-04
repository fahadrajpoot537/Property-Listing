<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingDetail extends Model
{
    protected $guarded = [];
    protected $table = 'listing_details';
    protected $casts = [
        'key_features' => 'array',
        'tags' => 'array',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
