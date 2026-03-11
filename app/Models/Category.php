<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function propertyTypes()
    {
        return $this->hasMany(PropertyType::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function offMarketListings()
    {
        return $this->hasMany(OffMarketListing::class);
    }
}
