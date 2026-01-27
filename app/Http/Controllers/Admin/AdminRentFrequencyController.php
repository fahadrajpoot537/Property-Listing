<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentFrequency;

class AdminRentFrequencyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RentFrequency::latest()->get();
            return response()->json(['data' => $data]);
        }
        return view('admin.rent_frequencies.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        RentFrequency::create($validated);

        return response()->json(['success' => true, 'message' => 'Rent Frequency created successfully.']);
    }

    public function edit(string $id)
    {
        $data = RentFrequency::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $rentFrequency = RentFrequency::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $rentFrequency->update($validated);

        return response()->json(['success' => true, 'message' => 'Rent Frequency updated successfully.']);
    }

    public function destroy(string $id)
    {
        $rentFrequency = RentFrequency::findOrFail($id);
        $rentFrequency->delete();

        return response()->json(['success' => true, 'message' => 'Rent Frequency deleted successfully.']);
    }
}
