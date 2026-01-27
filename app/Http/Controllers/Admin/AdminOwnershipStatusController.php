<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OwnershipStatus;

class AdminOwnershipStatusController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OwnershipStatus::latest()->get();
            return response()->json(['data' => $data]);
        }
        return view('admin.ownership_statuses.index');
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

        OwnershipStatus::create($validated);

        return response()->json(['success' => true, 'message' => 'Ownership Status created successfully.']);
    }

    public function edit(string $id)
    {
        $data = OwnershipStatus::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $ownershipStatus = OwnershipStatus::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $ownershipStatus->update($validated);

        return response()->json(['success' => true, 'message' => 'Ownership Status updated successfully.']);
    }

    public function destroy(string $id)
    {
        $ownershipStatus = OwnershipStatus::findOrFail($id);
        $ownershipStatus->delete();

        return response()->json(['success' => true, 'message' => 'Ownership Status deleted successfully.']);
    }
}
