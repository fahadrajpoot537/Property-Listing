<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = \App\Models\User::with('roles')->latest()->get();
            return response()->json(['data' => $users]);
        }
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.index', compact('roles'));
    }

    public function create()
    {
        // Not used with modals
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
            'phone_number' => 'nullable|string',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']) . '-' . time(),
        ]);

        $user->assignRole($validated['role']);

        return response()->json(['success' => true, 'message' => 'User created successfully.', 'data' => $user]);
    }

    public function show(string $id)
    {
        $user = \App\Models\User::with('roles')->findOrFail($id);
        return response()->json($user);
    }

    public function edit(string $id)
    {
        $user = \App\Models\User::with('roles')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|exists:roles,name',
            'phone_number' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($updateData);

        $user->syncRoles([$validated['role']]);

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }

    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
}
