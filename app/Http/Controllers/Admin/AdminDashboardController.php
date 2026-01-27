<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'usersCount' => \App\Models\User::count(),
            'listingsCount' => \App\Models\Listing::count(),
            'offMarketListingsCount' => \App\Models\OffMarketListing::count(),
            'propertyTypesCount' => \App\Models\PropertyType::count(),
            'unitTypesCount' => \App\Models\UnitType::count(),
            'featuresCount' => \App\Models\Feature::count(),
            'totalVisitors' => \App\Models\VisitorAnalytic::count(),
            'uniqueVisitors' => \App\Models\VisitorAnalytic::distinct('ip_address')->count('ip_address'),
            'recentListings' => \App\Models\Listing::latest()->take(5)->get(),
            'recentUsers' => \App\Models\User::latest()->take(5)->get(),
        ];
        return view('admin.dashboard', compact('data'));
    }
}
