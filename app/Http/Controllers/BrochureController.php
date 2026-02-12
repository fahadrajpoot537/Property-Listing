<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\OffMarketListing;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class BrochureController extends Controller
{
    public function download($id)
    {
        $listing = Listing::with(['features', 'user', 'propertyType', 'unitType', 'ownershipStatus', 'rentFrequency', 'cheque'])
            ->findOrFail($id);

        // Prepare gallery images
        $gallery = is_array($listing->gallery)
            ? $listing->gallery
            : json_decode($listing->gallery, true) ?? [];

        $agent = $listing->user;
        $hideBranding = true; // User requested to hide branding

        // Mortgage Calculation
        $mortgageSettings = \App\Models\MortgageSetting::first();
        $mortgageDetails = null;

        if ($mortgageSettings && $listing->purpose === 'Buy') {
            $price = $listing->price;
            $rate = $mortgageSettings->interest_rate;
            $term = $mortgageSettings->loan_term_years;
            $depositPercent = $mortgageSettings->down_payment_percentage;

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

        $pdf = PDF::loadView('pdf.property-brochure', compact('listing', 'gallery', 'agent', 'hideBranding', 'mortgageDetails'))
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
            ->findOrFail($id);

        // Prepare gallery images
        $gallery = is_array($listing->gallery)
            ? $listing->gallery
            : json_decode($listing->gallery, true) ?? [];

        $agent = auth()->user();
        $hideBranding = true;

        $pdf = PDF::loadView('pdf.property-brochure', compact('listing', 'gallery', 'agent', 'hideBranding'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Private-Asset-' . $listing->property_reference_number . '.pdf';

        return $pdf->download($filename);
    }
}
