@php /** @var \App\Models\User $user */ @endphp
@extends('layouts.admin')

@section('header')
    {{ __('My Profile') }}
@endsection

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header Banner -->
        <div
            class="relative overflow-hidden rounded-premium bg-gradient-to-r from-[#131B31] to-[#1F2937] p-8 shadow-premium">
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                <!-- Avatar -->
                <div
                    class="h-24 w-24 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-3xl font-black text-white shadow-xl">
                    {{ substr($user->name, 0, 1) }}
                </div>

                <!-- Info -->
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <span
                            class="px-3 py-1 rounded-lg bg-[#8046F1] text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-purple-500/20">
                            {{ $user->roles->first()->name ?? 'Staff Member' }}
                        </span>
                        <span
                            class="px-3 py-1 rounded-lg bg-white/10 text-white/80 text-xs font-bold flex items-center gap-2">
                            <i class='bx bx-envelope'></i> {{ $user->email }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- decorative circles -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-[#8046F1]/20 blur-2xl"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Edit Profile -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Profile Information Card -->
                <div class="bg-white rounded-premium shadow-premium overflow-hidden border border-slate-100">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <i class='bx bxs-user-detail text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">Account Details</h3>
                                <p class="text-xs text-slate-500 font-medium">Update your personal information</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class='bx bx-user'></i>
                                        </div>
                                        <input type="text" id="name" name="name"
                                            class="pl-10 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 font-medium text-slate-800 placeholder-slate-400 transition-all shadow-sm"
                                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email
                                        Address</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class='bx bx-envelope'></i>
                                        </div>
                                        <input type="email" id="email" name="email"
                                            class="pl-10 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 font-medium text-slate-800 placeholder-slate-400 transition-all shadow-sm"
                                            value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <p class="text-xs text-amber-600 flex items-center gap-1">
                                                <i class='bx bx-error-circle'></i>
                                                {{ __('Your email address is unverified.') }}
                                            </p>

                                            <button form="send-verification"
                                                class="text-xs font-bold text-indigo-600 hover:text-indigo-800 underline mt-1">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </div>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 text-xs font-bold text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    @endif
                                </div>

                                <!-- Role (Read Only) -->
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Assigned Role</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <i class='bx bx-badge-check'></i>
                                        </div>
                                        <input type="text" disabled readonly
                                            class="pl-10 w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500 font-bold cursor-not-allowed shadow-inner"
                                            value="{{ $user->roles->first()->name ?? 'No Role Assigned' }}">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-xs font-bold text-slate-400 uppercase tracking-widest">
                                            Read Only
                                        </div>
                                    </div>
                                    <p class="mt-2 text-xs text-slate-500">
                                        To change your role permissions, please contact a System Administrator.
                                    </p>
                                </div>

                                @if ($user->hasRole('agency'))
                                    <!-- Company Name -->
                                    <div>
                                        <label for="company_name" class="block text-sm font-bold text-slate-700 mb-2">Company
                                            Name</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                <i class='bx bx-building'></i>
                                            </div>
                                            <input type="text" id="company_name" name="company_name"
                                                class="pl-10 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 font-medium text-slate-800 placeholder-slate-400 transition-all shadow-sm"
                                                value="{{ old('company_name', $user->company_name) }}">
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                                    </div>

                                    <!-- Company Registration Number -->
                                    <div>
                                        <label for="company_registration_number"
                                            class="block text-sm font-bold text-slate-700 mb-2">Company Registration
                                            Number</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                                <i class='bx bx-file'></i>
                                            </div>
                                            <input type="text" id="company_registration_number"
                                                name="company_registration_number"
                                                class="pl-10 w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 font-medium text-slate-800 placeholder-slate-400 transition-all shadow-sm"
                                                value="{{ old('company_registration_number', $user->company_registration_number) }}">
                                        </div>
                                        <x-input-error class="mt-2" :messages="$errors->get('company_registration_number')" />
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-50">
                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm font-bold text-emerald-600 flex items-center gap-2">
                                        <i class='bx bx-check-double'></i> {{ __('Saved Successfully.') }}
                                    </p>
                                @endif

                                <button type="submit"
                                    class="px-6 py-2.5 bg-[#131B31] text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 active:scale-95 flex items-center gap-2">
                                    <i class='bx bx-save'></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="bg-white rounded-premium shadow-premium overflow-hidden border border-slate-100">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                                <i class='bx bx-file text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">Verification Documents</h3>
                                <p class="text-xs text-slate-500 font-medium">Manage your identity documents</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.upload-document-form')
                    </div>
                </div>
            </div>

            <!-- Right Column: Security -->
            <div class="space-y-8">
                <!-- Update Password Card -->
                <div class="bg-white rounded-premium shadow-premium overflow-hidden border border-slate-100">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                                <i class='bx bx-shield-quarter text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">Security</h3>
                                <p class="text-xs text-slate-500 font-medium">Update your password</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('put')

                            <div>
                                <label for="update_password_current_password"
                                    class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Current
                                    Password</label>
                                <input type="password" id="update_password_current_password" name="current_password"
                                    class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    autocomplete="current-password">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                            </div>

                            <div>
                                <label for="update_password_password"
                                    class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">New
                                    Password</label>
                                <input type="password" id="update_password_password" name="password"
                                    class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    autocomplete="new-password">
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                            </div>

                            <div>
                                <label for="update_password_password_confirmation"
                                    class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Confirm New
                                    Password</label>
                                <input type="password" id="update_password_password_confirmation"
                                    name="password_confirmation"
                                    class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    autocomplete="new-password">
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                                    class="mt-1" />
                            </div>

                            <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-xs font-bold text-emerald-600">
                                        {{ __('Password Updated') }}
                                    </p>
                                @else
                                    <div></div>
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 bg-white border-2 border-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:border-slate-200 transition-colors text-sm">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Session/Activity (Optional placeholder or just useful info) -->
                <div
                    class="bg-gradient-to-br from-[#8046F1] to-[#6D28D9] rounded-premium shadow-lg p-6 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-lg mb-2">Account Security</h3>
                        <p class="text-white/80 text-sm mb-4">
                            Keep your account secure by using a strong password. If you suspect any unauthorized access,
                            contact support immediately.
                        </p>
                        <div
                            class="flex items-center gap-2 text-xs font-bold bg-white/20 w-fit px-3 py-1 rounded-lg backdrop-blur-sm">
                            <i class='bx bx-shield-alt-2'></i> Protected by SSL
                        </div>
                    </div>
                    <i class='bx bx-lock-alt absolute -bottom-4 -right-4 text-9xl text-white/10'></i>
                </div>
            </div>
        </div>
    </div>
@endsection