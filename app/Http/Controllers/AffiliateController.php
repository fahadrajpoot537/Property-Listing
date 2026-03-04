<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotification;

class AffiliateController extends Controller
{
    public function landing()
    {
        if (auth()->check() && auth()->user()->affiliate) {
            return redirect()->route('affiliate.dashboard');
        }
        return view('affiliate.landing', [
            'rate' => \App\Models\Setting::get('affiliate_rate', 5),
            'batch_size' => \App\Models\Setting::get('affiliate_batch_size', 1000)
        ]);
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

        // Dynamic Earnings Calculation
        $rate = \App\Models\Setting::get('affiliate_rate', 5);
        $batchSize = \App\Models\Setting::get('affiliate_batch_size', 1000);

        $estimatedEarnings = 0;
        if ($batchSize > 0) {
            $estimatedEarnings = ($uniqueVisitorsCount / $batchSize) * $rate;
        }

        $stats = [
            'total_visitors' => $totalVisitorsCount,
            'unique_visitors' => $uniqueVisitorsCount,
            'total_earnings' => number_format($estimatedEarnings, 2),
            'referral_link' => $link,
            'rate' => $rate,
            'batch_size' => $batchSize
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

        // Notify Admin
        Mail::to('info@propertyfinda.co.uk')->send(new AdminNotification('affiliate_registered', [
            'user' => $user
        ]));

        return redirect()->route('affiliate.dashboard')->with('success', 'Congratulations! You are now a Partner.');
    }
}
