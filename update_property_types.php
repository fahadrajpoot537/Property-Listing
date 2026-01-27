<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PropertyType;

echo "Updating Property Types...\n";

try {
    // Check current property types
    $types = PropertyType::all();
    echo "Current Property Types:\n";
    foreach ($types as $type) {
        echo "ID: " . $type->id . ", Name: '" . $type->name . "'\n";
    }
    
    // Update the property types with meaningful titles
    $updates = [
        1 => 'House',
        2 => 'Apartment',
        3 => 'Commercial'
    ];
    
    foreach ($updates as $id => $title) {
        $type = PropertyType::find($id);
        if ($type) {
            $type->title = $title;
            $type->save();
            echo "Updated ID $id to '$title'\n";
        } else {
            echo "Property type with ID $id not found\n";
        }
    }
    
    // Verify the updates
    echo "\nUpdated Property Types:\n";
    $updatedTypes = PropertyType::all();
    foreach ($updatedTypes as $type) {
        echo "ID: " . $type->id . ", Name: '" . $type->name . "'\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>