<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\OffMarketListing;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Http;

class BrochureController extends Controller
{
    public function download($id)
    {
        $listing = Listing::with(['features', 'user', 'propertyType', 'unitType', 'ownershipStatus', 'rentFrequency', 'cheque'])
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })
            ->firstOrFail();

        $this->prepareBrochureData($listing, $gallery, $contactPerson, $mortgageDetails, $mapImage);

        $hideBranding = true;

        $pdf = PDF::loadView('pdf.property-brochure', compact('listing', 'gallery', 'contactPerson', 'hideBranding', 'mortgageDetails', 'mapImage'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Property-Brochure-' . $listing->property_reference_number . '.pdf';

        return $pdf->download($filename);
    }

    public function downloadOffMarket($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $listing = OffMarketListing::with(['features', 'user', 'propertyType', 'unitType', 'ownershipStatus', 'rentFrequency', 'cheque'])
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })
            ->firstOrFail();

        $this->prepareBrochureData($listing, $gallery, $contactPerson, $mortgageDetails, $mapImage);

        // For off-market, always use auth user as contact person (already handled by logic below if logged in)
        // But logic below uses auth() check which is true here.

        $hideBranding = true;

        $pdf = PDF::loadView('pdf.property-brochure', compact('listing', 'gallery', 'contactPerson', 'hideBranding', 'mortgageDetails', 'mapImage'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Private-Asset-' . $listing->property_reference_number . '.pdf';

        return $pdf->download($filename);
    }

    private function prepareBrochureData($listing, &$gallery, &$contactPerson, &$mortgageDetails, &$mapImage)
    {
        // Prepare gallery images
        $gallery = is_array($listing->gallery)
            ? $listing->gallery
            : json_decode($listing->gallery, true) ?? [];

        // Contact Person: Logged in user takes precedence over listing agent
        $contactPerson = auth()->check() ? auth()->user() : $listing->user;

        // Mortgage Calculation
        $mortgageDetails = null;
        $mortgageSettings = \App\Models\MortgageSetting::first();

        if ($mortgageSettings && (strtolower($listing->purpose) === 'buy' || strtolower($listing->purpose) === 'sale')) {
            $price = $listing->price;
            $rate = $mortgageSettings->interest_rate ?? 4.5;
            $term = $mortgageSettings->loan_term_years ?? 25;
            $depositPercent = $mortgageSettings->down_payment_percentage ?? 20;

            $deposit = $price * ($depositPercent / 100);
            $principal = $price - $deposit;

            // Monthly calculation
            $monthlyRate = ($rate / 100) / 12;
            $months = $term * 12;

            if ($monthlyRate > 0) {
                $monthlyPayment = $principal * ($monthlyRate * pow(1 + $monthlyRate, $months)) / (pow(1 + $monthlyRate, $months) - 1);
            } else {
                $monthlyPayment = $principal / $months;
            }

            $mortgageDetails = [
                'monthly_payment' => $monthlyPayment,
                'deposit' => $deposit,
                'interest_rate' => $rate,
                'term_years' => $term,
                'deposit_percent' => $depositPercent
            ];
        }

        // Fetch Google Static Map
        $mapImage = null;
        if ($listing->latitude && $listing->longitude) {
            $apiKey = config('services.google.maps_api_key');
            if ($apiKey) {
                $lat = $listing->latitude;
                $lng = $listing->longitude;
                // High res map image
                $mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center={$lat},{$lng}&zoom=15&size=600x300&scale=2&maptype=roadmap&markers=color:0x8046F1%7C{$lat},{$lng}&key={$apiKey}";

                try {
                    $mapData = @file_get_contents($mapUrl);
                    if ($mapData) {
                        $mapImage = 'data:image/png;base64,' . base64_encode($mapData);
                    }
                } catch (\Exception $e) {
                    // Fail silently
                }
            }
        }
    }
}
