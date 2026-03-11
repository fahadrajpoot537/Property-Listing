<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $listingId = $this->route('listing');
        $offMarketId = $this->route('off_market_listing');
        $id = $listingId ?: $offMarketId;
        $table = $listingId ? 'listings' : 'off_market_listings';

        return [
            'category_id' => 'required|exists:categories,id',
            'property_title' => 'required|string|max:255',
            'description' => 'nullable|string|max:32000',
            'purpose' => 'required|in:Rent,Buy',
            'price' => 'required|numeric|min:0',
            'price_qualifier' => 'nullable|string',
            'old_price' => 'nullable|numeric|min:0',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'bedrooms' => 'nullable|string',
            'bathrooms' => 'nullable|string',
            'reception_rooms' => 'nullable|string',
            'area_size' => 'nullable|string',
            'floor_level' => 'nullable|string',
            'property_type_id' => 'nullable|exists:property_types,id',
            'sub_type' => 'nullable|string',
            'property_reference_number' => 'nullable|string|max:255',
            'slug' => [
                'nullable',
                'string',
                Rule::unique($table)->ignore($id),
            ],

            // Media
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'floor_plans.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'epc_upload' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'virtual_tour_url' => 'nullable|url',
            'brochure_pdf' => 'nullable|file|mimes:pdf|max:10240',

            // Material Info
            'tenure' => 'nullable|string',
            'unexpired_years' => 'nullable|string',
            'ground_rent' => 'nullable|string',
            'service_charge' => 'nullable|string',
            'council_tax_band' => 'nullable|string',
            'parking_type' => 'nullable|string',
            'parking_spaces_count' => 'nullable|string',
            'construction_type' => 'nullable|string',
            'accessibility' => 'nullable|string',
            'rights_restrictions' => 'nullable|string',
            'listed_property' => 'nullable|string',
            'flood_risk' => 'nullable|string',
            'cladding_risk' => 'nullable|string',
            'other_risks' => 'nullable|string',

            // Utilities
            'utilities_water' => 'nullable|string',
            'utilities_electricity' => 'nullable|string',
            'utilities_sewerage' => 'nullable|string',
            'utilities_heating' => 'nullable|string',
            'utilities_broadband' => 'nullable|string',
            'utilities_mobile' => 'nullable|string',

            // Details
            'features' => 'nullable|array',
            'amenities' => 'nullable|array',
            'tags' => 'nullable|array',
            'government_scheme' => 'nullable|string',
            'deposit' => 'nullable|string',
            'availability_date' => 'nullable|date',
        ];
    }
}
