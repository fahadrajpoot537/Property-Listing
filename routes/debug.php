<?php

use Illuminate\Support\Facades\Route;
use App\Models\OffMarketListing;
use Illuminate\Http\Request;

Route::get('/debug/off-market-query', function (Request $request) {
    $lat = 50.729369;
    $lng = -3.5435122;
    $radius = 0.5;

    $query = OffMarketListing::where('status', 'approved');

    // Check basic finding
    $basic = OffMarketListing::find(2);
    $statusCheck = $basic ? $basic->status : 'Not Found';

    // Apply Haversine
    $queryRaw = clone $query;
    $queryRaw->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) <= ?", [$lat, $lng, $lat, $radius]);

    $results = $queryRaw->get();

    // Calculate distance manually for ID 2
    $distance = null;
    if ($basic) {
        $theta = $lng - $basic->longitude;
        $dist = sin(deg2rad($lat)) * sin(deg2rad($basic->latitude)) + cos(deg2rad($lat)) * cos(deg2rad($basic->latitude)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $distance = $miles;
    }

    return [
        'listing_2_exists' => $basic ? 'Yes' : 'No',
        'listing_2_status' => $statusCheck,
        'listing_2_lat' => $basic ? $basic->latitude : null,
        'listing_2_lng' => $basic ? $basic->longitude : null,
        'search_lat' => $lat,
        'search_lng' => $lng,
        'search_radius' => $radius,
        'manual_distance_calc' => $distance,
        'query_count' => $results->count(),
        'query_results' => $results->pluck('id', 'property_title'),
        'sql' => $queryRaw->toSql(),
        'bindings' => $queryRaw->getBindings()
    ];
});
