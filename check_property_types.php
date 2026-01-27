<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PropertyType;

echo "Checking Property Types in Database...\n";

try {
    $count = PropertyType::count();
    echo "Total Property Types: " . $count . "\n";
    
    if ($count > 0) {
        echo "Property Types:\n";
        $types = PropertyType::all();
        foreach ($types as $type) {
            echo "ID: " . $type->id . ", Name: " . $type->name . "\n";
        }
    } else {
        echo "No property types found in the database.\n";
        echo "You may need to seed the database with property types.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>