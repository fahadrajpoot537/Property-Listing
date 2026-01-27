<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Test database connection
    echo "Testing database connection...\n";
    $count = \App\Models\Listing::count();
    echo "Total listings: " . $count . "\n";
    
    // Test approved listings
    $approvedCount = \App\Models\Listing::where('status', 'approved')->count();
    echo "Approved listings: " . $approvedCount . "\n";
    
    // Test first few listings
    $listings = \App\Models\Listing::take(5)->get();
    echo "Sample listings:\n";
    foreach ($listings as $listing) {
        echo "- ID: " . $listing->id . ", Title: " . $listing->property_title . ", Status: " . $listing->status . "\n";
    }
    
    // Test the query from the controller
    echo "\nTesting controller query...\n";
    $query = \App\Models\Listing::query()->where('status', 'approved');
    $resultCount = $query->count();
    echo "Query result count: " . $resultCount . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}