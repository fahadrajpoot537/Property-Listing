<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffMarketListing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'gallery' => 'array',
        'floor_plans' => 'array',
        'key_features' => 'array',
        'price' => 'decimal:2',
    ];

    public function materialInfo()
    {
        return $this->hasOne(OffMarketMaterialInfo::class, 'off_market_listings_id');
    }

    public function utilities()
    {
        return $this->hasOne(OffMarketUtility::class, 'off_market_listings_id');
    }

    public function media()
    {
        return $this->hasMany(OffMarketMedia::class, 'off_market_listings_id');
    }

    public function rooms()
    {
        return $this->hasMany(OffMarketRoom::class, 'off_market_listings_id');
    }

    public function details()
    {
        return $this->hasOne(OffMarketDetail::class, 'off_market_listings_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_off_market_listing');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_off_market_listing');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'off_market_listing_tag');
    }

    public function ownershipStatus()
    {
        return $this->belongsTo(OwnershipStatus::class);
    }

    public function rentFrequency()
    {
        return $this->belongsTo(RentFrequency::class);
    }

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }

    public function getPostcodeAttribute()
    {
        $pattern = '/([A-Z]{1,2}[0-9][A-Z0-9]?\s?[0-9][A-Z]{2})/i';
        if (preg_match($pattern, $this->address, $matches)) {
            return strtoupper($matches[1]);
        }
        return null;
    }
}
