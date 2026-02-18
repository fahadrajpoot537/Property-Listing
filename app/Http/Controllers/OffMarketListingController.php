<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Models\ContactSubmission;
use App\Mail\OffMarketInquiry;

class OffMarketListingController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\OffMarketListing::with(['propertyType', 'unitType', 'features'])
            ->where('status', 'approved');

        // Apply filters
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
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

            // Use COALESCE to handle NULL distances (when coordinates are identical)
            $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, $radius]);
        } elseif ($request->filled('location') && $request->filled('radius') && $request->radius != '') {
            // If location name and radius are provided but no coordinates, try to geocode the location
            $location = $request->location;
            $radius = $request->radius;

            // Attempt to geocode the location to get coordinates for radius search
            $coordinates = $this->geocodeAddress($location);

            if ($coordinates) {
                $lat = $coordinates['lat'];
                $lng = $coordinates['lng'];

                // Use COALESCE to handle NULL distances (when coordinates are identical)
                $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, (float) $radius]);
            } else {
                // Fallback to basic location search if geocoding fails
                $query->where('address', 'like', '%' . $location . '%');
            }
        } elseif ($request->filled('location') && $request->location != '') {
            $query->where('address', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('property_type_id') && $request->property_type_id != '') {
            $query->where('property_type_id', $request->property_type_id);
        } elseif ($request->filled('property_type') && $request->property_type != '') {
            $query->where('property_type_id', $request->property_type);
        }

        if ($request->filled('unit_type_id')) {
            $query->where('unit_type_id', $request->unit_type_id);
        } elseif ($request->filled('unit_type')) {
            $query->where('unit_type_id', $request->unit_type);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        } elseif ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        } elseif ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('min_size') && $request->filled('max_size')) {
            $query->whereBetween('area_size', [$request->min_size, $request->max_size]);
        } elseif ($request->filled('min_size')) {
            $query->where('area_size', '>=', $request->min_size);
        } elseif ($request->filled('max_size')) {
            $query->where('area_size', '<=', $request->max_size);
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

        if ($request->filled('ownership_status_id')) {
            $query->where('ownership_status_id', $request->ownership_status_id);
        }

        if ($request->filled('rent_frequency_id')) {
            $query->where('rent_frequency_id', $request->rent_frequency_id);
        }

        if ($request->filled('cheque_id')) {
            $query->where('cheque_id', $request->cheque_id);
        }

        // Discounted Properties Filter
        if ($request->filled('discounted') && $request->discounted == '1') {
            $query->whereNotNull('old_price')
                ->where('old_price', '>', 0)
                ->whereRaw('old_price != price');
        }

        if ($request->filled('features')) {
            $featureIds = explode(',', $request->features);
            $query->whereHas('features', function ($q) use ($featureIds) {
                $q->whereIn('features.id', $featureIds);
            });
        }

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
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $listings = $query->paginate(12)->withQueryString();

        // Get filter data
        $propertyTypes = \App\Models\PropertyType::all();
        $features = \App\Models\Feature::all();
        $features_all = $features; // Copy for property-halfmap-grid compatibility

        // Get latest listings for sidebar
        $latest_listings = \App\Models\OffMarketListing::where('status', 'approved')
            ->with(['user', 'features'])
            ->latest()
            ->take(5)
            ->get();

        // Check if there are search parameters to determine which view to return
        $hasSearchParams = $request->filled('location') ||
            $request->filled('purpose') ||
            $request->filled('property_type_id') ||
            $request->filled('unit_type_id') ||
            $request->filled('min_price') ||
            $request->filled('max_price') ||
            $request->filled('min_size') ||
            $request->filled('max_size') ||
            $request->filled('min_bedrooms') ||
            $request->filled('min_bathrooms') ||
            $request->filled('ownership_status_id') ||
            $request->filled('rent_frequency_id') ||
            $request->filled('cheque_id') ||
            $request->filled('features') ||
            $request->filled('radius');

        $user_favorite_off_market_ids = [];
        if (auth()->check()) {
            $user_favorite_off_market_ids = \App\Models\Favorite::where('user_id', auth()->id())
                ->pluck('off_market_listing_id')
                ->filter()
                ->toArray();
        }

        if ($hasSearchParams) {
            // Return the property-halfmap-grid view when search parameters are present
            return view('property-halfmap-grid', compact('listings', 'propertyTypes', 'features_all', 'latest_listings', 'user_favorite_off_market_ids'));
        }

        // Return the default off-market-listings view when no search parameters
        return view('off-market-listings', compact('listings', 'propertyTypes', 'features', 'latest_listings', 'user_favorite_off_market_ids'))->with('offMarketListings', $listings);
    }

    public function show($id)
    {
        $listing = \App\Models\OffMarketListing::with([
            'user',
            'features',
            'propertyType',
            'unitType',
            'ownershipStatus',
            'rentFrequency',
            'cheque'
        ])->where('status', 'approved')
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })->firstOrFail();

        // Get similar properties
        $similarProperties = \App\Models\OffMarketListing::with(['propertyType', 'unitType'])
            ->where('property_type_id', $listing->property_type_id)
            ->where('id', '!=', $listing->id)
            ->where('status', 'approved')
            ->take(3)
            ->get();

        $user_favorite_off_market_ids = [];
        if (auth()->check()) {
            $user_favorite_off_market_ids = \App\Models\Favorite::where('user_id', auth()->id())
                ->pluck('off_market_listing_id')
                ->filter()
                ->toArray();
        }

        return view('off-market-property-detail', compact('listing', 'similarProperties', 'user_favorite_off_market_ids'));
    }

    public function getSoldPrices($id)
    {
        $listing = \App\Models\OffMarketListing::where('status', 'approved')
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })->firstOrFail();
        $postcode = $listing->postcode;

        if (!$postcode) {
            return response()->json(['error' => 'No valid postcode found for this property.'], 404);
        }

        $apiKey = '3f5f396290a1e9c3be70b679210c188d3562a0d9';
        // Using PaTMa API as per user's latest information
        // We use radius 0.5 to catch properties in the immediate area
        $apiUrl = "https://app.patma.co.uk/api/prospector/v1/list-property/?postcode=" . urlencode($postcode) . "&radius=0.5&require_sold_price=true&include_sold_history=true&include_listing_data=true&token=" . $apiKey;

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
                    foreach ($data['data']['available_results'] as $property) {
                        if (isset($property['sold_history']) && is_array($property['sold_history'])) {
                            // Check if this property exists in our database
                            $internalListing = \App\Models\Listing::where(function ($q) use ($property) {
                                $addr = $property['address'] ?? $property['label'] ?? '';
                                $pc = $property['postcode'] ?? '';
                                if ($addr) {
                                    $q->where('address', 'LIKE', '%' . $addr . '%')
                                        ->orWhere('property_title', 'LIKE', '%' . $addr . '%');
                                }
                                if ($pc) {
                                    $q->orWhere('address', 'LIKE', '%' . $pc . '%');
                                }
                            })->first();

                            $internalUrl = $internalListing ? route('listing.show', $internalListing->slug ?? $internalListing->id) : null;

                            foreach ($property['sold_history'] as $sale) {
                                $formattedPrices[] = [
                                    'date' => $sale['date'],
                                    'price' => $sale['amount'],
                                    'type' => $property['property_type'] ?? 'Residential',
                                    'name' => $property['address'] ?? $property['label'] ?? 'N/A',
                                    'location' => $property['postcode'] ?? $listing->postcode ?? 'N/A',
                                    'search_postcode' => $listing->postcode,
                                    'url' => $internalUrl ?? $property['url'] ?? '#',
                                    'is_internal' => (bool) $internalListing,
                                    'description' => $property['description_text'] ?? 'No additional description available.',
                                    'images' => $property['site_images'] ?? [],
                                    'tenure' => $property['tenure'] ?? 'N/A',
                                    'bedrooms' => $internalListing->bedrooms ?? $property['bedrooms'] ?? 'N/A',
                                    'bathrooms' => $internalListing->bathrooms ?? 'N/A',
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

    public function sendInquiry(Request $request, $id)
    {
        $listing = \App\Models\OffMarketListing::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $inquiryData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => 'Off-Market Inquiry: ' . $listing->property_title,
            'message' => $request->message,
        ];

        // Store in ContactSubmission
        ContactSubmission::create($inquiryData);

        // Send email to property owner
        if ($listing->user && $listing->user->email) {
            Mail::to($listing->user->email)->send(new OffMarketInquiry($inquiryData, $listing));
        }

        return back()->with('success', 'Your request for the prospectus has been sent. Our team will verify your credentials and contact you.');
    }

    private function geocodeAddress($address)
    {
        $apiKey = config('services.google.maps_api_key');

        if (!$apiKey) {
            return null;
        }

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

        $response = json_decode(file_get_contents($url), true);

        if ($response['status'] == 'OK' && isset($response['results'][0]['geometry']['location'])) {
            $location = $response['results'][0]['geometry']['location'];
            return [
                'lat' => $location['lat'],
                'lng' => $location['lng']
            ];
        }

        return null;
    }
}