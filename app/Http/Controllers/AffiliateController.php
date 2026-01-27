<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        if (!$user->affiliate) {
            return redirect()->route('dashboard')->with('error', 'You are not an affiliate yet.');
        }
        $affiliate = $user->affiliate;
        $link = route('set.referral', ['ref' => $affiliate->referral_code]);
        return view('affiliate.dashboard', compact('affiliate', 'link'));
    }

    public function register(Request $request)
    {
        $user = auth()->user();
        if ($user->affiliate) {
            return redirect()->route('affiliate.dashboard')->with('info', 'You are already an affiliate.');
        }

        // Generate simple referral code
        $resCode = strtoupper(substr($user->name, 0, 3) . rand(1000, 9999));

        \App\Models\Affiliate::create([
            'user_id' => $user->id,
            'referral_code' => $resCode,
            'status' => 'active',
            'is_verified' => true, // Auto verify for now
        ]);

        return redirect()->route('affiliate.dashboard')->with('success', 'Affiliate account created successfully.');
    }
}
