<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
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
            $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
            return response()->json(['data' => $roles]);
        }
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('admin.roles.index', compact('permissions'));
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = \Spatie\Permission\Models\Role::create(['name' => $validated['name']]);

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        $role->load('permissions');

        return response()->json(['success' => true, 'message' => 'Role created successfully.', 'data' => $role]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $role = \Spatie\Permission\Models\Role::with('permissions')->findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, string $id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $validated['name']]);

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
    }

    public function destroy(string $id)
    {
        $role = \Spatie\Permission\Models\Role::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true, 'message' => 'Role deleted successfully.']);
    }
}
