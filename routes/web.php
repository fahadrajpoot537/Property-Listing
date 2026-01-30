<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $features = \App\Models\Feature::all();
    // Get purpose from query parameter or default to 'Buy' (For Sale) since the 'For Sale' tab is active by default
    $purpose = request('purpose', 'Buy');
    $listings = \App\Models\Listing::with('features', 'user')->where('status', 'approved')->where('purpose', $purpose)->latest()->take(6)->get();

    // Fetch property locations with approved listing count
    $propertyLocations = \App\Models\PropertyLocation::all()->map(function ($location) {
        $count = 0;
        if ($location->latitude && $location->longitude) {
            // Use 10 mile radius as "near" default
            $lat = $location->latitude;
            $lng = $location->longitude;
            $radius = 10;

            $count = \App\Models\Listing::where('status', 'approved')
                ->whereRaw("( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) < ?", [$lat, $lng, $lat, $radius])
                ->count();
        } else {
            // Fallback to strict address match if lat/lng missing? Or just 0.
            // Given user request "us lat or lang me jo jo SELECT * FROM `listings` ... aa rahi hen", 
            // relying on lat/lng is main requirement.
            // If name matches address?
            $count = \App\Models\Listing::where('status', 'approved')
                ->where('address', 'like', '%' . $location->address . '%')
                ->count();
        }
        $location->listing_count = $count;
        return $location;
    });

    $featuredSellListings = \App\Models\Listing::with('features', 'user')
        ->whereIn('status', ['approved', 'pending'])
        ->where('purpose', 'Buy')
        ->whereNotNull('old_price')
        ->where('old_price', '>', 0)
        ->latest()
        ->take(6)
        ->get();

    return view('home', compact('features', 'listings', 'propertyLocations', 'featuredSellListings'));
})->name('home');

Route::get('/off-market-listings', [\App\Http\Controllers\OffMarketListingController::class, 'index'])->name('off-market-listings.index');
Route::get('/off-market-property/{id}', [\App\Http\Controllers\OffMarketListingController::class, 'show'])->name('off-market-listing.show');

Route::get('/property-halfmap-grid', [\App\Http\Controllers\ListingController::class, 'index'])->name('listings.index');
Route::get('/property-map', [\App\Http\Controllers\ListingController::class, 'map'])->name('listings.map');
Route::get('/property/{id}', [App\Http\Controllers\ListingController::class, 'show'])->name('listing.show');

Route::get('/api/home/featured-listings', [App\Http\Controllers\ListingController::class, 'getFeaturedListings'])->name('home.featured-listings');
Route::get('/api/home/property-type', [App\Http\Controllers\ListingController::class, 'getPropertyTypeListings'])->name('home.property-type');
Route::get('/map', [\App\Http\Controllers\MapController::class, 'index'])->name('map');
Route::post('/map/api/properties', [\App\Http\Controllers\MapController::class, 'getProperties'])->name('map.getProperties');
Route::get('/map/api/properties', [\App\Http\Controllers\MapController::class, 'getProperties'])->name('map.getProperties.get');

// New routes for Contact, Blog, and Services
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/blogs', [BlogController::class, 'list'])->name('blog.list');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/services', [ServiceController::class, 'list'])->name('service.list');

Route::get('/referral', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'setReferral'])->name('set.referral');


Route::get('/dashboard', function () {
    return view('admin/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware(['permission:access dashboard'])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\AdminRoleController::class);
        Route::resource('property-types', \App\Http\Controllers\Admin\AdminPropertyTypeController::class);
        Route::resource('unit-types', \App\Http\Controllers\Admin\AdminUnitTypeController::class);
        Route::resource('features', \App\Http\Controllers\Admin\AdminFeatureController::class);
        Route::resource('ownership-statuses', \App\Http\Controllers\Admin\AdminOwnershipStatusController::class);
        Route::resource('rent-frequencies', \App\Http\Controllers\Admin\AdminRentFrequencyController::class);
        Route::resource('cheques', \App\Http\Controllers\Admin\AdminChequeController::class);
        Route::resource('property-locations', \App\Http\Controllers\Admin\AdminPropertyLocationController::class);
        Route::resource('listings', \App\Http\Controllers\Admin\AdminListingController::class);
        Route::post('listings/bulk-action', [\App\Http\Controllers\Admin\AdminListingController::class, 'bulkAction'])->name('listings.bulk-action');
        Route::post('listings/{listing}/status', [\App\Http\Controllers\Admin\AdminListingController::class, 'updateStatus'])->name('listings.update-status');
        Route::resource('off-market-listings', \App\Http\Controllers\Admin\AdminOffMarketListingController::class);
        Route::post('off-market-listings/bulk-action', [\App\Http\Controllers\Admin\AdminOffMarketListingController::class, 'bulkAction'])->name('off-market-listings.bulk-action');
        Route::post('off-market-listings/{listing}/status', [\App\Http\Controllers\Admin\AdminOffMarketListingController::class, 'updateStatus'])->name('off-market-listings.update-status');
        Route::resource('affiliates', \App\Http\Controllers\Admin\AdminAffiliateController::class);
        Route::resource('mortgage-settings', \App\Http\Controllers\Admin\MortgageSettingController::class)->only(['index', 'update']);

        // Blog, Service, and Contact routes
        Route::resource('blogs', BlogController::class);
        Route::resource('services', ServiceController::class);
        Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/contact/{submission}', [ContactController::class, 'show'])->name('contact.show');
        Route::delete('/contact/{submission}', [ContactController::class, 'destroy'])->name('contact.destroy');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/affiliate/dashboard', [\App\Http\Controllers\AffiliateController::class, 'dashboard'])->name('affiliate.dashboard');
    Route::post('/affiliate/register', [\App\Http\Controllers\AffiliateController::class, 'register'])->name('affiliate.register');
});

require __DIR__ . '/auth.php';
