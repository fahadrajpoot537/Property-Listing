<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function landing()
    {
        if (auth()->check() && auth()->user()->affiliate) {
            return redirect()->route('affiliate.dashboard');
        }
        return view('affiliate.landing');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $affiliate = $user->affiliate;

        if (!$affiliate) {
            return redirect()->route('affiliate.welcome');
        }

        $link = url('/') . '?ref=' . $affiliate->referral_code;

        // Stats
        $uniqueVisitorsCount = \App\Models\VisitorAnalytic::where('affiliate_id', $affiliate->id)->distinct('ip_address')->count();
        $totalVisitorsCount = \App\Models\VisitorAnalytic::where('affiliate_id', $affiliate->id)->count();

        // $50 per 1000 unique visitors
        $estimatedEarnings = ($uniqueVisitorsCount / 1000) * 50;

        $stats = [
            'total_visitors' => $totalVisitorsCount,
            'unique_visitors' => $uniqueVisitorsCount,
            'total_earnings' => number_format($estimatedEarnings, 2),
            'referral_link' => $link
        ];

        $recentVisitors = \App\Models\VisitorAnalytic::where('affiliate_id', $affiliate->id)
            ->latest()
            ->take(10)
            ->get();

        return view('affiliate.dashboard', compact('affiliate', 'stats', 'recentVisitors'));
    }

    public function showRegisterForm()
    {
        $user = auth()->user();
        if ($user && $user->affiliate) {
            return redirect()->route('affiliate.dashboard')->with('info', 'You are already a partner.');
        }

        return view('affiliate.register');
    }

    public function register(Request $request)
    {
        $user = auth()->user();
        if ($user && $user->affiliate) {
            return redirect()->route('affiliate.dashboard')->with('info', 'You are already a partner.');
        }

        $rules = [
            'whatsapp_number' => 'required|string|max:20',
            'promotion_method' => 'required|string',
            'website_url' => 'nullable|url|max:255',
        ];

        if (!$user) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|string|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:8';
        }

        $validated = $request->validate($rules);

        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            ]);
            auth()->login($user);
        }

        // Generate high-end referral code
        $resCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $user->name), 0, 3) . rand(1000, 9999));

        \App\Models\Affiliate::create([
            'user_id' => $user->id,
            'referral_code' => $resCode,
            'whatsapp_number' => $validated['whatsapp_number'],
            'promotion_method' => $validated['promotion_method'],
            'website_url' => $validated['website_url'],
            'status' => 'active',
            'is_verified' => true,
        ]);

        return redirect()->route('affiliate.dashboard')->with('success', 'Congratulations! You are now a Partner.');
    }
}
