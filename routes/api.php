<?php

use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/map/properties', [MapController::class, 'getProperties']);
Route::post('/map/properties', [MapController::class, 'getProperties']);
Route::get('/listings/{id}', function ($id) {
    $property = \App\Models\Listing::with(['features', 'user'])->find($id);
    
    if (!$property) {
        return response()->json(['error' => 'Property not found'], 404);
    }
    
    // Get property type name
    $propertyType = \App\Models\PropertyType::find($property->property_type_id);
    $property->property_type_name = $propertyType ? $propertyType->name : null;
    
    // Process gallery to ensure it's properly formatted
    $images = is_string($property->gallery) ? json_decode($property->gallery, true) : $property->gallery;
    if ($images && is_array($images)) {
        // Transform each image path to a full URL
        $property->gallery = array_map(function($image) {
            // Check if image path already includes gallery/ prefix
            if (strpos($image, 'gallery/') === 0) {
                return asset('storage/' . $image);
            } else {
                return asset('storage/gallery/' . $image);
            }
        }, $images);
    } else {
        $property->gallery = [];
    }
    
    return response()->json($property);
});

Route::get('/off-market-listings/{id}', function ($id) {
    $property = \App\Models\OffMarketListing::with(['features', 'user'])->find($id);
    
    if (!$property) {
        return response()->json(['error' => 'Property not found'], 404);
    }
    
    // Get property type name
    $propertyType = \App\Models\PropertyType::find($property->property_type_id);
    $property->property_type_name = $propertyType ? $propertyType->name : null;
    
    // Process gallery to ensure it's properly formatted
    $images = is_string($property->gallery) ? json_decode($property->gallery, true) : $property->gallery;
    if ($images && is_array($images)) {
        // Transform each image path to a full URL
        $property->gallery = array_map(function($image) {
            // Check if image path already includes gallery/ prefix
            if (strpos($image, 'gallery/') === 0) {
                return asset('storage/' . $image);
            } else {
                return asset('storage/gallery/' . $image);
            }
        }, $images);
    } else {
        $property->gallery = [];
    }
    
    return response()->json($property);
});