<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAffiliateController extends Controller
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
            $affiliates = \App\Models\Affiliate::with('user')
                ->withCount('visitorAnalytics')
                ->latest()
                ->get();
            return response()->json(['data' => $affiliates]);
        }
        $users = \App\Models\User::doesntHave('affiliate')->get(); // For the create modal dropdown
        $settings = [
            'rate' => \App\Models\Setting::get('affiliate_rate', 5),
            'batch_size' => \App\Models\Setting::get('affiliate_batch_size', 1000),
        ];
        return view('admin.affiliates.index', compact('users', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        abort_unless(auth()->user()->can('partner.settings'), 403);

        $validated = $request->validate([
            'affiliate_rate' => 'required|numeric|min:0',
            'affiliate_batch_size' => 'required|integer|min:1',
        ]);

        \App\Models\Setting::set('affiliate_rate', $validated['affiliate_rate'], 'affiliate');
        \App\Models\Setting::set('affiliate_batch_size', $validated['affiliate_batch_size'], 'affiliate');

        return redirect()->back()->with('success', 'Affiliate settings updated successfully.');
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:affiliates,user_id',
            'status' => 'required|in:active,inactive,pending',
        ]);

        $user = \App\Models\User::findOrFail($validated['user_id']);
        $resCode = strtoupper(substr($user->name, 0, 3) . rand(1000, 9999));

        $affiliate = \App\Models\Affiliate::create([
            'user_id' => $validated['user_id'],
            'referral_code' => $resCode,
            'status' => $validated['status'],
            'is_verified' => true,
        ]);

        // Load user relation for the response
        $affiliate->load('user');

        return response()->json(['success' => true, 'message' => 'Affiliate created successfully.', 'data' => $affiliate]);
    }

    public function show(string $id)
    {
        $affiliate = \App\Models\Affiliate::with('user')->findOrFail($id);
        return response()->json($affiliate);
    }

    public function edit(string $id)
    {
        $affiliate = \App\Models\Affiliate::with('user')->findOrFail($id);
        return response()->json($affiliate);
    }

    public function update(Request $request, string $id)
    {
        $affiliate = \App\Models\Affiliate::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,inactive,pending',
        ]);

        $affiliate->update([
            'status' => $validated['status'],
        ]);

        return response()->json(['success' => true, 'message' => 'Partner status updated.']);
    }

    public function visitors(string $id)
    {
        $affiliate = \App\Models\Affiliate::with('user')->withCount('visitorAnalytics')->findOrFail($id);
        $visitors = \App\Models\VisitorAnalytic::where('affiliate_id', $id)
            ->latest()
            ->paginate(50);

        return view('admin.affiliates.visitors', compact('affiliate', 'visitors'));
    }

    public function destroy(string $id)
    {
        $affiliate = \App\Models\Affiliate::findOrFail($id);
        $affiliate->delete();

        return response()->json(['success' => true, 'message' => 'Partner deleted successfully.']);
    }
}
