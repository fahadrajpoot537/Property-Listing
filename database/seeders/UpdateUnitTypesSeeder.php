<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitType;
use App\Models\PropertyType;
use Illuminate\Support\Str;

class UpdateUnitTypesSeeder extends Seeder
{
    public function run()
    {
        $resId = PropertyType::where('title', 'Residential')->first()?->id;
        $commId = PropertyType::where('title', 'Commercial')->first()?->id;

        if ($resId) {
            $resUnits = ['Apartment', 'Villa', 'Studio', 'House'];
            foreach ($resUnits as $title) {
                UnitType::updateOrCreate(
                    ['title' => $title, 'property_type_id' => $resId],
                    ['slug' => Str::slug($title)]
                );
            }
        }

        if ($commId) {
            $commUnits = ['Warehouse', 'Office', 'Shop'];
            foreach ($commUnits as $title) {
                UnitType::updateOrCreate(
                    ['title' => $title, 'property_type_id' => $commId],
                    ['slug' => Str::slug($title)]
                );
            }
        }
    }
}
