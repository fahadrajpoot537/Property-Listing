<?php

namespace App\Http\Controllers;

use App\Models\WalkThroughInquiry;
use App\Models\Listing;
use App\Models\User;
use App\Mail\WalkThroughInquiryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WalkThroughInquiryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']);
        $isAgency = $user->hasRole('Agency');

        $query = WalkThroughInquiry::with(['listing', 'offMarketListing', 'sender'])->latest();

        // Apply Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('listing_type')) {
            if ($request->listing_type === 'public') {
                $query->whereNotNull('listing_id');
            } elseif ($request->listing_type === 'off_market') {
                $query->whereNotNull('off_market_listing_id');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        if (!$isAdmin) {
            if ($isAgency || ($user->hasRole('agent') && $user->agency_id)) {
                $ownerId = $isAgency ? $user->id : $user->agency_id;
                $teamIds = \App\Models\User::where('agency_id', $ownerId)->pluck('id')->toArray();
                $userIds = array_merge([$ownerId], $teamIds);
                $query->whereIn('user_id', $userIds);
            } else {
                $query->where('user_id', $user->id);
            }
        }

        $inquiries = $query->paginate(15)->appends($request->all());
        return view('admin.walkthrough.index', compact('inquiries'));
    }

    public function updateStatus(Request $request, $id)
    {
        $inquiry = WalkThroughInquiry::findOrFail($id);

        // Authorization: Only owner or admin can update
        $user = auth()->user();
        $isAdmin = $user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']);

        if (!$isAdmin && $inquiry->user_id !== $user->id) {
            // Check if user is in the same agency
            $isAgency = $user->hasRole('Agency');
            if ($isAgency || ($user->hasRole('agent') && $user->agency_id)) {
                $ownerId = $isAgency ? $user->id : $user->agency_id;
                $teamIds = \App\Models\User::where('agency_id', $ownerId)->pluck('id')->toArray();
                if (!in_array($inquiry->user_id, array_merge([$ownerId], $teamIds))) {
                    abort(403);
                }
            } else {
                abort(403);
            }
        }

        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $inquiry->update(['status' => $request->status]);

        return back()->with('success', 'Status updated successfully!');
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'preferred_time' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $listingType = $request->input('listing_type', 'public');
        $listing = null;
        $offMarketListing = null;

        if ($listingType === 'off_market') {
            $offMarketListing = \App\Models\OffMarketListing::where('id', $id)
                ->orWhere('slug', $id)
                ->first();
        } else {
            $listing = \App\Models\Listing::where('id', $id)
                ->orWhere('slug', $id)
                ->first();

            // Fallback if not specified and not found in public
            if (!$listing && $request->input('listing_type') === null) {
                $offMarketListing = \App\Models\OffMarketListing::where('id', $id)
                    ->orWhere('slug', $id)
                    ->first();
            }
        }

        if (!$listing && !$offMarketListing) {
            abort(404, 'Property not found.');
        }

        WalkThroughInquiry::create([
            'listing_id' => $listing->id ?? null,
            'off_market_listing_id' => $offMarketListing->id ?? null,
            'user_id' => $listing ? $listing->user_id : $offMarketListing->user_id,
            'sender_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'preferred_time' => $request->preferred_time,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        $inquiryData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'preferred_time' => $request->preferred_time,
            'message' => $request->message,
        ];

        // Determine property and owner
        $property = $listing ?? $offMarketListing;
        $isOffMarket = $offMarketListing !== null;

        $owner = User::find($property->user_id);

        if ($owner && $owner->email) {
            $notificationEmail = $owner->email;

            // Route to agency if agent belongs to one
            if ($owner->hasRole('agent') && $owner->agency_id) {
                $agency = User::find($owner->agency_id);
                if ($agency && $agency->email) {
                    $notificationEmail = $agency->email;
                }
            }

            Mail::to($notificationEmail)->send(new WalkThroughInquiryMail($inquiryData, $property, $isOffMarket));
        }

        return back()->with('success', 'Your virtual tour request has been sent successfully!');
    }
}
