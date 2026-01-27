<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Simulate the request data
    $requestData = [
        'bounds' => [
            'southwest' => ['lat' => 51.37643474580499, 'lng' => -0.7313614013671854],
            'northeast' => ['lat' => 51.63643474580499, 'lng' => 0.4863614013671854]
        ],
        'zoom_level' => 10
    ];
    
    // Create a mock request
    $request = new \Illuminate\Http\Request();
    $request->merge($requestData);
    
    // Test the controller method directly
    $controller = new \App\Http\Controllers\MapController();
    $response = $controller->getProperties($request);
    
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Response content:\n";
    echo $response->getContent() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}