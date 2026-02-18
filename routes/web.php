<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/off-market-listings', [
    \App\Http\Controllers\OffMarketListingController::class,
    'index'
])->name('off-market-listings.index');
Route::get('/off-market-property/{id}', [
    \App\Http\Controllers\OffMarketListingController::class,
    'show'
])->name('off-market-listing.show');
Route::get('/off-market-property/{id}/sold-prices', [App\Http\Controllers\OffMarketListingController::class, 'getSoldPrices'])->name('off-market-listing.sold-prices');
Route::post('/off-market-property/{id}/inquiry', [
    \App\Http\Controllers\OffMarketListingController::class,
    'sendInquiry'
])->name('off-market-listing.inquiry');
Route::get('/off-market-property/{id}/brochure', [
    \App\Http\Controllers\BrochureController::class,
    'downloadOffMarket'
])->name('off-market-listing.brochure');

Route::get('/property-halfmap-grid', [
    \App\Http\Controllers\ListingController::class,
    'index'
])->name('listings.index');
Route::get('/property-map', [\App\Http\Controllers\ListingController::class, 'map'])->name('listings.map');
Route::get('/property/{id}', [App\Http\Controllers\ListingController::class, 'show'])->name('listing.show');
Route::get('/property/{id}/sold-prices', [App\Http\Controllers\ListingController::class, 'getSoldPrices'])->name('listing.sold-prices');
Route::post('/property/{id}/inquiry', [App\Http\Controllers\PropertyInquiryController::class, 'store'])->name('listing.inquiry');
Route::get('/property/{id}/brochure', [App\Http\Controllers\BrochureController::class, 'download'])->name('listing.brochure');
Route::get('/sold-properties', [\App\Http\Controllers\ListingController::class, 'soldPropertiesSearch'])->name('sold-properties.search');
Route::get('/property-external-details', [App\Http\Controllers\ListingController::class, 'showExternalDetails'])->name('property.external-details');

// Agents
Route::get('/agents', [App\Http\Controllers\AgentController::class, 'index'])->name('agents.index');

Route::get('/api/home/featured-listings', [
    App\Http\Controllers\ListingController::class,
    'getFeaturedListings'
])->name('home.featured-listings');
Route::get('/api/home/property-type', [
    App\Http\Controllers\ListingController::class,
    'getPropertyTypeListings'
])->name('home.property-type');
Route::get('/map', [\App\Http\Controllers\MapController::class, 'index'])->name('map');
Route::post('/map/api/properties', [
    \App\Http\Controllers\MapController::class,
    'getProperties'
])->name('map.getProperties');
Route::get('/map/api/properties', [
    \App\Http\Controllers\MapController::class,
    'getProperties'
])->name('map.getProperties.get');

// New routes for Contact, Blog, and Services
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/blogs', [BlogController::class, 'list'])->name('blog.list');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/services', [ServiceController::class, 'list'])->name('service.list');

// Legal Pages
Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy');
Route::view('/terms-of-service', 'pages.terms-of-service')->name('terms');
Route::view('/cookie-policy', 'pages.cookie-policy')->name('cookies');
Route::view('/gdpr-compliance', 'pages.gdpr-compliance')->name('gdpr');
Route::view('/help-center', 'pages.help')->name('help');

Route::get('/referral', [
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'setReferral'
])->name('set.referral');


Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/document', [ProfileController::class, 'storeDocument'])->name('profile.document.store');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware(['permission:access dashboard'])->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin Profile Management
        Route::get('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('profile.update');
        Route::post('users-status/{id}', [
            \App\Http\Controllers\Admin\AdminUserController::class,
            'toggleStatus'
        ])->name('users.update-status');
        Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\AdminRoleController::class);
        Route::resource('property-types', \App\Http\Controllers\Admin\AdminPropertyTypeController::class);
        Route::resource('unit-types', \App\Http\Controllers\Admin\AdminUnitTypeController::class);
        Route::resource('features', \App\Http\Controllers\Admin\AdminFeatureController::class);
        Route::resource('ownership-statuses', \App\Http\Controllers\Admin\AdminOwnershipStatusController::class);
        Route::resource('rent-frequencies', \App\Http\Controllers\Admin\AdminRentFrequencyController::class);
        Route::resource('cheques', \App\Http\Controllers\Admin\AdminChequeController::class);
        Route::resource('property-locations', \App\Http\Controllers\Admin\AdminPropertyLocationController::class);

        Route::get('listings/drafts', [\App\Http\Controllers\Admin\AdminListingController::class, 'drafts'])->name('listings.drafts');
        Route::get('listings/export', [\App\Http\Controllers\Admin\AdminListingController::class, 'export'])->name('listings.export');
        Route::post('listings/bulk-action', [\App\Http\Controllers\Admin\AdminListingController::class, 'bulkAction'])->name('listings.bulk-action');
        Route::resource('listings', \App\Http\Controllers\Admin\AdminListingController::class);
        Route::post('listings/{listing}/status', [\App\Http\Controllers\Admin\AdminListingController::class, 'updateStatus'])->name('listings.update-status');

        Route::get('off-market-listings/drafts', [\App\Http\Controllers\Admin\AdminOffMarketListingController::class, 'drafts'])->name('off-market-listings.drafts');
        Route::get('off-market-listings/export', [\App\Http\Controllers\Admin\AdminOffMarketListingController::class, 'export'])->name('off-market-listings.export');
        Route::post('off-market-listings/bulk-action', [\App\Http\Controllers\Admin\AdminOffMarketListingController::class, 'bulkAction'])->name('off-market-listings.bulk-action');
        Route::resource('off-market-listings', \App\Http\Controllers\Admin\AdminOffMarketListingController::class);
        Route::post('off-market-listings/{listing}/status', [\App\Http\Controllers\Admin\AdminOffMarketListingController::class, 'updateStatus'])->name('off-market-listings.update-status');

        Route::get('affiliates/{id}/visitors', [
            \App\Http\Controllers\Admin\AdminAffiliateController::class,
            'visitors'
        ])->name('affiliates.visitors');
        Route::post('affiliates/settings', [
            \App\Http\Controllers\Admin\AdminAffiliateController::class,
            'updateSettings'
        ])->name('affiliates.update-settings');
        Route::resource('affiliates', \App\Http\Controllers\Admin\AdminAffiliateController::class);
        Route::resource('mortgage-settings', \App\Http\Controllers\Admin\MortgageSettingController::class)->only([
            'index',
            'update'
        ]);

        // Blog, Service, and Contact routes
        Route::resource('blogs', BlogController::class);
        Route::resource('services', ServiceController::class);
        Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/contact/{submission}', [ContactController::class, 'show'])->name('contact.show');
        Route::delete('/contact/{submission}', [ContactController::class, 'destroy'])->name('contact.destroy');

        Route::resource('email-templates', \App\Http\Controllers\Admin\AdminEmailTemplateController::class);
    });
});

Route::get('/partner', [\App\Http\Controllers\AffiliateController::class, 'landing'])->name('affiliate.welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/affiliate/dashboard', [
        \App\Http\Controllers\AffiliateController::class,
        'dashboard'
    ])->name('affiliate.dashboard');

    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::get('/affiliate/register', [
    \App\Http\Controllers\AffiliateController::class,
    'showRegisterForm'
])->name('affiliate.register.view');
Route::post('/affiliate/register', [
    \App\Http\Controllers\AffiliateController::class,
    'register'
])->name('affiliate.register');

require __DIR__ . '/auth.php';
require __DIR__ . '/debug.php';
