<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\OffMarketListing;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MapController extends Controller
{
    public function index(Request $request)
    {
        // Pass any initial data needed for the map
        $initialProperties = collect([]);
        $propertyTypes = \App\Models\PropertyType::all();
        $listingType = $request->input('type', 'regular'); // 'regular' or 'off_market'

        return view('map', compact('initialProperties', 'propertyTypes', 'listingType'));
    }

    public function getProperties(Request $request)
    {
        // Rate limiting check could be added here if needed

        $bounds = $request->input('bounds');
        $zoomLevel = $request->input('zoom_level');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');
        $propertyType = $request->input('property_type');
        $polygon = $request->input('polygon'); // Points for drawn polygon
        $listingType = $request->input('listing_type', 'regular'); // 'regular' or 'off_market'
        $purpose = $request->input('purpose');
        $bedrooms = $request->input('bedrooms');

        // Build cache key
        $cacheKey = 'map_properties_' . md5(serialize([
            'bounds' => $bounds,
            'zoom' => $zoomLevel,
            'min' => $priceMin,
            'max' => $priceMax,
            'type' => $propertyType,
            'polygon' => $polygon,
            'listing_type' => $listingType,
            'purpose' => $purpose,
            'bedrooms' => $bedrooms
        ]));

        // Check if cached
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        // Determine which model to use based on listing type
        if ($listingType === 'off_market') {
            $query = OffMarketListing::query()->where('status', 'approved');
        } else {
            $query = Listing::query()->where('status', 'approved');
        }

        // Apply bounds filtering if provided
        if ($bounds && isset($bounds['southwest']['lat'], $bounds['northeast']['lng'])) {
            $swLat = $bounds['southwest']['lat'];
            $swLng = $bounds['southwest']['lng'];
            $neLat = $bounds['northeast']['lat'];
            $neLng = $bounds['northeast']['lng'];

            $query->whereBetween('latitude', [$swLat, $neLat])
                ->whereBetween('longitude', [$swLng, $neLng]);
        }

        // Apply polygon filtering if provided
        if ($polygon) {
            $points = $polygon;
            $query = $this->applyPolygonFilter($query, $points);
        }

        // Apply additional filters
        if ($priceMin) {
            $query->where('price', '>=', $priceMin);
        }
        if ($priceMax) {
            $query->where('price', '<=', $priceMax);
        }
        if ($propertyType) {
            // Assuming property_type_id corresponds to property_type table
            $query->where('property_type_id', $propertyType);
        }
        if ($bedrooms) {
            $query->where('bedrooms', '>=', $bedrooms);
        }
        if ($purpose) {
            if (strtolower($purpose) == 'buy') {
                $query->whereIn('purpose', ['Buy', 'buy', 'Sale', 'sale', 'for-sale']);
            } elseif (strtolower($purpose) == 'rent') {
                $query->whereIn('purpose', ['Rent', 'rent', 'for-rent', 'to-rent']);
            } else {
                $query->where('purpose', $purpose);
            }
        }

        // Limit results for performance
        $properties = $query->with('features', 'user')->limit(500)->get();

        // Format the response
        $formattedProperties = $properties->map(function ($property) use ($listingType) {
            $images = is_string($property->gallery) ? json_decode($property->gallery, true) : $property->gallery;
            $firstImage = null;
            if ($images && is_array($images) && isset($images[0])) {
                // Handle case where image path might already include gallery/ prefix
                $imagePath = $images[0];
                if (strpos($imagePath, 'gallery/') === 0) {
                    $firstImage = asset('storage/' . $imagePath);
                } else {
                    $firstImage = asset('storage/gallery/' . $imagePath);
                }
            } elseif ($property->thumbnail) {
                $firstImage = asset('storage/' . $property->thumbnail);
            }

            return [
                'id' => $property->id,
                'title' => $property->property_title,
                'price' => $property->price,
                'address' => $property->address,
                'lat' => $property->latitude,
                'lng' => $property->longitude,
                'image' => $firstImage,
                'description' => strlen($property->description) > 100 ?
                    substr($property->description, 0, 100) . '...' :
                    $property->description,
                'purpose' => $property->purpose,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'area_size' => $property->area_size,
                'listing_type' => $listingType, // Indicate whether it's regular or off_market
            ];
        });

        $response = [
            'properties' => $formattedProperties,
            'total' => $properties->count(),
            'bounds' => $bounds
        ];

        // Cache for 5 minutes
        Cache::put($cacheKey, $response, now()->addMinutes(5));

        return response()->json($response);
    }

    /**
     * Apply polygon filter to query
     */
    private function applyPolygonFilter($query, $points)
    {
        // This is a simplified approach. For production, you'd want to use
        // MySQL's ST_Contains function or implement a proper point-in-polygon algorithm

        // For now, we'll just return the query as-is
        // A full implementation would involve more complex spatial calculations
        return $query;
    }
}