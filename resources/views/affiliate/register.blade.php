@extends('layouts.modern')

@section('title', 'Partner Registration - FindaUK')

@section('content')
    <div class="pt-32 pb-20 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-xl w-full px-4">
            <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
                <div class="bg-primary p-10 text-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h1 class="text-3xl font-black text-white mb-2">Partner Onboarding</h1>
                        <p class="text-blue-100/60 font-medium">Provide your details to generate your unique referral link.
                        </p>
                    </div>
                    <!-- Decoration -->
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-secondary/20 rounded-full blur-2xl"></div>
                </div>

                <div class="p-10">
                    <form action="{{ route('affiliate.register') }}" method="POST" class="space-y-6">
                        @csrf

                        @guest
                            <div class="space-y-5 mb-8 pb-8 border-b border-gray-50">
                                <div class="flex items-center gap-2 mb-4">
                                    <span
                                        class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Account
                                        Creation</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label
                                            class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Full
                                            Name</label>
                                        <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}"
                                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all outline-none">
                                        @error('name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label
                                            class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Email
                                            Address</label>
                                        <input type="email" name="email" required placeholder="john@example.com"
                                            value="{{ old('email') }}"
                                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all outline-none">
                                        @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Secure
                                        Password</label>
                                    <input type="password" name="password" required placeholder="••••••••"
                                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all outline-none">
                                    @error('password') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endguest

                        <!-- WhatsApp Number -->
                        <div>
                            <label
                                class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2 ml-1">WhatsApp
                                Number</label>
                            <div class="relative">
                                <i
                                    class="fa-brands fa-whatsapp absolute left-5 top-1/2 -translate-y-1/2 text-emerald-500 text-lg"></i>
                                <input type="text" name="whatsapp_number" required placeholder="+44 7000 000000"
                                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all outline-none">
                            </div>
                            @error('whatsapp_number') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Promotion Method -->
                        <div>
                            <label
                                class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2 ml-1">How
                                will you promote us?</label>
                            <select name="promotion_method" required
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 px-6 text-primary font-bold focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all outline-none appearance-none">
                                <option value="" disabled selected>Select an option</option>
                                <option value="social_media">Social Media (FB, Insta, TikTok)</option>
                                <option value="whatsapp_groups">WhatsApp Groups / Direct Circle</option>
                                <option value="website">Personal Website / Blog</option>
                                <option value="email_marketing">Email Marketing</option>
                                <option value="other">Other / Multi-channel</option>
                            </select>
                            @error('promotion_method') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Website URL (Optional) -->
                        <div>
                            <label
                                class="block text-gray-400 text-[10px] font-black uppercase tracking-widest mb-2 ml-1">Website
                                or Profile URL (Optional)</label>
                            <div class="relative">
                                <i
                                    class="fa-solid fa-link absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 text-sm"></i>
                                <input type="url" name="website_url" placeholder="https://..."
                                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-primary font-bold placeholder:text-gray-300 focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all outline-none">
                            </div>
                        </div>

                        <!-- Agreement -->
                        <div class="flex items-start gap-3 bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                            <input type="checkbox" required id="agree"
                                class="mt-1 w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                            <label for="agree" class="text-xs text-blue-900/60 font-bold leading-relaxed">
                                I agree to the Partner Terms, including the $50 for 1000 unique visitors commission
                                structure.
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-secondary text-white font-black py-5 rounded-2xl hover:bg-secondary/90 shadow-xl shadow-secondary/20 transition-all flex items-center justify-center gap-3 text-lg">
                            Complete Registration <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection