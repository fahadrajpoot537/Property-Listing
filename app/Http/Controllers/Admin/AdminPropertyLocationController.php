<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPropertyLocationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $locations = \App\Models\PropertyLocation::latest()->get();
            return response()->json(['data' => $locations]);
        }
        return view('admin.property_locations.index');
    }

    public function create()
    {
        return view('admin.property_locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('property_locations', 'public');
        }

        \App\Models\PropertyLocation::create($validated);

        return response()->json(['success' => true, 'message' => 'Property Location created successfully.']);
    }

    public function edit($id)
    {
        $location = \App\Models\PropertyLocation::findOrFail($id);
        return response()->json($location);
    }

    public function update(Request $request, $id)
    {
        $location = \App\Models\PropertyLocation::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('property_locations', 'public');
        }

        $location->update($validated);

        return response()->json(['success' => true, 'message' => 'Property Location updated successfully.']);
    }

    public function destroy($id)
    {
        $location = \App\Models\PropertyLocation::findOrFail($id);
        $location->delete();

        return response()->json(['success' => true, 'message' => 'Property Location deleted successfully.']);
    }
}
