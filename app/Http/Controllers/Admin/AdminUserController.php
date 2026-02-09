<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Security: Only Admin, Manager, Listing Director, Q/A, and Agency can access the user list
        // Other roles (e.g., Agent, Freelance) are denied access.
        if (!$user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A', 'Agency'])) {
            abort(403, 'Unauthorized access.');
        }

        if ($request->ajax()) {
            $query = \App\Models\User::with('roles');

            // Admin, Manager, Listing Director, Q/A see all users
            if ($user->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A'])) {
                // No additional filtering needed for these roles
            }
            // Agency users only see their team members (users linked to their agency_id)
            elseif ($user->hasRole('Agency')) {
                $query->where('agency_id', $user->id);
            }
            // For any other role that might somehow bypass the initial 403 (shouldn't happen),
            // or if a new role is added that shouldn't see users, return an empty set.
            else {
                $query->where('id', 0); // Return no users
            }

            $users = $query->latest()->get();
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

        $userCreator = auth()->user();
        $agencyId = null;
        $role = $validated['role'];

        if ($userCreator->hasRole('Agency')) {
            $agencyId = $userCreator->id;
            $role = 'agent'; // Strictly enforce agent role for agency team members
        }

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']) . '-' . time(),
            'agency_id' => $agencyId,
            'status' => 'approved', // Auto-approve team members added by Agencies
        ]);

        $user->assignRole($role);

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

    public function toggleStatus(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|string|in:approved,rejected,pending',
        ]);

        $user->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'User status updated to ' . $validated['status'] . ' successfully.'
        ]);
    }
}
