<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrustpilotReview;
use Illuminate\Http\Request;

class TrustpilotReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $review = TrustpilotReview::first();
        return view('admin.trustpilot-reviews.index', compact('review'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|string|max:10',
            'review_count' => 'required|string|max:20',
        ]);

        $review = TrustpilotReview::first();

        if ($review) {
            $review->update($request->all());
        } else {
            TrustpilotReview::create($request->all());
        }

        return redirect()->route('admin.trustpilot-reviews.index')
            ->with('success', 'Trustpilot review updated successfully.');
    }
}
