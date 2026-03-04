<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingMaterialInfo extends Model
{
    protected $guarded = [];
    
    protected $table = 'listing_material_info';

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
