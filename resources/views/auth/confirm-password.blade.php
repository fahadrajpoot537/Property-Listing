@extends('layouts.modern')

@section('title', 'Confirm Password - PropertyFinda')

@section('content')
    <div class="min-h-screen pt-24 md:pt-32 pb-12 flex items-center justify-center px-4 bg-gray-50">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100 animate-fadeInUp">
            
            <!-- Icon Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto bg-secondary/10 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-shield-halved text-4xl text-secondary"></i>
                </div>
                <h2 class="text-3xl font-black text-primary mb-2">Confirm Password</h2>
                <p class="text-gray-500 font-medium">This is a secure area. Please confirm your password.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <!-- Password -->
                <div class="space-y-2" x-data="{ show: false }">
                    <label for="password" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                        </div>
                        <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                            class="w-full pl-11 pr-12 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-800"
                            placeholder="Enter your password">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-secondary transition-colors">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-extrabold text-lg rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-check-double"></i>
                    Confirm Password
                </button>
            </form>
        </div>
    </div>
@endsection
