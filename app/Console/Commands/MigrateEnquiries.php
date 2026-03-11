<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateEnquiries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-enquiries';
    protected $description = 'Migrate historical PropertyInquiry and Enquiry into WalkThroughInquiry';

    public function handle()
    {
        $pis = \App\Models\PropertyInquiry::all();
        foreach ($pis as $pi) {
            if (!$pi->listing_id)
                continue;
            $listing = \App\Models\Listing::find($pi->listing_id);
            if (!$listing)
                continue;

            $exists = \App\Models\WalkThroughInquiry::where('listing_id', $pi->listing_id)
                ->where('email', $pi->email)
                ->where('message', $pi->message)
                ->exists();

            if (!$exists) {
                \App\Models\WalkThroughInquiry::create([
                    'listing_id' => $pi->listing_id,
                    'off_market_listing_id' => null,
                    'user_id' => $listing->user_id,
                    'sender_id' => null,
                    'name' => $pi->name,
                    'email' => $pi->email,
                    'phone' => $pi->phone,
                    'preferred_time' => 'General Inquiry',
                    'message' => $pi->message,
                    'status' => 'pending',
                    'created_at' => $pi->created_at,
                    'updated_at' => $pi->updated_at,
                ]);
                $this->info("Created listing inquiry from PropertyInquiry.");
            }
        }

        $enqs = \App\Models\Enquiry::all();
        foreach ($enqs as $pi) {
            if ($pi->listing_id) {
                $listing = \App\Models\Listing::find($pi->listing_id);
                if (!$listing)
                    continue;

                $user = \App\Models\User::find($pi->user_id);

                $exists = \App\Models\WalkThroughInquiry::where('listing_id', $pi->listing_id)
                    ->where('user_id', $listing->user_id)
                    ->where('message', $pi->message)
                    ->exists();

                if (!$exists) {
                    \App\Models\WalkThroughInquiry::create([
                        'listing_id' => $pi->listing_id,
                        'off_market_listing_id' => null,
                        'user_id' => $listing->user_id,
                        'sender_id' => $pi->user_id,
                        'name' => $user ? $user->name : 'Unknown User',
                        'email' => $user ? $user->email : 'unknown@example.com',
                        'phone' => $user ? $user->phone_number : 'N/A',
                        'preferred_time' => 'General Inquiry',
                        'message' => $pi->message,
                        'status' => 'pending',
                        'created_at' => $pi->created_at,
                        'updated_at' => $pi->updated_at,
                    ]);
                    $this->info("Created listing inquiry from General Enquiry.");
                }
            } elseif ($pi->off_market_listing_id) {
                $listing = \App\Models\OffMarketListing::find($pi->off_market_listing_id);
                if (!$listing)
                    continue;

                $user = \App\Models\User::find($pi->user_id);

                $exists = \App\Models\WalkThroughInquiry::where('off_market_listing_id', $pi->off_market_listing_id)
                    ->where('user_id', $listing->user_id)
                    ->where('message', $pi->message)
                    ->exists();

                if (!$exists) {
                    \App\Models\WalkThroughInquiry::create([
                        'listing_id' => null,
                        'off_market_listing_id' => $pi->off_market_listing_id,
                        'user_id' => $listing->user_id,
                        'sender_id' => $pi->user_id,
                        'name' => $user ? $user->name : 'Unknown User',
                        'email' => $user ? $user->email : 'unknown@example.com',
                        'phone' => $user ? $user->phone_number : 'N/A',
                        'preferred_time' => 'Off-Market Inquiry',
                        'message' => $pi->message,
                        'status' => 'pending',
                        'created_at' => $pi->created_at,
                        'updated_at' => $pi->updated_at,
                    ]);
                    $this->info("Created off-market inquiry from General Enquiry.");
                }
            }
        }
        $this->info("Done syncing historical data to WalkThroughInquiries dashboard.");
    }
}
