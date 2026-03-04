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

            $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, (float) $radius]);
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

                    $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, $radius]);
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
        if ($request->filled('property_type_id') && $request->property_type_id != '') {
            $query->where('property_type_id', $request->property_type_id);
            Log::info('Filtering by property_type_id: ' . $request->property_type_id);
        } elseif ($request->filled('property_type') && $request->property_type != '') {
            $query->where('property_type_id', $request->property_type);
            Log::info('Filtering by property_type (alias): ' . $request->property_type);
        }

        // Bedrooms - Exact match for 0-9, >= for 10+
        $bedrooms = $request->input('bedrooms', $request->input('min_bedrooms'));
        if ($bedrooms !== null && $bedrooms !== 'any' && $bedrooms !== '') {
            $val = (int) $bedrooms;
            if ($val >= 10) {
                $query->where('bedrooms', '>=', 10);
            } else {
                $query->where('bedrooms', $val);
            }
            Log::info('Filtering by bedrooms: ' . $val);
        }

        // Bathrooms - Exact match for 0-9, >= for 10+
        $bathrooms = $request->input('bathrooms', $request->input('min_bathrooms'));
        if ($bathrooms !== null && $bathrooms !== 'any' && $bathrooms !== '') {
            $val = (int) $bathrooms;
            if ($val >= 10) {
                $query->where('bathrooms', '>=', 10);
            } else {
                $query->where('bathrooms', $val);
            }
            Log::info('Filtering by bathrooms: ' . $val);
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
        } elseif ($request->filled('unit_type')) {
            $query->where('unit_type_id', $request->unit_type);
            Log::info('Filtering by unit_type (alias): ' . $request->unit_type);
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
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $listings = $query->with('features', 'user', 'unitType')->paginate(12)->withQueryString();
        $features_all = Feature::all();
        $latest_listings = Listing::with('features', 'unitType')->where('status', 'approved')->latest()->take(4)->get();

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
        $listing = Listing::with(['features', 'user', 'propertyType', 'unitType', 'materialInfo', 'utilities', 'media', 'rooms', 'details'])
            ->where('status', 'approved')
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })
            ->firstOrFail();

        // Get similar properties
        $similar_listings = Listing::with('features')->where('status', 'approved')
            ->where('id', '!=', $listing->id)
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

    public function getSoldPrices($id)
    {
        $listing = Listing::where('status', 'approved')
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })->firstOrFail();
        $postcode = $listing->postcode;

        if (!$postcode) {
            return response()->json(['error' => 'No valid postcode found for this property.'], 404);
        }

        $apiKey = config('services.patma.api_token');
        // Using radius=0.2 (API minimum) and exact address filtering to only show history for this specific property
        $apiUrl = "https://app.patma.co.uk/api/prospector/v1/list-property/?postcode=" . urlencode($postcode) . "&radius=0.2&require_sold_price=true&include_sold_history=true&include_listing_data=true&token=" . $apiKey;

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(30)->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();

                if (!isset($data['status']) || $data['status'] !== 'success') {
                    return response()->json([
                        'error' => 'PaTMa API returned an error.',
                        'message' => $data['errors'] ?? 'Unknown error'
                    ], 400);
                }

                $formattedPrices = [];
                if (isset($data['data']['available_results'])) {
                    // Combine address and title to ensure we capture specifically mentioned flat/house numbers
                    $inputAddress = trim(($listing->address ?? '') . ' ' . ($listing->property_title ?? ''));
                    $inputAddrClean = strtolower(preg_replace('/[^a-z0-9 ]/', ' ', $inputAddress));
                    $inputWords = array_filter(explode(' ', $inputAddrClean));
                    // Remove postcode-like patterns before extracting numbers to avoid matching postcode digits
                    $addrNoPc = preg_replace('/\b[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}\b/i', '', $inputAddress);
                    $inputAddrNoPcNorm = strtolower(preg_replace('/[^a-z0-9]/', '', $addrNoPc));

                    preg_match_all('/\d+/', $addrNoPc, $inputNumbers);
                    $targetNumbers = array_unique($inputNumbers[0] ?? []);

                    foreach ($data['data']['available_results'] as $property) {
                        $score = 0;
                        $resAddr = $property['address'] ?? $property['label'] ?? '';
                        $resAddrClean = strtolower(preg_replace('/[^a-z0-9 ]/', ' ', $resAddr));
                        $normRes = strtolower(preg_replace('/[^a-z0-9]/', '', $resAddr));

                        // 1. Check Full Normalized Match
                        if ($normRes === strtolower(preg_replace('/[^a-z0-9]/', '', $inputAddress)) || $normRes === $inputAddrNoPcNorm) {
                            $score += 500;
                        }

                        // 2. Advanced Match Type Detection
                        // Remove postcode from result address for clean number extraction
                        $resAddrNoPc = preg_replace('/\b[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}\b/i', '', $resAddr);
                        preg_match_all('/\d+/', $resAddrNoPc, $resMatches);
                        $resNumbers = array_unique($resMatches[0] ?? []);

                        $isUnitMatch = false;
                        $isBuildingMatch = false;

                        if (!empty($targetNumbers)) {
                            $missing = array_diff($targetNumbers, $resNumbers);
                            $extra = array_diff($resNumbers, $targetNumbers);

                            if (empty($missing) && empty($extra)) {
                                $isUnitMatch = true;
                                $score += 250;
                            } elseif (!empty($extra)) {
                                // Explicitly a different unit (e.g., viewing 26, result is 28)
                                continue;
                            } elseif (empty($resNumbers)) {
                                // Result has no unit numbers (Building/Street level)
                                $isBuildingMatch = true;
                                $score += 100;
                            } else {
                                // Missing some target numbers or other mismatch
                                continue;
                            }
                        } else {
                            // No numbers in target (rare for UK addresses)
                            $isBuildingMatch = true;
                            $score += 100;
                        }

                        // 3. Check Word Matches (Heavier weight for longer words)
                        foreach ($inputWords as $word) {
                            $word = trim($word);
                            if (strlen($word) > 3 && strpos($resAddrClean, $word) !== false) {
                                $score += 60;
                            } elseif (strlen($word) > 2 && strpos($resAddrClean, $word) !== false) {
                                $score += 20;
                            }
                        }

                        // 4. Substring Match
                        if ($inputAddrNoPcNorm && strlen($inputAddrNoPcNorm) > 5 && strpos($normRes, $inputAddrNoPcNorm) !== false) {
                            $score += 200;
                        }

                        // Bonus: If it starts with the same house number
                        if (!empty($targetNumbers) && preg_match('/^' . $targetNumbers[0] . '\b/', $resAddr)) {
                            $score += 100;
                        }

                        // Threshold for a valid match
                        // Higher score for getSoldPrices since we only want to match the SPECIFIC property
                        if ($score < 200)
                            continue;

                        // Combine sold history and asking price history
                        $history = [];

                        // ONLY include sold history if it's an exact unit match 
                        // (prevents neighbors' sales from appearing if results are at building level)
                        if ($isUnitMatch && isset($property['sold_history']) && is_array($property['sold_history'])) {
                            foreach ($property['sold_history'] as $s) {
                                $s['is_sold'] = true;
                                $history[] = $s;
                            }
                        }

                        // Include asking prices (important for 2025/latest data)
                        if (isset($property['asking_prices']) && is_array($property['asking_prices'])) {
                            foreach ($property['asking_prices'] as $a) {
                                $a['is_sold'] = false;
                                $history[] = $a;
                            }
                        }

                        // Add current price as a listing record
                        if (isset($property['price']) && $property['price'] > 0) {
                            $history[] = [
                                'date' => $property['price_date'] ?? date('Y-m-d'),
                                'amount' => $property['price'],
                                'is_sold' => false,
                                'label' => 'Current Listing'
                            ];
                        }

                        if (!empty($history)) {
                            // Check if this property exists in our database
                            $internalListing = \App\Models\Listing::where(function ($q) use ($property) {
                                $addr = $property['address'] ?? $property['label'] ?? '';
                                if ($addr) {
                                    $q->where('address', 'LIKE', '%' . $addr . '%')
                                        ->orWhere('property_title', 'LIKE', '%' . $addr . '%');
                                }
                            })->first();

                            $internalUrl = $internalListing ? route('listing.show', $internalListing->slug ?? $internalListing->id) : null;

                            foreach ($history as $record) {
                                $formattedPrices[] = [
                                    'date' => $record['date'],
                                    'price' => $record['amount'],
                                    'type' => $property['property_type'] ?? 'Residential',
                                    'name' => $property['address'] ?? $property['label'] ?? 'N/A',
                                    'location' => $property['postcode'] ?? $listing->postcode ?? 'N/A',
                                    'latitude' => $property['latitude'] ?? null,
                                    'longitude' => $property['longitude'] ?? null,
                                    'search_postcode' => $listing->postcode,
                                    'url' => $internalUrl ?? $property['url'] ?? '#',
                                    'is_internal' => (bool) $internalListing,
                                    'is_sold' => $record['is_sold'] ?? true,
                                    'record_label' => $record['label'] ?? ($record['is_sold'] ? 'SOLD' : 'Listing'),
                                    'description' => $property['description_text'] ?? 'No additional description available.',
                                    'images' => $property['site_images'] ?? [],
                                    'tenure' => $property['tenure'] ?? 'N/A',
                                    'bedrooms' => $internalListing->bedrooms ?? $property['bedrooms'] ?? 'N/A',
                                    'bathrooms' => $internalListing->bathrooms ?? $property['bathrooms'] ?? $property['baths'] ?? 'N/A',
                                    'habitable_rooms' => $property['habitable_rooms'] ?? 'N/A',
                                    'floor_area' => $internalListing ? ($internalListing->area_size ? number_format($internalListing->area_size) . ' sq ft' : 'N/A') : (isset($property['floor_area_sqft']) ? number_format($property['floor_area_sqft']) . ' sq ft' : 'N/A'),
                                    'built_form' => $property['built_form'] ?? 'N/A',
                                    'council_tax' => $internalListing->council_tax_band ?? 'N/A',
                                    'epc' => $internalListing->epc_rating ?? 'N/A',
                                    'flood_risk' => $internalListing->flood_risk ?? 'N/A'
                                ];
                            }
                        }
                    }
                }

                // Sort by date descending
                usort($formattedPrices, function ($a, $b) {
                    return strcmp($b['date'], $a['date']);
                });

                return response()->json([
                    'status' => 'success',
                    'prices' => $formattedPrices
                ]);
            }

            return response()->json([
                'error' => 'Failed to fetch sold prices from PaTMa API.',
                'message' => $response->body()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API connection error.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPropertyTypeListings(Request $request)
    {
        $type = $request->input('type');
        $purpose = $request->input('purpose', 'Buy');

        $query = Listing::with('features', 'user', 'unitType')
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
                $html .= '                <li><a href="/property/' . ($listing->slug ?? $listing->id) . '">Featured</a></li>';
                $html .= '                <li><a href="/property/' . ($listing->slug ?? $listing->id) . '">' . htmlspecialchars($listing->purpose) . '</a></li>';
                $html .= '            </ul>';
                $html .= '        </div>';
                $html .= '        <div class="content-area">';
                $html .= '            <a href="/property/' . ($listing->slug ?? $listing->id) . '">' . htmlspecialchars($listing->title) . '</a>';
                $html .= '            <div class="space18"></div>';
                $html .= '            <p>' . htmlspecialchars($listing->location ?? $listing->city) . ', ' . htmlspecialchars($listing->state ?? 'UK') . '</p>';
                $html .= '            <div class="space24"></div>';
                $html .= '            <ul>';
                $html .= '                <li><a href="#"><img src="' . asset('assets/img/icons/bed1.svg') . '" alt="housebox">' . ($listing->bedrooms ?? 'N/A') . '</a></li>';
                $html .= '                <li><a href="#"><img src="' . asset('assets/img/icons/bath1.svg') . '" alt="housebox">' . ($listing->bathrooms ?? 'N/A') . '</a></li>';
                $html .= '                <li><a href="#"><img src="' . asset('assets/img/icons/sqare1.svg') . '" alt="housebox">' . ($listing->area_size ?? 'N/A') . ' sq</a></li>';
                $html .= '            </ul>';
                $html .= '            <div class="btn-area">';
                $html .= '                <a href="/property/' . ($listing->slug ?? $listing->id) . '" class="nm-btn">£' . number_format($listing->price) . '</a>';
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

        $listings = Listing::with('features', 'user', 'unitType')
            ->where('status', 'approved')
            ->where('purpose', $purpose)
            ->latest()
            ->take(6)
            ->get();

        // Process listings to add images array
        $processedListings = $listings->map(function (\App\Models\Listing $listing) {
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

        // Polygon Search
        if ($request->filled('polygon')) {
            $polygon = json_decode($request->polygon, true);
            if (is_array($polygon) && count($polygon) > 2) {
                $wkt = 'POLYGON((';
                $points = [];
                foreach ($polygon as $point) {
                    $points[] = $point['lng'] . ' ' . $point['lat'];
                }
                $points[] = $polygon[0]['lng'] . ' ' . $polygon[0]['lat'];
                $wkt .= implode(',', $points) . '))';

                $query->whereRaw("ST_Contains(ST_GeomFromText(?), POINT(longitude, latitude))", [$wkt]);
            }
        } elseif ($request->filled('lat') && $request->filled('lng')) {
            $lat = $request->lat;
            $lng = $request->lng;

            // Use provided radius or default to 2 miles if not specified (more precise for postal codes)
            $radius = $request->filled('radius') && $request->radius != '' ? $request->radius : 2;

            $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, (float) $radius]);
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

                    $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, (float) $radius]);
                } else {
                    // Fallback to basic location search if geocoding fails
                    $query->where('address', 'like', '%' . $location . '%');
                }
            } else {
                // No radius specified, do basic location search
                $query->where('address', 'like', '%' . $location . '%');
            }
        }

        // Bedrooms - Exact match for 0-9, >= for 10+
        $bedrooms = $request->input('bedrooms', $request->input('min_bedrooms'));
        if ($bedrooms !== null && $bedrooms !== 'any' && $bedrooms !== '') {
            $val = (int) $bedrooms;
            if ($val >= 10) {
                $query->where('bedrooms', '>=', 10);
            } else {
                $query->where('bedrooms', $val);
            }
        }

        // Bathrooms - Exact match for 0-9, >= for 10+
        $bathrooms = $request->input('bathrooms', $request->input('min_bathrooms'));
        if ($bathrooms !== null && $bathrooms !== 'any' && $bathrooms !== '') {
            $val = (int) $bathrooms;
            if ($val >= 10) {
                $query->where('bathrooms', '>=', 10);
            } else {
                $query->where('bathrooms', $val);
            }
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

        $listings = $query->with('features', 'user', 'unitType')->paginate(20)->withQueryString();
        $features_all = Feature::all();
        $latest_listings = Listing::with('unitType')->where('status', 'approved')->latest()->take(3)->get();

        return view('property-map', compact('listings', 'features_all', 'latest_listings'));
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

    public function showExternalDetails(Request $request)
    {
        $postcode = $request->query('postcode');
        $searchPostcode = $request->query('search_postcode'); // New parameter
        $address = $request->query('address');

        // Prefer search_postcode for the API call to replicate the original successful search
        $apiPostcode = $searchPostcode ?: $postcode;

        if (!$apiPostcode) {
            return redirect()->route('home')->with('error', 'Postcode is required');
        }

        // Use the EXACT same API configuration as getSoldPrices
        $apiKey = config('services.patma.api_token');
        $url = "https://app.patma.co.uk/api/prospector/v1/list-property/?postcode=" . urlencode($apiPostcode) . "&radius=0.5&require_sold_price=true&include_listing_data=true&include_sold_history=true&token=" . $apiKey;

        \Illuminate\Support\Facades\Log::info("External Details API Call: {$url}");

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(30)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $property = null;

                \Illuminate\Support\Facades\Log::info("External Details Search: Postcode={$postcode}, Address={$address}");

                if (isset($data['data']['available_results'])) {
                    $lat = $request->query('lat');
                    $lng = $request->query('lng');

                    $bestScore = -1;
                    $bestMatch = null;

                    // Prepare input for matching
                    $inputAddrClean = strtolower(preg_replace('/[^a-z0-9 ]/', ' ', $address));
                    // Remove postcode-like patterns from the end of input for better partial matching
                    $inputAddrNoPc = preg_replace('/\b[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}\b/i', '', $address);
                    $normInputAddrNoPc = strtolower(preg_replace('/[^a-z0-9]/', '', $inputAddrNoPc));

                    $inputWords = array_filter(explode(' ', $inputAddrClean));
                    preg_match_all('/\d+/', $address, $inputNumbers);
                    $targetNumbers = $inputNumbers[0] ?? [];

                    foreach ($data['data']['available_results'] as $res) {
                        $score = 0;
                        $resAddr = $res['address'] ?? $res['label'] ?? '';
                        $resAddrClean = strtolower(preg_replace('/[^a-z0-9 ]/', ' ', $resAddr));
                        $normRes = strtolower(preg_replace('/[^a-z0-9]/', '', $resAddr));

                        // Priority 1: Exact coordinate match
                        if ($lat && $lng && isset($res['latitude'], $res['longitude'])) {
                            if (abs((float) $res['latitude'] - (float) $lat) < 0.0001 && abs((float) $res['longitude'] - (float) $lng) < 0.0001) {
                                $score += 300;
                            }
                        }

                        // 1. Check Full Normalized Match
                        if ($normRes === strtolower(preg_replace('/[^a-z0-9]/', '', $address)) || $normRes === $normInputAddrNoPc) {
                            $score += 500;
                        }

                        // 2. Advanced Match Type Detection
                        // Remove postcode from result address for clean number extraction
                        $resAddrNoPc = preg_replace('/\b[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}\b/i', '', $resAddr);
                        preg_match_all('/\d+/', $resAddrNoPc, $resMatches);
                        $resNumbers = array_unique($resMatches[0] ?? []);

                        if (!empty($targetNumbers)) {
                            $missing = array_diff($targetNumbers, $resNumbers);
                            $extra = array_diff($resNumbers, $targetNumbers);

                            if (empty($missing) && empty($extra)) {
                                // Exact numeric match (e.g., both are Flat 3, 8 ...)
                                $score += 250;
                            } elseif (!empty($extra)) {
                                // Explicitly a different unit (e.g., viewing 26, result is 28)
                                continue;
                            } elseif (empty($resNumbers)) {
                                // Result has no unit numbers (Building/Street level)
                                $score += 100;
                            } else {
                                // Missing some or other mismatch
                                continue;
                            }
                        }

                        // 3. Word Matches
                        foreach ($inputWords as $word) {
                            $word = trim($word);
                            if (strlen($word) > 3 && strpos($resAddrClean, $word) !== false) {
                                $score += 60;
                            } elseif (strlen($word) > 2 && strpos($resAddrClean, $word) !== false) {
                                $score += 20;
                            }
                        }

                        // 4. Substring Match
                        if ($normInputAddrNoPc && strlen($normInputAddrNoPc) > 5 && strpos($normRes, $normInputAddrNoPc) !== false) {
                            $score += 200;
                        }

                        // 5. Data Quality
                        if (!empty($res['site_images']) || !empty($res['images'])) {
                            $score += 50;
                        }

                        if ($score > $bestScore && $score > 150) {
                            $bestScore = $score;
                            $bestMatch = $res;
                        }
                    }

                    $property = $bestMatch;

                    // Fallback to first result ONLY if there is only 1 result and it's a decent guess
                    if (!$property && count($data['data']['available_results']) === 1) {
                        $property = $data['data']['available_results'][0];
                    }
                }

                if ($property) {
                    // Ensure postcode is present, falling back to the requested postcode if API doesn't provide it
                    if (empty($property['postcode'])) {
                        $property['postcode'] = $postcode ?: $searchPostcode;
                    }

                    // Fallback for coordinates from request if missing in API result
                    if (empty($property['latitude']))
                        $property['latitude'] = $request->query('lat');
                    if (empty($property['longitude']))
                        $property['longitude'] = $request->query('lng');

                    return view('external-property-detail', compact('property'));
                } else {
                    \Illuminate\Support\Facades\Log::warning("External Details: Property not found for {$address}. Available results count: " . (isset($data['data']['available_results']) ? count($data['data']['available_results']) : 0));
                    // Return a "not found" view or redirect with error, don't just fail silently
                    return redirect()->back()->with('error', 'Could not find details for the selected property.');
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('External Property Details Error: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('error', 'Could not fetch external property details');
    }

    public function soldPropertiesSearch(Request $request)
    {
        $location = $request->input('location');
        $radius = $request->input('radius', 0);
        // If "Exactly this location" (0) is selected, we use 0.25 miles as a safe bet for UK postcode centers
        if ($radius == 0)
            $radius = 0.25;

        $results = [];
        $searchPerformed = false;
        $error = null;

        if ($request->filled('location')) {
            $searchPerformed = true;
            $locationInput = $request->input('location');
            $postcode = null;

            // Strict UK Postcode Regex
            $pcRegex = '/([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?))))\s?[0-9][A-Za-z]{2})/i';

            if (preg_match($pcRegex, $locationInput, $matches)) {
                $postcode = strtoupper(str_replace(' ', '', $matches[0]));
            } else {
                // FALLBACK: Only use Google if no postcode is found in the string
                $coord = $this->geocodeAddress($locationInput);
                if ($coord) {
                    $apiKey = config('services.google.maps_api_key');
                    if ($apiKey) {
                        $geoUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $coord['lat'] . "," . $coord['lng'] . "&key=" . $apiKey;
                        try {
                            $geoResp = \Illuminate\Support\Facades\Http::get($geoUrl);
                            if ($geoResp->successful()) {
                                $geoData = $geoResp->json();
                                foreach ($geoData['results'][0]['address_components'] ?? [] as $comp) {
                                    if (in_array('postal_code', $comp['types'])) {
                                        $postcode = strtoupper(str_replace(' ', '', $comp['long_name']));
                                        break;
                                    }
                                }
                            }
                        } catch (\Exception $e) {
                            Log::error('Reverse Geocoding Error: ' . $e->getMessage());
                        }
                    }
                }
            }

            if ($postcode) {
                // If the user typed a specific address (more than just a postcode), 
                // we force a slightly larger radius to ensure we don't miss the exact house
                if (strlen($locationInput) > strlen($postcode) + 5) {
                    $searchRadius = max($radius, 0.5);
                } else {
                    $searchRadius = $radius;
                }

                $postcodeFormatted = (strlen($postcode) > 4) ? substr($postcode, 0, -3) . ' ' . substr($postcode, -3) : $postcode;
                $apiKey = config('services.patma.api_token');

                // PaTMa list-property API call
                $url = "https://app.patma.co.uk/api/prospector/v1/list-property/?postcode=" . urlencode($postcodeFormatted) . "&radius=" . $searchRadius . "&require_sold_price=true&include_sold_history=true&include_listing_data=true&limit=100&token=" . $apiKey;

                try {
                    $response = \Illuminate\Support\Facades\Http::timeout(90)->get($url);
                    $data = $response->json();

                    if ($response->successful() && isset($data['data']['available_results'])) {
                        foreach ($data['data']['available_results'] as $property) {
                            if (!empty($property['sold_history'])) {
                                $internalListing = \App\Models\Listing::where('address', 'LIKE', '%' . ($property['address'] ?? '') . '%')
                                    ->orWhere('property_title', 'LIKE', '%' . ($property['address'] ?? '') . '%')
                                    ->first();

                                $internalUrl = $internalListing ? route('listing.show', $internalListing->slug ?? $internalListing->id) : null;

                                foreach ($property['sold_history'] as $sale) {
                                    $results[] = [
                                        'date' => $sale['date'],
                                        'price' => $sale['amount'],
                                        'type' => $property['property_type'] ?? 'Residential',
                                        'address' => $property['address'] ?? $property['label'] ?? 'N/A',
                                        'postcode' => $property['postcode'] ?? $postcodeFormatted,
                                        'search_postcode' => $postcodeFormatted,
                                        'latitude' => $property['latitude'] ?? null,
                                        'longitude' => $property['longitude'] ?? null,
                                        'url' => $internalUrl ?? $property['url'] ?? '#',
                                        'is_internal' => (bool) $internalListing,
                                        'site_images' => $property['site_images'] ?? [],
                                        'images' => $property['site_images'] ?? [],
                                        'bedrooms' => $internalListing ? ($internalListing->bedrooms ?? 'N/A') : ($property['bedrooms'] ?? 'N/A'),
                                        'bathrooms' => $internalListing ? ($internalListing->bathrooms ?? 'N/A') : ($property['bathrooms'] ?? ($property['baths'] ?? 'N/A')),
                                        'floor_area' => isset($property['floor_area_sqft']) ? number_format($property['floor_area_sqft']) . ' sq ft' : 'N/A',
                                        'tenure' => $property['tenure'] ?? 'N/A'
                                    ];
                                }
                            }
                        }

                        if (!empty($results)) {
                            // 1. Get numbers from the address part only (exclude postcode)
                            $cleanPostcode = str_replace(' ', '', $postcodeFormatted);
                            $addressOnlySearch = trim(str_ireplace([$postcodeFormatted, $cleanPostcode, $postcode], '', $locationInput));
                            preg_match_all('/\d+/', $addressOnlySearch, $targetNumberMatch);
                            $targetNumbers = $targetNumberMatch[0] ?? [];

                            $searchQueryClean = strtolower(preg_replace('/[^a-z0-9 ]/', ' ', $addressOnlySearch));
                            $searchWords = array_filter(explode(' ', $searchQueryClean));

                            usort($results, function ($a, $b) use ($searchWords, $targetNumbers, $searchQueryClean) {
                                $scoreA = 0;
                                $scoreB = 0;
                                $addrA = strtolower($a['address']);
                                $addrB = strtolower($b['address']);

                                // Rule 1: Exact Number Match (Priority #1)
                                foreach ($targetNumbers as $num) {
                                    if (preg_match('/\b' . $num . '\b/', $addrA))
                                        $scoreA += 5000;
                                    if (preg_match('/\b' . $num . '\b/', $addrB))
                                        $scoreB += 5000;
                                }

                                // Rule 2: Substring Match
                                if ($searchQueryClean && strpos($addrA, $searchQueryClean) !== false)
                                    $scoreA += 500;
                                if ($searchQueryClean && strpos($addrB, $searchQueryClean) !== false)
                                    $scoreB += 500;

                                // Rule 3: Keyword matches
                                foreach ($searchWords as $word) {
                                    if (strlen($word) < 3)
                                        continue;
                                    if (strpos($addrA, $word) !== false)
                                        $scoreA += 50;
                                    if (strpos($addrB, $word) !== false)
                                        $scoreB += 50;
                                }

                                return ($scoreA !== $scoreB) ? ($scoreB <=> $scoreA) : strcmp($b['date'], $a['date']);
                            });
                        }
                    } else {
                        Log::warning('PaTMa API Error or No Results: ' . json_encode($data));
                    }
                } catch (\Exception $e) {
                    Log::error('Sold Property Search Exception: ' . $e->getMessage());
                    $error = 'Search timed out. We showed what we found, please refresh if images or maps are missing.';
                }
            } else {
                $error = 'Please include a UK Postcode (e.g. E14 9GR) for an accurate search.';
            }
        }

        return view('sold-properties-search', compact('results', 'searchPerformed', 'location', 'radius', 'error'));
    }
}
