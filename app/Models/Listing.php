<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_title',
        'description',
        'property_reference_number',
        'purpose',
        'price',
        'old_price',
        'area_size',
        'bedrooms',
        'bathrooms',
        'property_type_id',
        'unit_type_id',
        'ownership_status_id',
        'sale_status',
        'rent_frequency_id',
        'cheque_id',
        'thumbnail',
        'gallery',
        'video',
        'brochure_pdf',
        'address',
        'latitude',
        'longitude',
        'slug',
        'status',
        'council_tax_band',
        'epc_rating',
        'floors_count',
        'availability_date',
        'no_onward_chain',
        'private_rights_of_way',
        'public_rights_of_way',
        'listed_property',
        'restrictions',
        'flood_risk',
        'flood_history',
        'flood_defenses',
        'floor_plans',
    ];

    protected $casts = [
        'gallery' => 'array',
        'floor_plans' => 'array',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function unitType()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_listing');
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
}
