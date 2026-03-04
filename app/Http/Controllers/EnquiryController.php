<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = auth()->user()->enquiries()
            ->with(['listing', 'offMarketListing'])
            ->latest()
            ->get();

        return view('dashboard.enquiries', compact('enquiries'));
    }

    public function destroy($id)
    {
        auth()->user()->enquiries()->findOrFail($id)->delete();
        return back()->with('success', 'Enquiry removed from your history.');
    }
}
