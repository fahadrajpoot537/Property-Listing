<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPropertyTypeController extends Controller
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
            $propertyTypes = \App\Models\PropertyType::latest()->get();
            return response()->json(['data' => $propertyTypes]);
        }
        return view('admin.property_types.index');
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        \App\Models\PropertyType::create($validated);

        return response()->json(['success' => true, 'message' => 'Property Type created successfully.']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $propertyType = \App\Models\PropertyType::findOrFail($id);
        return response()->json($propertyType);
    }

    public function update(Request $request, string $id)
    {
        $propertyType = \App\Models\PropertyType::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        $propertyType->update($validated);

        return response()->json(['success' => true, 'message' => 'Property Type updated successfully.']);
    }

    public function destroy(string $id)
    {
        $propertyType = \App\Models\PropertyType::findOrFail($id);
        $propertyType->delete();

        return response()->json(['success' => true, 'message' => 'Property Type deleted successfully.']);
    }
}
