<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_type_id',
        'title',
        'slug',
    ];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
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
