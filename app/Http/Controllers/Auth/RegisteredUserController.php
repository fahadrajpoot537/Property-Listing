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
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:agent,agency,landlord,buyer'],
        ]);

        // Check for referral code in session or request
        $referralCode = $request->get('ref') ?? session('ref');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => Hash::make($request->password),
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'status' => 'pending',
        ]);

        // Assign selected role using Spatie Permission
        $user->assignRole($request->role);

        // Assign 'access dashboard' permission to allow access to admin dashboard
        if (!\Spatie\Permission\Models\Permission::where('name', 'access dashboard')->exists()) {
            \Spatie\Permission\Models\Permission::create(['name' => 'access dashboard']);
        }
        $user->givePermissionTo('access dashboard');

        // Logic to link with affiliate if referral code exists
        if ($referralCode) {
            $affiliate = \App\Models\Affiliate::where('referral_code', $referralCode)->first();
            if ($affiliate) {
                // Link with affiliate logic here if needed
            }
        }

        event(new Registered($user));

        // Note: We DO NOT log in the user here. Admin must approve first.
        return redirect()->route('login')->with('success', 'Registration successful! Your account is pending admin approval.');
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
