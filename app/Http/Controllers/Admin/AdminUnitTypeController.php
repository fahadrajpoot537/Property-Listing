<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUnitTypeController extends Controller
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
            $unitTypes = \App\Models\UnitType::with('propertyType')->latest()->get();
            return response()->json(['data' => $unitTypes]);
        }
        $propertyTypes = \App\Models\PropertyType::all();
        return view('admin.unit_types.index', compact('propertyTypes'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        \App\Models\UnitType::create($validated);

        return response()->json(['success' => true, 'message' => 'Unit Type created successfully.']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $unitType = \App\Models\UnitType::findOrFail($id);
        return response()->json($unitType);
    }

    public function update(Request $request, string $id)
    {
        $unitType = \App\Models\UnitType::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'property_type_id' => 'required|exists:property_types,id',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']);

        $unitType->update($validated);

        return response()->json(['success' => true, 'message' => 'Unit Type updated successfully.']);
    }

    public function destroy(string $id)
    {
        try {
            $unitType = \App\Models\UnitType::findOrFail($id);
            $unitType->delete();
            return response()->json(['success' => true, 'message' => 'Unit Type deleted successfully.']);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") { // Integrity constraint violation
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this Unit Type because it is being used by existing listings.'
                ], 422);
            }
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong during deletion.'
            ], 500);
        }
    }
}
