<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']);
        $isAgency = $user->hasRole('Agency');

        // Base Queries
        $userQuery = \App\Models\User::query();
        $listingQuery = \App\Models\Listing::query();
        $offMarketQuery = \App\Models\OffMarketListing::query();

        if (!$isAdmin) {
            if ($isAgency || ($user->hasRole('agent') && $user->agency_id)) {
                $ownerId = $isAgency ? $user->id : $user->agency_id;
                $teamIds = \App\Models\User::where('agency_id', $ownerId)->pluck('id')->toArray();
                $userIds = array_merge([$ownerId], $teamIds);

                $userQuery->whereIn('id', $userIds);
                $listingQuery->whereIn('user_id', $userIds);
                $offMarketQuery->whereIn('user_id', $userIds);
            } else {
                $userQuery->where('id', $user->id);
                $listingQuery->where('user_id', $user->id);
                $offMarketQuery->where('user_id', $user->id);
            }
        }

        $walkthroughQuery = \App\Models\WalkThroughInquiry::query();
        if (!$isAdmin) {
            if ($isAgency || ($user->hasRole('agent') && $user->agency_id)) {
                $ownerId = $isAgency ? $user->id : $user->agency_id;
                $teamIds = \App\Models\User::where('agency_id', $ownerId)->pluck('id')->toArray();
                $userIds = array_merge([$ownerId], $teamIds);
                $walkthroughQuery->whereIn('user_id', $userIds);
            } else {
                $walkthroughQuery->where('user_id', $user->id);
            }
        }

        $data = [
            'usersCount' => $isAdmin ? $userQuery->count() : 0,
            'listingsCount' => $listingQuery->count(),
            'offMarketListingsCount' => $offMarketQuery->count(),
            'walkthroughCount' => $walkthroughQuery->where('status', 'pending')->count(),
            'propertyTypesCount' => \App\Models\PropertyType::count(),
            'featuresCount' => \App\Models\Feature::count(),
            'totalVisitors' => \App\Models\VisitorAnalytic::count(),
            'uniqueVisitors' => \App\Models\VisitorAnalytic::distinct('ip_address')->count('ip_address'),
            'recentListings' => (clone $listingQuery)->with('propertyType')->latest()->take(5)->get(),
            'recentOffMarketListings' => (clone $offMarketQuery)->with('propertyType')->latest()->take(5)->get(),
            'recentUsers' => $isAdmin ? (clone $userQuery)->latest()->take(5)->get() : collect(),
        ];
        return view('admin.dashboard', compact('data'));
    }
}
