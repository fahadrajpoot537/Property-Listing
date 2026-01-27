<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $features = \App\Models\Feature::with('parent')->latest()->get();
            return response()->json(['data' => $features]);
        }
        $parentFeatures = \App\Models\Feature::whereNull('parent_id')->get();
        return view('admin.features.index', compact('parentFeatures'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:features,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        \App\Models\Feature::create($validated);

        return response()->json(['success' => true, 'message' => 'Feature created successfully.']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $feature = \App\Models\Feature::findOrFail($id);
        return response()->json($feature);
    }

    public function update(Request $request, string $id)
    {
        $feature = \App\Models\Feature::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:features,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        $feature->update($validated);

        return response()->json(['success' => true, 'message' => 'Feature updated successfully.']);
    }

    public function destroy(string $id)
    {
        $feature = \App\Models\Feature::findOrFail($id);
        $feature->delete();

        return response()->json(['success' => true, 'message' => 'Feature deleted successfully.']);
    }
}
