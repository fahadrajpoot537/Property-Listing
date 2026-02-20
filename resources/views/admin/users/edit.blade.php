@extends('layouts.admin')

@section('header', 'Edit User Account')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Navigation & Title -->
        <div class="mb-8">
            <a href="{{ route('admin.users.show', $user->id) }}"
                class="inline-flex items-center gap-2 text-xs font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition-colors mb-4">
                <i class='bx bx-left-arrow-alt text-lg'></i>
                Back to Profile
            </a>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Profile Preferences</h1>
            <p class="text-sm font-bold text-slate-400 mt-1 uppercase tracking-widest">Update information for
                {{ $user->name }}</p>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-black text-slate-800 tracking-tight uppercase">Account Security & Basics</h3>
                </div>
                <div class="p-8 space-y-6">
                    <!-- Name & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name"
                                class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-2 px-1">Full
                                Identity Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-800"
                                required>
                        </div>
                        <div>
                            <label for="email"
                                class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-2 px-1">Email
                                Connection</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-800"
                                required>
                        </div>
                    </div>

                    <!-- Phone & Role -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone_number"
                                class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-2 px-1">Cellular
                                Contact</label>
                            <input type="text" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-800">
                        </div>
                        <div>
                            <label for="role"
                                class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-2 px-1">System
                                Authorization</label>
                            <select name="role" id="role"
                                class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-800 appearance-none select2">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ (old('role') ?? ($user->roles->first()->name ?? '')) == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="pt-6 border-t border-slate-100">
                        <label for="password"
                            class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-2 px-1">Security
                            Update (Leave blank to maintain current)</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full pl-12 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-slate-800"
                                placeholder="••••••••">
                            <div
                                class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400">
                                <i class='bx bxs-lock-alt text-xl'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <button type="button" onclick="window.history.back()"
                    class="px-8 py-3.5 text-xs font-black text-slate-400 hover:text-rose-500 uppercase tracking-widest transition-colors">
                    Discard Changes
                </button>
                <button type="submit"
                    class="px-10 py-4 bg-[#8046F1] text-white font-black rounded-3xl hover:bg-[#6D28D9] transition-all active:scale-95 text-sm uppercase tracking-[0.2em] shadow-xl shadow-purple-100 flex items-center gap-3">
                    <i class='bx bxs-save text-xl'></i>
                    Flush & Sync Profile
                </button>
            </div>
        </form>
    </div>
@endsection