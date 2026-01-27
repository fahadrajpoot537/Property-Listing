<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check for referral code in session or request
        $referralCode = $request->get('ref') ?? session('ref');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
        ]);

        // Assign default role using Spatie Permission
        $user->assignRole('user');

        // Logic to link with affiliate if referral code exists
        if ($referralCode) {
            $affiliate = \App\Models\Affiliate::where('referral_code', $referralCode)->first();
            if ($affiliate) {
                // Here you would typically create a referral record or link the user.
                // For now, let's just log it or update affiliate earnings as a mock incentive
                // In a real app, you'd have a 'referrals' table.

                // Example: Linking logic (assuming we add a referred_by column to users or a pivot table)
                // $user->referred_by = $affiliate->user_id;
                // $user->save();

                // Mock incentive
                // $affiliate->increment('total_earnings', 10.00); 
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Handle setting the referral code from URL into session.
     */
    public function setReferral(Request $request)
    {
        if ($request->has('ref')) {
            session(['ref' => $request->get('ref')]);
        }
        return redirect()->route('register');
    }
}
