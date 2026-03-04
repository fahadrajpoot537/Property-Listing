<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessSavedSearchAlerts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \App\Models\SavedSearch::where('is_active', true)
            ->chunk(100, function ($searches) {
                foreach ($searches as $search) {
                    $this->processSearch($search);
                }
            });
    }

    private function processSearch($search)
    {
        $filters = $search->filters;
        $query = \App\Models\Listing::where('status', 'approved');

        // Filter for only ones created since last check
        if ($search->last_checked_at) {
            $query->where('created_at', '>', $search->last_checked_at);
        } else {
            // If never checked, check for last 24 hours to avoid massive first email
            $query->where('created_at', '>', now()->subDay());
        }

        // Apply filters
        if (!empty($filters['purpose'])) {
            $query->where('purpose', $filters['purpose']);
        }

        if (!empty($filters['property_type_id'])) {
            $query->where('property_type_id', $filters['property_type_id']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', (float) $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', (float) $filters['max_price']);
        }

        if (!empty($filters['bedrooms'])) {
            $val = (int) $filters['bedrooms'];
            if ($val >= 10) {
                $query->where('bedrooms', '>=', 10);
            } else {
                $query->where('bedrooms', $val);
            }
        }

        // Radius Search
        if (!empty($filters['lat']) && !empty($filters['lng'])) {
            $lat = $filters['lat'];
            $lng = $filters['lng'];
            $radius = !empty($filters['radius']) ? (float) $filters['radius'] : 2;

            if ($radius <= 0)
                $radius = 0.1;

            $query->whereRaw("COALESCE(( 3959 * acos( LEAST(1, GREATEST(-1, cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) )) ) ), 0) <= ?", [$lat, $lng, $lat, $radius]);
        }

        $newListings = $query->get();

        if ($newListings->count() > 0) {
            \Illuminate\Support\Facades\Mail::to($search->user->email)
                ->send(new \App\Mail\PropertyAlertNotification($search, $newListings));
        }

        // Update last checked
        $search->update(['last_checked_at' => now()]);
    }
}
