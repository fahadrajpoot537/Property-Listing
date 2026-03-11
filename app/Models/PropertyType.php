<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'description',
    ];



    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function offMarketListings()
    {
        return $this->hasMany(OffMarketListing::class);
    }

    /**
     * Get the name attribute as an alias for title
     */
    public function getNameAttribute()
    {
        return $this->title;
    }
}
