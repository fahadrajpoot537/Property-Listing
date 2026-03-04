<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotification;

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
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:agent,agency,landlord,buyer'],
        ]);

        // Check for referral code in session or request
        $referralCode = $request->get('ref') ?? session('ref');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'password' => Hash::make($request->password),
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'status' => 'pending',
        ]);

        // Clear cached permissions to ensure role existence is recognized
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Ensure the role exists before assigning
        Role::firstOrCreate(['name' => $request->role, 'guard_name' => 'web']);
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

        // Notify Admin
        Mail::to('info@propertyfinda.co.uk')->send(new AdminNotification('user_registered', [
            'user' => $user,
            'role' => $request->role
        ]));

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
