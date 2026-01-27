<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'description',
    ];

    public function parent()
    {
        return $this->belongsTo(Feature::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Feature::class, 'parent_id');
    }

    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'feature_listing');
    }

    public function offMarketListings()
    {
        return $this->belongsToMany(OffMarketListing::class, 'feature_off_market_listing');
    }
}
