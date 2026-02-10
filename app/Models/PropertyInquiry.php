<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    protected $fillable = [
        'listing_id',
        'name',
        'email',
        'phone',
        'message',
        'bedrooms',
        'bathrooms',
        'price',
        'latitude',
        'longitude',
        'property_type_id',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function notifications()
    {
        return $this->hasMany(NotifiedListing::class);
    }
}
