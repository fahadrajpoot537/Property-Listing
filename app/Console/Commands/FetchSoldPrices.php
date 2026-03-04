<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchSoldPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:sold-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch sold house prices from Patma API and sync with local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = '3f5f396290a1e9c3be70b679210c188d3562a0d9';

        // Fetch all distinct postcodes from our listings to get local sold data
        $postcodes = \App\Models\Listing::distinct()->pluck('postcode')->filter();

        $this->info('Starting sold price sync for ' . $postcodes->count() . ' postcodes.');

        foreach ($postcodes as $postcode) {
            $this->info("Fetching for postcode: $postcode");

            $url = "https://app.patma.co.uk/api/prospector/v1/list-property/?postcode=" . urlencode($postcode) . "&radius=0.5&require_sold_price=true&include_sold_history=true&token=" . $apiKey;

            try {
                $response = \Illuminate\Support\Facades\Http::timeout(30)->get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['status']) && $data['status'] === 'success' && isset($data['data']['available_results'])) {
                        foreach ($data['data']['available_results'] as $property) {
                            if (isset($property['sold_history']) && is_array($property['sold_history'])) {
                                foreach ($property['sold_history'] as $history) {
                                    $this->syncSoldPrice($property, $history);
                                }
                            }
                        }
                    }
                } else {
                    $this->error("Failed to fetch data for $postcode. Status: " . $response->status());
                }
            } catch (\Exception $e) {
                $this->error("Error fetching for $postcode: " . $e->getMessage());
            }

            // Sleep briefly to avoid hitting rate limits too hard
            usleep(200000);
        }

        $this->info('Sold price sync complete.');
    }

    private function syncSoldPrice($property, $history)
    {
        try {
            \App\Models\SoldPrice::updateOrCreate(
                [
                    'postcode' => $property['postcode'] ?? '',
                    'sold_at' => $history['date'],
                    'price' => $history['amount'],
                ],
                [
                    'address' => $property['address'] ?? ($property['label'] ?? 'N/A'),
                    'latitude' => $property['latitude'] ?? null,
                    'longitude' => $property['longitude'] ?? null,
                ]
            );
        } catch (\Exception $e) {
            // Likely a duplicate error or missing field, skip and log if necessary
        }
    }
}
