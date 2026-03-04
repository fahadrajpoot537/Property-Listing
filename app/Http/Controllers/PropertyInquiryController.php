<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\Listing;
use App\Models\PropertyInquiry;
use App\Mail\PropertyInquiry as PropertyInquiryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PropertyInquiryController extends Controller
{
    public function store(Request $request, $id)
    {
        $listing = Listing::with('user')
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $inquiryData = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => 'Listing Inquiry: ' . $listing->property_title,
            'message' => $request->message,
            'phone' => $request->phone ?? null,
        ];

        // Store in ContactSubmission for backward compatibility/general log
        ContactSubmission::create($inquiryData);

        // Store detailed inquiry for matching logic
        \App\Models\PropertyInquiry::create([
            'listing_id' => $listing->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            'message' => $request->message,
            'bedrooms' => $listing->bedrooms,
            'bathrooms' => $listing->bathrooms,
            'price' => $listing->price,
            'latitude' => $listing->latitude,
            'longitude' => $listing->longitude,
            'property_type_id' => $listing->property_type_id,
        ]);

        // Save to Enquiry table for User Tracking (Rightmove style)
        \App\Models\Enquiry::create([
            'user_id' => auth()->id(),
            'listing_id' => $listing->id,
            'agent_email' => $listing->user->email ?? 'info@propertyfinda.co.uk',
            'message' => $request->message,
            'status' => 'sent',
        ]);

        // Send email to property owner if they have an email
        if ($listing->user && $listing->user->email) {
            Mail::to($listing->user->email)->send(new PropertyInquiryMail($inquiryData, $listing));
        }

        return back()->with('success', 'Your inquiry has been sent to the property owner.');
    }
}
