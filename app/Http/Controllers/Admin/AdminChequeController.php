<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cheque;

class AdminChequeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Cheque::latest()->get();
            return response()->json(['data' => $data]);
        }
        return view('admin.cheques.index');
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

        Cheque::create($validated);

        return response()->json(['success' => true, 'message' => 'Cheque Definition created successfully.']);
    }

    public function edit(string $id)
    {
        $data = Cheque::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        $cheque = Cheque::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $cheque->update($validated);

        return response()->json(['success' => true, 'message' => 'Cheque Definition updated successfully.']);
    }

    public function destroy(string $id)
    {
        $cheque = Cheque::findOrFail($id);
        $cheque->delete();

        return response()->json(['success' => true, 'message' => 'Cheque Definition deleted successfully.']);
    }
}
