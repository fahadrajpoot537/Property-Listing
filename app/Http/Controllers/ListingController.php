<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        // Debug: Log all request parameters
        Log::info('Search Request:', $request->all());

        // Additional debug info
        if ($request->filled('lat') && $request->filled('lng')) {
            Log::info('Coordinates received: lat=' . $request->lat . ', lng=' . $request->lng);
        }
        if ($request->filled('location')) {
            Log::info('Location received: ' . $request->location);
        }
        if ($request->filled('radius')) {
            Log::info('Radius received: ' . $request->radius);
        }

        $query = Listing::query()->where('status', 'approved');

        // Purpose (Buy/Rent)
        if ($request->filled('purpose') && $request->purpose != '') {
            $query->where('purpose', $request->purpose);
            Log::info('Filtering by purpose: ' . $request->purpose);
        }

        // Location & Radius Search
        if ($request->filled('lat') && $request->filled('lng')) {
            $lat = $request->lat;
            $lng = $request->lng;

            // Use provided radius or default to 2 miles if not specified
            $radius = $request->filled('radius') && $request->radius != '' ? (float) $request->radius : 2;

            // Ensure a minimum small radius to capture properties at the exact location
            if ($radius <= 0)
                $radius = 0.1;

            Log::info('COORDINATES DEBUG: Lat=' . $lat . ', Lng=' . $lng . ', Radius=' . $radius);

            $query->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) <= ?", [$lat, $lng, $lat, $radius]);
            Log::info('Filtering by radius: ' . $radius . ' miles from lat: ' . $lat . ', lng: ' . $lng);
        } elseif ($request->filled('location') && $request->location != '') {
            $location = $request->location;

            // If radius is provided, try geocoding for radius search
            if ($request->filled('radius') && $request->radius != '') {
                $radius = (float) $request->radius;

                // Ensure a minimum small radius
                if ($radius <= 0)
                    $radius = 0.1;

                // Attempt to geocode the location to get coordinates for radius search
                $coordinates = $this->geocodeAddress($location);

                if ($coordinates) {
                    $lat = $coordinates['lat'];
                    $lng = $coordinates['lng'];

                    $query->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) <= ?", [$lat, $lng, $lat, $radius]);
                    Log::info('Filtering by radius: ' . $radius . ' miles from geocoded lat: ' . $lat . ', lng: ' . $lng);
                } else {
                    // Fallback to basic location search if geocoding fails
                    $query->where('address', 'like', '%' . $location . '%');
                    Log::info('Geocoding failed, falling back to location search: ' . $location);
                }
            } else {
                // No radius specified, do basic location search
                $searchParts = explode(',', $location);
                $mainLocation = trim($searchParts[0]);
                $query->where('address', 'like', '%' . $mainLocation . '%');
                Log::info('Filtering by main location part: ' . $mainLocation);
            }
        }

        // Property Type
        if ($request->filled('property_type_id')) {
            $query->where('property_type_id', $request->property_type_id);
            Log::info('Filtering by property_type_id: ' . $request->property_type_id);
        } elseif ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
            Log::info('Filtering by property_type (alias): ' . $request->property_type);
        }

        // Bathrooms
        if ($request->filled('bathrooms') && $request->bathrooms !== 'any' && $request->bathrooms != '') {
            $query->where('bathrooms', '>=', (int) $request->bathrooms);
            Log::info('Filtering by bathrooms: ' . $request->bathrooms);
        } elseif ($request->filled('min_bathrooms') && $request->min_bathrooms != '') {
            $query->where('bathrooms', '>=', (int) $request->min_bathrooms);
            Log::info('Filtering by min_bathrooms: ' . $request->min_bathrooms);
        }

        // Bedrooms
        if ($request->filled('bedrooms') && $request->bedrooms !== 'any' && $request->bedrooms != '') {
            $query->where('bedrooms', '>=', (int) $request->bedrooms);
            Log::info('Filtering by bedrooms: ' . $request->bedrooms);
        } elseif ($request->filled('min_bedrooms') && $request->min_bedrooms != '') {
            $query->where('bedrooms', '>=', (int) $request->min_bedrooms);
            Log::info('Filtering by min_bedrooms (alias): ' . $request->min_bedrooms);
        }

        // Price
        if ($request->filled('min_price') && $request->min_price != '' && $request->min_price > 0) {
            $query->where('price', '>=', (float) $request->min_price);
            Log::info('Filtering by min_price: ' . $request->min_price);
        }
        if ($request->filled('max_price') && $request->max_price != '' && (float) $request->max_price < 10000000 && (float) $request->max_price > 0) {
            $query->where('price', '<=', (float) $request->max_price);
            Log::info('Filtering by max_price: ' . $request->max_price);
        }

        // Size
        if ($request->filled('min_size') && $request->min_size != '' && $request->min_size > 0) {
            $query->where('area_size', '>=', (int) $request->min_size);
            Log::info('Filtering by min_size: ' . $request->min_size);
        }
        if ($request->filled('max_size') && $request->max_size != '' && (int) $request->max_size < 20000 && (int) $request->max_size > 0) {
            $query->where('area_size', '<=', (int) $request->max_size);
            Log::info('Filtering by max_size: ' . $request->max_size);
        }

        // Unit Type
        if ($request->filled('unit_type_id')) {
            $query->where('unit_type_id', $request->unit_type_id);
            Log::info('Filtering by unit_type_id: ' . $request->unit_type_id);
        }

        // Discounted Properties Filter
        if ($request->filled('discounted') && $request->discounted == '1') {
            // Include anything with an old price that is different from current price
            $query->whereNotNull('old_price')
                ->where('old_price', '>', 0)
                ->whereRaw('old_price != price');
            Log::info('Filtering by discounted properties');
        }

        // Ownership Status
        if ($request->filled('ownership_status_id')) {
            $query->where('ownership_status_id', $request->ownership_status_id);
            Log::info('Filtering by ownership_status_id: ' . $request->ownership_status_id);
        }

        // Rent Frequency
        if ($request->filled('rent_frequency_id')) {
            $query->where('rent_frequency_id', $request->rent_frequency_id);
            Log::info('Filtering by rent_frequency_id: ' . $request->rent_frequency_id);
        }

        // Cheque Options
        if ($request->filled('cheque_id')) {
            $query->where('cheque_id', $request->cheque_id);
            Log::info('Filtering by cheque_id: ' . $request->cheque_id);
        }

        // Features
        if ($request->filled('feature_ids') || $request->filled('features')) {
            $features = $request->filled('feature_ids')
                ? array_filter((array) $request->feature_ids)
                : array_filter(explode(',', $request->features));

            if (!empty($features)) {
                $query->whereHas('features', function ($q) use ($features) {
                    $q->whereIn('features.id', $features);
                });
                Log::info('Filtering by features: ' . implode(',', $features));
            }
        }

        // Sorting
        if ($request->sort == 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $listings = $query->with('features', 'user')->paginate(12)->withQueryString();
        $features_all = Feature::all();
        $latest_listings = Listing::with('features')->where('status', 'approved')->latest()->take(4)->get();

        Log::info('Total listings found: ' . $listings->total());

        $user_favorite_ids = [];
        if (auth()->check()) {
            $user_favorite_ids = \App\Models\Favorite::where('user_id', auth()->id())
                ->pluck('listing_id')
                ->filter()
                ->toArray();
        }

        if (view()->exists('property-halfmap-grid')) {
            return view('property-halfmap-grid', compact('listings', 'features_all', 'latest_listings', 'user_favorite_ids'));
        }

        return view('listings.index', compact('listings', 'features_all', 'latest_listings', 'user_favorite_ids'));
    }

    public function show($id)
    {
        $listing = Listing::with(['features', 'user', 'propertyType', 'unitType'])->findOrFail($id);

        // Get similar properties
        $similar_listings = Listing::with('features')->where('status', 'approved')
            ->where('id', '!=', $id)
            ->where('purpose', $listing->purpose)
            ->latest()
            ->take(3)
            ->get();

        $user_favorite_ids = [];
        if (auth()->check()) {
            $user_favorite_ids = \App\Models\Favorite::where('user_id', auth()->id())
                ->pluck('listing_id')
                ->filter()
                ->toArray();
        }

        return view('property-detail', compact('listing', 'similar_listings', 'user_favorite_ids'));
    }

    public function getPropertyTypeListings(Request $request)
    {
        $type = $request->input('type');
        $purpose = $request->input('purpose', 'Buy');

        $query = Listing::with('features', 'user')
            ->where('status', 'approved')
            ->where('purpose', $purpose);

        switch (strtolower($type)) {
            case 'villas':
                $query->whereHas('propertyType', function ($q) {
                    $q->where('title', 'LIKE', '%villa%');
                });
                break;
            case 'apartments':
                $query->whereHas('propertyType', function ($q) {
                    $q->where('title', 'LIKE', '%apartment%');
                });
                break;
            case 'houses':
                $query->whereHas('propertyType', function ($q) {
                    $q->where('title', 'LIKE', '%house%');
                });
                break;
            case 'condos':
                $query->whereHas('propertyType', function ($q) {
                    $q->where('title', 'LIKE', '%condo%');
                });
                break;
            case 'retail':
                $query->whereHas('propertyType', function ($q) {
                    $q->where('title', 'LIKE', '%retail%');
                });
                break;
            default:
                // Default to all property types
                break;
        }

        $listings = $query->latest()->take(6)->get();

        // Generate HTML for the listings
        $html = '';
        if ($listings->count() > 0) {
            foreach ($listings as $listing) {
                $imageSrc = $listing->images && count($listing->images) > 0
                    ? Storage::url($listing->images[0])
                    : asset('assets/img/all-images/properties/property-img2.png');

                $html .= '<div class="col-lg-4 col-md-6">';
                $html .= '    <div class="property-boxarea">';
                $html .= '        <div class="img1 image-anime">';
                $html .= '            <img src="' . $imageSrc . '" alt="' . htmlspecialchars($listing->title) . '" onerror="this.src=\'' . asset('assets/img/all-images/properties/property-img2.png') . '\';">';
                $html .= '        </div>';
                $html .= '        <div class="category-list">';
                $html .= '            <ul>';
                $html .= '                <li><a href="/property/' . $listing->id . '">Featured</a></li>';
                $html .= '                <li><a href="/property/' . $listing->id . '">' . htmlspecialchars($listing->purpose) . '</a></li>';
                $html .= '            </ul>';
                $html .= '        </div>';
                $html .= '        <div class="content-area">';
                $html .= '            <a href="/property/' . $listing->id . '">' . htmlspecialchars($listing->title) . '</a>';
                $html .= '            <div class="space18"></div>';
                $html .= '            <p>' . htmlspecialchars($listing->location ?? $listing->city) . ', ' . htmlspecialchars($listing->state ?? 'UK') . '</p>';
                $html .= '            <div class="space24"></div>';
                $html .= '            <ul>';
                $html .= '                <li><a href="#"><img src="' . asset('assets/img/icons/bed1.svg') . '" alt="housebox">' . ($listing->bedrooms ?? 'N/A') . '</a></li>';
                $html .= '                <li><a href="#"><img src="' . asset('assets/img/icons/bath1.svg') . '" alt="housebox">' . ($listing->bathrooms ?? 'N/A') . '</a></li>';
                $html .= '                <li><a href="#"><img src="' . asset('assets/img/icons/sqare1.svg') . '" alt="housebox">' . ($listing->area_size ?? 'N/A') . ' sq</a></li>';
                $html .= '            </ul>';
                $html .= '            <div class="btn-area">';
                $html .= '                <a href="#" class="nm-btn">£' . number_format($listing->price) . '</a>';
                $html .= '                <a href="javascript:void(0)" class="heart">';
                $html .= '                    <img src="' . asset('assets/img/icons/heart1.svg') . '" alt="housebox" class="heart1">';
                $html .= '                    <img src="' . asset('assets/img/icons/heart2.svg') . '" alt="housebox" class="heart2">';
                $html .= '                </a>';
                $html .= '            </div>';
                $html .= '        </div>';
                $html .= '    </div>';
                $html .= '</div>';
            }
        } else {
            $purposeText = $purpose == 'Buy' ? 'for sale' : 'for rent';
            $html = '<div class="col-12"><p class="text-center">No ' . $purposeText . ' ' . $type . ' available at the moment.</p></div>';
        }

        return response()->json(['html' => $html]);
    }

    public function getFeaturedListings(Request $request)
    {
        $purpose = $request->input('purpose', 'Buy'); // Default to 'Buy' if not specified

        $listings = Listing::with('features', 'user')
            ->where('status', 'approved')
            ->where('purpose', $purpose)
            ->latest()
            ->take(6)
            ->get();

        // Process listings to add images array
        $processedListings = $listings->map(function ($listing) {
            $images = [];

            // Handle gallery field (could be JSON string or array)
            if ($listing->gallery) {
                if (is_string($listing->gallery)) {
                    $gallery = json_decode($listing->gallery, true);
                } else {
                    $gallery = $listing->gallery;
                }

                if (is_array($gallery) && !empty($gallery)) {
                    $images = $gallery;
                }
            }

            // Add thumbnail if available and not already in images
            if ($listing->thumbnail && !in_array($listing->thumbnail, $images)) {
                array_unshift($images, $listing->thumbnail); // Add to beginning
            }

            // Return listing with images array
            $listingArray = $listing->toArray();
            $listingArray['images'] = $images;

            return $listingArray;
        });

        return response()->json([
            'listings' => $processedListings,
            'purpose' => $purpose
        ]);
    }

    public function map(Request $request)
    {
        $query = Listing::query()->where('status', 'approved');

        // Purpose (Buy/Rent)
        if ($request->filled('purpose') && $request->purpose != '') {
            $query->where('purpose', $request->purpose);
        }

        // Location & Radius Search
        if ($request->filled('lat') && $request->filled('lng')) {
            $lat = $request->lat;
            $lng = $request->lng;

            // Use provided radius or default to 2 miles if not specified (more precise for postal codes)
            $radius = $request->filled('radius') && $request->radius != '' ? $request->radius : 2;

            $query->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) < ?", [$lat, $lng, $lat, $radius]);
        } elseif ($request->filled('location') && $request->location != '') {
            $location = $request->location;

            // If radius is provided, try geocoding for radius search
            if ($request->filled('radius') && $request->radius != '') {
                $radius = $request->radius;

                // Attempt to geocode the location to get coordinates for radius search
                $coordinates = $this->geocodeAddress($location);

                if ($coordinates) {
                    $lat = $coordinates['lat'];
                    $lng = $coordinates['lng'];

                    $query->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) < ?", [$lat, $lng, $lat, $radius]);
                } else {
                    // Fallback to basic location search if geocoding fails
                    $query->where('address', 'like', '%' . $location . '%');
                }
            } else {
                // No radius specified, do basic location search
                $query->where('address', 'like', '%' . $location . '%');
            }
        }

        // Bathrooms
        if ($request->filled('bathrooms') && $request->bathrooms !== 'any' && $request->bathrooms != '') {
            $query->where('bathrooms', '>=', (int) $request->bathrooms);
        }

        // Bedrooms
        if ($request->filled('bedrooms') && $request->bedrooms !== 'any' && $request->bedrooms != '') {
            $query->where('bedrooms', '>=', (int) $request->bedrooms);
        }

        // Price
        if ($request->filled('min_price') && $request->min_price != '' && $request->min_price > 0) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price') && $request->max_price != '' && (float) $request->max_price < 10000000 && (float) $request->max_price > 0) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Size
        if ($request->filled('min_size') && $request->min_size != '' && $request->min_size > 0) {
            $query->where('area_size', '>=', (int) $request->min_size);
        }
        if ($request->filled('max_size') && $request->max_size != '' && (int) $request->max_size < 20000 && (int) $request->max_size > 0) {
            $query->where('area_size', '<=', (int) $request->max_size);
        }

        // Features
        if ($request->filled('feature_ids') || $request->filled('features')) {
            $features = $request->filled('feature_ids')
                ? array_filter((array) $request->feature_ids)
                : array_filter(explode(',', $request->features));

            if (!empty($features)) {
                $query->whereHas('features', function ($q) use ($features) {
                    $q->whereIn('features.id', $features);
                });
            }
        }

        // Apply bounding box filter if provided
        if ($request->filled('bounds')) {
            $bounds = json_decode($request->bounds, true);
            if ($bounds && isset($bounds['north'], $bounds['south'], $bounds['east'], $bounds['west'])) {
                $query->whereBetween('latitude', [$bounds['south'], $bounds['north']])
                    ->whereBetween('longitude', [$bounds['west'], $bounds['east']]);
            }
        }

        // Sorting
        if ($request->sort == 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $listings = $query->with('features', 'user')->paginate(20)->withQueryString();
        $features_all = Feature::all();

        return view('property-map', compact('listings', 'features_all'));
    }

    private function geocodeAddress($address)
    {
        $apiKey = config('services.google.maps_api_key');

        if (!$apiKey) {
            \Illuminate\Support\Facades\Log::warning('Google Maps API key not configured for geocoding');
            return null;
        }

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $output = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($output, true);

            if ($response && $response['status'] === 'OK' && isset($response['results'][0]['geometry']['location'])) {
                $location = $response['results'][0]['geometry']['location'];
                return [
                    'lat' => $location['lat'],
                    'lng' => $location['lng']
                ];
            } else {
                \Illuminate\Support\Facades\Log::warning('Geocoding failed for address: ' . $address . '. Status: ' . ($response['status'] ?? 'Unknown'));
                return null;
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Geocoding error: ' . $e->getMessage());
            return null;
        }
    }
}