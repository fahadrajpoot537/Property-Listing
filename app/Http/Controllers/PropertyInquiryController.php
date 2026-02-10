<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ContactSubmission;
use App\Mail\PropertyInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PropertyInquiryController extends Controller
{
    public function store(Request $request, $id)
    {
        $listing = Listing::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $inquiryData = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => 'Listing Inquiry: ' . $listing->property_title,
            'message' => $request->message,
            'phone' => $request->phone ?? null,
        ];

        // Store in ContactSubmission for record keeping
        ContactSubmission::create($inquiryData);

        // Send email to property owner if they have an email
        if ($listing->user && $listing->user->email) {
            Mail::to($listing->user->email)->send(new PropertyInquiry($inquiryData, $listing));
        }

        return back()->with('success', 'Your inquiry has been sent to the property owner.');
    }
}
