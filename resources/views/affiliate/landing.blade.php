@extends('layouts.modern')

@section('title', 'Become a Partner - FindaUK')

@section('content')
    <div class="pt-32 pb-20 bg-primary relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-secondary rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-500 rounded-full blur-[150px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-3/5 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full text-secondary font-black text-xs uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-2 h-2 bg-secondary rounded-full animate-pulse"></span> Opportunity
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight">Become a <span
                            class="text-secondary">Partner</span></h1>
                    <p class="text-xl text-blue-100/70 max-w-2xl font-medium mb-12 leading-relaxed">
                        Join the UK's most innovative property network. Earn commissions while helping us reshape the future
                        of real estate.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 p-8 rounded-[2rem]">
                            <div class="text-4xl font-black text-secondary mb-2">$50</div>
                            <p class="text-blue-100/60 font-bold uppercase tracking-wider text-xs">Per 1,000 unique visitors
                                referred to our listings.</p>
                        </div>
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 p-8 rounded-[2rem]">
                            <div class="text-4xl font-black text-white mb-2">Instant</div>
                            <p class="text-blue-100/60 font-bold uppercase tracking-wider text-xs">Account approval and
                                immediate access to tools.</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        @guest
                            <a href="{{ route('register') }}"
                                class="w-full sm:w-auto px-10 py-5 bg-secondary text-white font-black rounded-2xl hover:bg-secondary/90 transition-all shadow-2xl shadow-secondary/20 text-lg flex items-center justify-center gap-3">
                                Join Now <i class="fa-solid fa-user-plus"></i>
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-10 py-5 bg-white/10 text-white font-black rounded-2xl border border-white/10 hover:bg-white/20 transition-all text-lg flex items-center justify-center gap-3">
                                Partner Login <i class="fa-solid fa-lock text-white/40"></i>
                            </a>
                        @else
                            <a href="{{ route('affiliate.register.view') }}"
                                class="w-full sm:w-auto px-10 py-5 bg-secondary text-white font-black rounded-2xl hover:bg-secondary/90 transition-all shadow-2xl shadow-secondary/20 text-lg flex items-center justify-center gap-3">
                                Start Earning Now <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endguest
                    </div>
                </div>

                <!-- Visual Part -->
                <div class="lg:w-2/5">
                    <div class="relative">
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-secondary to-blue-500 rounded-[3rem] blur-2xl opacity-20">
                        </div>
                        <div
                            class="relative bg-white/5 border border-white/10 p-10 rounded-[3rem] backdrop-blur-xl shadow-2xl">
                            <div
                                class="w-20 h-20 bg-secondary rounded-[1.5rem] flex items-center justify-center text-white text-4xl mb-8 shadow-xl">
                                <i class="fa-solid fa-rocket"></i>
                            </div>
                            <h3 class="text-2xl font-black text-white mb-8">Why Join Finda?</h3>
                            <div class="space-y-6">
                                <div class="flex items-center gap-4">
                                    <span
                                        class="w-10 h-10 bg-secondary/20 rounded-xl flex items-center justify-center text-secondary">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-blue-100 font-bold">Auto-generated referral links</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="w-10 h-10 bg-secondary/20 rounded-xl flex items-center justify-center text-secondary">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-blue-100 font-bold">Real-time unique visitor tracking</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="w-10 h-10 bg-secondary/20 rounded-xl flex items-center justify-center text-secondary">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-blue-100 font-bold">No minimum payout threshold</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span
                                        class="w-10 h-10 bg-secondary/20 rounded-xl flex items-center justify-center text-secondary">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                    <span class="text-blue-100 font-bold">Dedicated partner support</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection