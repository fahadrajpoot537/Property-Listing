<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamMemberWelcome;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Security: Only Admin and Agency can access the user list
        if (!$user->hasAnyRole(['admin', 'Agency'])) {
            abort(403, 'Unauthorized access.');
        }

        $query = \App\Models\User::with(['roles', 'agency']);

        // Admin role sees all users by default, Agency only sees team members
        if ($user->hasRole('admin')) {
            if ($request->filled('agency_id')) {
                $query->where('agency_id', $request->agency_id);
            }
        } elseif ($user->hasRole('Agency')) {
            $query->where('agency_id', $user->id);
        } else {
            $query->where('id', 0);
        }

        // Apply Filters
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('phone_number', 'LIKE', "%$search%");
            });
        }

        // Export Logic
        if ($request->has('export')) {
            return $this->exportUsers($query->latest()->get());
        }

        if ($request->ajax()) {
            $users = $query->latest()->get();
            return response()->json(['data' => $users]);
        }

        $roles = \Spatie\Permission\Models\Role::all();
        $agencies = \App\Models\User::role('Agency')->get();
        return view('admin.users.index', compact('roles', 'agencies'));
    }

    private function exportUsers($users)
    {
        $filename = "users_export_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Name', 'Email', 'Phone', 'Role', 'Agency', 'Status', 'Joined Date'];

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                $row = [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone_number,
                    $user->roles->pluck('name')->implode(', '),
                    $user->agency ? $user->agency->name : 'N/A',
                    $user->status,
                    $user->created_at->format('Y-m-d')
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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

        // Re-check permission for store
        if (!$userCreator->hasAnyRole(['admin', 'Agency'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

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

        // Send welcome email if created by Agency or Admin
        if ($userCreator->hasAnyRole(['admin', 'Agency'])) {
            Mail::to($user->email)->send(new TeamMemberWelcome($user, $validated['password']));
        }

        return response()->json(['success' => true, 'message' => 'User created successfully.', 'data' => $user]);
    }

    public function show(string $id)
    {
        $user = \App\Models\User::with(['roles', 'documents', 'agency', 'teamMembers'])->findOrFail($id);

        if (request()->ajax()) {
            return response()->json($user);
        }

        return view('admin.users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = \App\Models\User::with('roles')->findOrFail($id);
        $roles = \Spatie\Permission\Models\Role::all();

        if (request()->ajax()) {
            return response()->json($user);
        }

        return view('admin.users.edit', compact('user', 'roles'));
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

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'User updated successfully.']);
        }

        return redirect()->route('admin.users.show', $id)->with('success', 'User updated successfully.');
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
            'status' => 'required|string|in:approved,rejected,pending,document_approved',
        ]);

        $user->update(['status' => $validated['status']]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User status updated to ' . $validated['status'] . ' successfully.'
            ]);
        }

        return back()->with('success', 'User status updated to ' . $validated['status'] . ' successfully.');
    }
}
