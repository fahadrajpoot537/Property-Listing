<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Feature;
use App\Models\Blog;
use App\Models\PropertyLocation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $features = Feature::all();

        // Fetch Buy and Rent listings separately for the home tabs
        $buyListings = Listing::with('features', 'user', 'unitType')
            ->where('status', 'approved')
            ->where('purpose', 'Buy')
            ->latest()
            ->take(6)
            ->get();

        $rentListings = Listing::with('features', 'user', 'unitType')
            ->where('status', 'approved')
            ->where('purpose', 'Rent')
            ->latest()
            ->take(6)
            ->get();

        // Fetch property locations with approved listing count
        $propertyLocations = PropertyLocation::all()->map(function ($location) {
            $count = 0;
            if ($location->latitude && $location->longitude) {
                $lat = $location->latitude;
                $lng = $location->longitude;
                $radius = 50;

                $count = Listing::where('status', 'approved')
                    ->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) < ?", [$lat, $lng, $lat, $radius])
                    ->count();
            } else {
                $count = Listing::where('status', 'approved')
                    ->where('address', 'like', '%' . $location->address . '%')
                    ->count();
            }
            $location->listing_count = $count;
            return $location;
        });

        $featuredSellListings = Listing::with('features', 'user', 'unitType')
            ->whereIn('status', ['approved', 'pending'])
            ->where('purpose', 'Buy')
            ->whereNotNull('old_price')
            ->where('old_price', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $blogs = Blog::latest()
            ->take(6)
            ->get();

        $user_favorite_ids = [];
        if (auth()->check()) {
            $user_favorite_ids = \App\Models\Favorite::where('user_id', auth()->id())
                ->pluck('listing_id')
                ->filter()
                ->toArray();
        }

        $affiliateRate = \App\Models\Setting::get('affiliate_rate', 5);
        $affiliateBatchSize = \App\Models\Setting::get('affiliate_batch_size', 1000);

        $trustpilotReview = \App\Models\TrustpilotReview::where('is_active', true)->first();

        return view('home', [
            'features' => $features,
            'buyListings' => $buyListings,
            'rentListings' => $rentListings,
            'propertyLocations' => $propertyLocations,
            'featuredSellListings' => $featuredSellListings,
            'user_favorite_ids' => $user_favorite_ids,
            'blogs' => $blogs,
            'affiliate_rate' => $affiliateRate,
            'affiliate_batch_size' => $affiliateBatchSize,
            'trustpilotReview' => $trustpilotReview,
        ]);
    }
}
