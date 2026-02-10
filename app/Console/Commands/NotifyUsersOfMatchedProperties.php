<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NotifyUsersOfMatchedProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:matched-properties';
    protected $description = 'Notify users about new properties that match their previous inquiries';

    public function handle()
    {
        $this->info('Starting property matching process for recent listings...');

        $newListings = \App\Models\Listing::where('status', 'approved')
            ->where('created_at', '>=', now()->subDay())
            ->get();

        if ($newListings->isEmpty()) {
            $this->info('No recent approved listings found.');
            return;
        }

        $service = new \App\Services\PropertyMatcherService();

        foreach ($newListings as $listing) {
            $this->info("Processing listing: {$listing->property_title}");
            $service->matchAndNotify($listing);
        }

        $this->info('Matching process completed.');
    }
}
