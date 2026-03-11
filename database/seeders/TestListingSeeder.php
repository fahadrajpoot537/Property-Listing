<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Support\Str;

class TestListingSeeder extends Seeder
{
    public function run()
    {
        // Try getting admin role user, fallback to first user
        $admin = null;
        if (class_exists('App\Models\User')) {
            try {
                $admin = User::role('admin')->first() ?: User::first();
            } catch (\Exception $e) {
                $admin = User::first();
            }
        }

        if (!$admin) {
            $this->command->error('No user found to assign the listing to.');
            return;
        }

        $apartmentType = PropertyType::where('title', 'like', 'Apartment%')->first() ?? PropertyType::first();

        if (!$apartmentType) {
            $this->command->error('No property types found. Please seed property types first.');
            return;
        }

        Listing::updateOrCreate(
            [
                'property_title' => 'Modern 2 Bed Apartment in London',
                'postcode' => 'SW1A 1AA'
            ],
            [
                'user_id' => $admin->id,
                'summary_description' => 'Fresh test listing created for alert engine testing.',
                'description' => 'Fresh test listing created for alert engine testing.',
                'property_reference_number' => 'TEST-' . strtoupper(Str::random(8)),
                'purpose' => 'Buy',
                'price' => 450000,
                'price_qualifier' => 'Asking Price',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area_size' => '850 sqft',
                'property_type_id' => $apartmentType->id,
                'sub_type' => $apartmentType->title,
                'address' => 'Central London',
                'display_address' => 'Central London, UK',
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'slug' => Str::slug('Modern 2 Bed Apartment in London') . '-' . time(),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Test listing created successfully.');
    }
}
