<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifiedListing extends Model
{
    protected $fillable = [
        'property_inquiry_id',
        'listing_id',
    ];

    public function inquiry()
    {
        return $this->belongsTo(PropertyInquiry::class, 'property_inquiry_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
