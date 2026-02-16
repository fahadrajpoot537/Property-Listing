@extends('layouts.modern')

@section('title', 'Partner Registration - FindaUK')

@section('content')
    <div class="min-h-screen pt-24 md:pt-32 pb-12 md:pb-20 flex items-center justify-center px-4 bg-gray-50">
        <div
            class="max-w-2xl w-full bg-white rounded-3xl md:rounded-[2.5rem] shadow-2xl overflow-hidden shadow-primary/5 border border-gray-100 animate-fadeInUp">

            <!-- Registration Form -->
            <div class="p-6 sm:p-12 lg:p-16 bg-white">
                <div class="mb-10 text-center">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 bg-secondary/10 text-secondary text-[10px] font-black uppercase tracking-widest rounded-full mb-4">
                        <i class="fa-solid fa-shield-halved"></i> Secure Partner Application
                    </div>
                    <h1 class="text-3xl font-black text-primary mb-2">Partner Onboarding</h1>
                    <p class="text-gray-400 font-medium">Please fill in your authentic details to get started.</p>
                </div>

                <form action="{{ route('affiliate.register') }}" method="POST" class="space-y-7">
                    @csrf

                    @guest
                        <div class="p-6 bg-gray-50 rounded-3xl border border-gray-100 space-y-6 mb-10">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center">
                                    <i class="fa-solid fa-user-plus text-primary text-sm"></i>
                                </div>
                                <h3 class="text-sm font-black text-primary uppercase tracking-wider">Account Information</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Full
                                        Name</label>
                                    <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}"
                                        class="w-full bg-white border border-gray-200 rounded-2xl py-4 px-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition-all outline-none">
                                    @error('name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Email
                                        Address</label>
                                    <input type="email" name="email" required placeholder="john@example.com"
                                        value="{{ old('email') }}"
                                        class="w-full bg-white border border-gray-200 rounded-2xl py-4 px-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition-all outline-none">
                                    @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Secure
                                    Password</label>
                                <div class="relative group" x-data="{ show: false }">
                                    <input :type="show ? 'text' : 'password'" name="password" required placeholder="••••••••"
                                        class="w-full bg-white border border-gray-200 rounded-2xl py-4 px-6 pr-12 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition-all outline-none">
                                    <button type="button" @click="show = !show"
                                        class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-secondary transition-colors">
                                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endguest

                    <!-- WhatsApp Number -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Business WhatsApp
                            Number</label>
                        <input type="text" name="whatsapp_number" required placeholder="+44 7000 000000"
                            class="w-full py-4 px-6 bg-gray-50 border border-gray-100 rounded-2xl text-primary font-bold focus:bg-white focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition-all outline-none">
                        @error('whatsapp_number') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Promotion Method -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Primary Promotion
                            Channel</label>
                        <div class="relative group">
                            <select name="promotion_method" required
                                class="w-full py-4 px-6 bg-gray-50 border border-gray-100 rounded-2xl text-primary font-black focus:bg-white focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition-all outline-none appearance-none cursor-pointer">
                                <option value="" disabled selected>Select an option</option>
                                <option value="social_media">Social Media (FB, Insta, TikTok)</option>
                                <option value="whatsapp_groups">WhatsApp Groups / Direct Circle</option>
                                <option value="website">Personal Website / Blog</option>
                                <option value="email_marketing">Email Marketing</option>
                                <option value="other">Other / Multi-channel</option>
                            </select>

                        </div>
                        @error('promotion_method') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website URL (Optional) -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Website or Social
                            Profile (Optional)</label>
                        <input type="url" name="website_url" placeholder="https://..."
                            class="w-full py-4 px-6 bg-gray-50 border border-gray-100 rounded-2xl text-primary font-bold focus:bg-white focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition-all outline-none">
                    </div>

                    <!-- Agreement -->
                    <div
                        class="relative group p-4 bg-secondary/5 rounded-2xl border border-secondary/20 hover:bg-secondary/10 transition-all">
                        <label for="agree" class="flex items-start gap-4 cursor-pointer select-none">
                            <input type="checkbox" required id="agree"
                                class="mt-1 w-5 h-5 rounded-lg border-secondary/30 text-secondary focus:ring-secondary cursor-pointer">
                            <span class="text-[11px] text-primary/70 font-bold leading-relaxed">
                                I verify the information provided and agree to the FindaUK Partner Terms, including the
                                <span class="text-secondary">£50 Commission</span> structure per 1,000 unique hits.
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white font-black py-5 rounded-2xl shadow-2xl shadow-primary/20 hover:shadow-primary/40 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-4 text-xl">
                        Become a Partner <i class="fa-solid fa-crown text-secondary"></i>
                    </button>

                    @guest
                        <p class="text-center text-gray-400 font-bold text-sm mt-6">
                            Already have an account? <a href="{{ route('login') }}" class="text-secondary hover:underline">Sign
                                In</a>
                        </p>
                    @endguest
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
@endsection