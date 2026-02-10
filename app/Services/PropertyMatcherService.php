<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\PropertyInquiry;
use App\Models\NotifiedListing;
use App\Models\EmailTemplate;
use App\Mail\MatchedPropertyNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PropertyMatcherService
{
    /**
     * Match a newly activated property with existing inquiries from the last 90 days.
     */
    public function matchAndNotify(Listing $listing)
    {
        // Only process if status is approved/active
        if ($listing->status !== 'approved') {
            return;
        }

        Log::info("Starting property matching for listing ID: {$listing->id}");

        // 1. Get inquiries from last 90 days
        // User rule: "USAY AGLI PROPERTIES KI MAIL 90 DAYS TAK HI JAYE GI"
        $matchingInquiries = PropertyInquiry::where('created_at', '>=', now()->subDays(90))
            ->where('bedrooms', $listing->bedrooms)
            ->where('bathrooms', $listing->bathrooms)
            ->where('property_type_id', $listing->property_type_id)
            ->whereBetween('price', [$listing->price * 0.7, $listing->price * 1.3]) // +/- 30% price range
            ->get();

        if ($matchingInquiries->isEmpty()) {
            return;
        }

        // Get the active template if exists
        $template = EmailTemplate::where('type', 'matched_property')
            ->where('is_active', true)
            ->first();

        foreach ($matchingInquiries as $inquiry) {
            // Check for radius (approx 5 miles / 0.08 degrees)
            $latDiff = abs($listing->latitude - $inquiry->latitude);
            $lngDiff = abs($listing->longitude - $inquiry->longitude);

            if ($latDiff > 0.08 || $lngDiff > 0.08) {
                continue;
            }

            // 2. Check if already notified for this property
            // User rule: "1 property ki mail 1 dafa hi jaye gi"
            $alreadyNotified = NotifiedListing::where('property_inquiry_id', $inquiry->id)
                ->where('listing_id', $listing->id)
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            try {
                Mail::to($inquiry->email)->send(
                    new MatchedPropertyNotification($listing, $inquiry, $template)
                );

                // Mark as notified
                NotifiedListing::create([
                    'property_inquiry_id' => $inquiry->id,
                    'listing_id' => $listing->id
                ]);

                Log::info("Notified {$inquiry->email} about listing ID: {$listing->id}");
            } catch (\Exception $e) {
                Log::error("Failed to notify {$inquiry->email} for listing {$listing->id}: " . $e->getMessage());
            }
        }
    }
}
