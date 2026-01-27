<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Test listings with coordinates
    echo "Listings with coordinates:\n";
    $listings = \App\Models\Listing::where('status', 'approved')->get();
    foreach ($listings as $listing) {
        echo "ID: " . $listing->id . ", Title: " . $listing->property_title . 
             ", Lat: " . $listing->latitude . ", Lng: " . $listing->longitude . "\n";
    }
    
    // Test the bounds query with the coordinates from the error
    echo "\nTesting bounds query...\n";
    $swLat = 51.37643474580499;
    $swLng = -0.7313614013671854;
    $neLat = 51.63643474580499; // Approximate northeast based on the southwest
    $neLng = 0.4863614013671854; // Approximate northeast based on the southwest
    
    echo "Bounds: SW(" . $swLat . ", " . $swLng . ") NE(" . $neLat . ", " . $neLng . ")\n";
    
    $query = \App\Models\Listing::query()->where('status', 'approved');
    $query->whereBetween('latitude', [$swLat, $neLat])
          ->whereBetween('longitude', [$swLng, $neLng]);
    
    $result = $query->get();
    echo "Results in bounds: " . $result->count() . "\n";
    
    foreach ($result as $listing) {
        echo "- " . $listing->property_title . " (" . $listing->latitude . ", " . $listing->longitude . ")\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}