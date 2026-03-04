<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedSearchController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'filters' => 'required|array',
        ]);

        $userId = auth()->id();
        $filtersJson = json_encode($request->filters);

        // Check for duplicates
        $exists = \App\Models\SavedSearch::where('user_id', $userId)
            ->whereRaw('JSON_CONTAINS(filters, ?)', [$filtersJson])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This search is already saved.'], 422);
        }

        \App\Models\SavedSearch::create([
            'user_id' => $userId,
            'name' => $request->name ?? 'My Saved Search',
            'filters' => $request->filters,
            'last_checked_at' => now(),
        ]);

        return response()->json(['message' => 'Search saved successfully. We\'ll alert you of new matches!']);
    }

    public function index()
    {
        $savedSearches = auth()->user()->savedSearches()->latest()->get();
        return view('dashboard.saved-searches', compact('savedSearches'));
    }

    public function destroy($id)
    {
        auth()->user()->savedSearches()->findOrFail($id)->delete();
        return back()->with('success', 'Saved search removed.');
    }
}
