@extends('layouts.modern')

@section('title', 'Forgot Password - PropertyFinda')

@section('content')
    <div class="min-h-screen pt-24 md:pt-32 pb-12 flex items-center justify-center px-4 bg-gray-50">
        <div class="max-w-2xl w-full bg-white rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100 animate-fadeInUp">
            
            <!-- Icon Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto bg-secondary/10 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-lock-open text-4xl text-secondary"></i>
                </div>
                <h2 class="text-3xl font-black text-primary mb-2">Forgot Password?</h2>
                <p class="text-gray-500 font-medium">No problem! We'll send you a reset link.</p>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-5 mb-8">
                <p class="text-sm text-blue-700 font-medium leading-relaxed">
                    <i class="fa-solid fa-info-circle mr-2"></i>
                    Enter your email address and we'll send you instructions to reset your password.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 font-medium flex items-start gap-3">
                    <i class="fa-solid fa-circle-check mt-0.5"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-800"
                            placeholder="Enter your email">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 font-medium flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-extrabold text-lg rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send Reset Link
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-secondary font-bold text-sm transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection
