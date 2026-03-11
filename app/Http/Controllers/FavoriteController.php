<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Listing;
use App\Models\OffMarketListing;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', auth()->id())
            ->with(['listing.propertyType', 'offMarketListing.propertyType'])
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $requestId = $request->listing_id ?: $request->off_market_listing_id;
        $type = $request->listing_id ? 'listing_id' : 'off_market_listing_id';

        if (!$requestId) {
            return response()->json(['status' => 'error', 'message' => 'Invalid ID'], 400);
        }

        $favorite = Favorite::where('user_id', auth()->id())
            ->where($type, $requestId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from favorites']);
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                $type => $requestId
            ]);
            return response()->json(['status' => 'added', 'message' => 'Added to favorites']);
        }
    }
}
