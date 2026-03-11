<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use App\Models\Tag;
use Illuminate\Support\Str;

class AmenityAndTagSeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            'Gym',
            'Swimming Pool',
            'Concierge',
            'Private Balcony',
            'Garden',
            'Parking',
            'Lift',
            'CCTV',
            'Air Conditioning',
            'Spa',
            'Sauna',
            'Guest Lounge'
        ];

        foreach ($amenities as $item) {
            Amenity::updateOrCreate(
                ['slug' => Str::slug($item)],
                ['title' => $item]
            );
        }

        $tags = [
            'High Yield',
            'Hot Deal',
            'Investment',
            'Off-Plan',
            'Newly Refurbished',
            'Chain Free',
            'Prime Location',
            'Development Opportunity'
        ];

        foreach ($tags as $item) {
            Tag::updateOrCreate(
                ['slug' => Str::slug($item)],
                ['title' => $item]
            );
        }
    }
}
