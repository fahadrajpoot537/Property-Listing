@extends('layouts.modern')

@section('title', 'Sign In - PropertyFinda')

@section('content')
    <div class="min-h-screen pt-28 pb-20 flex items-center justify-center px-4 bg-gray-50">
        <div
            class="max-w-5xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row shadow-primary/5 border border-gray-100 animate-fadeInUp">

            <!-- Left Side (Visual/Brand) -->
            <div class="hidden md:flex w-1/2 bg-primary relative flex-col justify-between p-16 overflow-hidden group">
                <!-- Background Image -->
                <div class="absolute inset-0 z-0">
                    <!-- Image -->
                    <img src="{{ asset('assets/img/all-images/hero/hero-img2.png') }}" alt="Luxury Home" style="opacity:0.3"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000 ease-out">


                    <!-- Black Overlay (Base) -->
                    <div class="absolute inset-0 bg-black/60 z-10"></div>

                    <!-- Purple Overlay (Visible) -->
                    <div class="absolute inset-0 z-20" style="background-color: rgba(0, 0, 0, 0.4);"></div>

                    <!-- Tint -->
                    <div class="absolute inset-0 bg-primary/20 mix-blend-multiply z-10"></div>
                </div>

                <!-- Content -->
                <div class="relative z-30">
                    <div
                        class="bg-white/10 backdrop-blur-md w-14 h-14 rounded-2xl flex items-center justify-center border border-white/20 shadow-inner mb-8">
                        <i class="fa-solid fa-house-chimney text-white text-2xl"></i>
                    </div>
                    <h3 class="text-4xl font-serif font-bold text-white mb-3 tracking-wide leading-tight pl-3">Welcome to
                        <br>PropertyFinda
                    </h3>
                    <div class="h-1.5 w-16 bg-secondary rounded-full mt-4"></div>
                </div>

                <div class="relative z-30">
                    <blockquote class="text-white text-xl font-light italic leading-relaxed mb-8 pl-3">
                        "The most seamless property finding experience I've ever had. Highly recommended!"
                    </blockquote>
                    <div class="flex items-center gap-5 pl-3 pb-2">
                        <div class="w-12 h-12 rounded-full bg-white/20 overflow-hidden border-2 border-white/30">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="pl-2">
                            <p class="text-white font-bold text-base">James Wilson</p>
                            <p class="text-white text-sm uppercase tracking-wider">Happy Homeowner</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side (Form) -->
            <div class="w-full md:w-1/2 p-12 md:p-16 lg:p-20 flex flex-col justify-center bg-white">
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-primary mb-2">Sign In</h2>
                    <p class="text-gray-500 font-medium">Please login to access your dashboard.</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div
                        class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-green-700 font-medium text-sm flex items-start gap-3">
                        <i class="fa-solid fa-circle-check mt-0.5"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Login (Email/Username) -->
                    <div class="space-y-2">
                        <label for="login" class="text-xs font-black uppercase tracking-widest text-gray-400 ml-1">Username
                            or Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fa-solid fa-envelope text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                            </div>
                            <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus
                                class="w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-800"
                                placeholder="Type your email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label for="password"
                                class="text-xs font-black uppercase tracking-widest text-gray-400">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-xs font-bold text-secondary hover:text-secondary-dark hover:underline">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative group" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i
                                    class="fa-solid fa-lock text-gray-300 group-focus-within:text-secondary transition-colors"></i>
                            </div>
                            <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                class="w-full pl-11 pr-12 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-gray-800"
                                placeholder="Enter your password">
                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-secondary transition-colors">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <!-- Remember Me -->
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                            <input type="checkbox" name="remember"
                                class="w-5 h-5 rounded border-gray-300 text-secondary focus:ring-secondary/20 transition-all cursor-pointer">
                            <span
                                class="text-sm font-bold text-gray-600 group-hover:text-secondary transition-colors">Remember
                                me</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-extrabold text-xl rounded-2xl shadow-xl shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                        Sign In <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    </button>

                    <!-- No Social Buttons Here -->

                    <p class="mt-8 text-center text-gray-500 font-medium">
                        New to PropertyFinda?
                        <a href="{{ route('register') }}" class="text-secondary font-black hover:underline ml-1">Create
                            Account</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection