@extends('layouts.modern')

@section('title', 'Partner Program - Join the UK\'s Fastest Growing Property Network')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-primary pt-32 pb-20 overflow-hidden">
        <!-- Background Elements -->
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[120px] -mr-32 -mt-32 pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full text-secondary font-black text-xs uppercase tracking-widest mb-6 border border-white/10">
                        <span class="w-2 h-2 bg-secondary rounded-full animate-pulse"></span> Partner Program
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
                        Earn by <br><span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-secondary to-blue-400">Connecting</span>
                        People
                    </h1>
                    <p class="text-xl text-white mb-8 leading-relaxed font-medium max-w-2xl mx-auto lg:mx-0">
                        Join the PropertyFinda affiliate network. Earn <span
                            class="text-white font-bold">£{{ $rate }}</span> for
                        every {{ number_format($batch_size) }} unique visitors you refer. No limits, instant approval.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @guest
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 bg-secondary text-white font-bold rounded-2xl hover:bg-secondary/90 hover:shadow-lg hover:shadow-secondary/25 transition-all flex items-center justify-center gap-3">
                                Become a Partner <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-8 py-4 bg-white/5 text-white font-bold rounded-2xl hover:bg-white/10 border border-white/10 transition-all flex items-center justify-center gap-3">
                                Sign In
                            </a>
                        @else
                            @if(auth()->user()->affiliate)
                                <a href="{{ route('affiliate.dashboard') }}"
                                    class="px-8 py-4 bg-secondary text-white font-bold rounded-2xl hover:bg-secondary/90 hover:shadow-lg hover:shadow-secondary/25 transition-all flex items-center justify-center gap-3">
                                    Go to Dashboard <i class="fa-solid fa-gauge"></i>
                                </a>
                            @else
                                <a href="{{ route('affiliate.register.view') }}"
                                    class="px-8 py-4 bg-secondary text-white font-bold rounded-2xl hover:bg-secondary/90 hover:shadow-lg hover:shadow-secondary/25 transition-all flex items-center justify-center gap-3">
                                    Activate Account <i class="fa-solid fa-bolt"></i>
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 md:p-10 shadow-2xl">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-primary/50 rounded-3xl p-6 border border-white/5">
                                <div
                                    class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center text-secondary text-xl mb-4">
                                    <i class="fa-solid fa-pound-sign"></i>
                                </div>
                                <div class="text-3xl font-black text-white mb-1">£{{ $rate }}</div>
                                <div class="text-xs text-white/50 uppercase font-bold tracking-wider">Per
                                    {{ number_format($batch_size / 1000, 1) }}k Visitors
                                </div>
                            </div>
                            <div class="bg-primary/50 rounded-3xl p-6 border border-white/5">
                                <div
                                    class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center text-secondary text-xl mb-4">
                                    <i class="fa-solid fa-check-circle"></i>
                                </div>
                                <div class="text-3xl font-black text-white mb-1">100%</div>
                                <div class="text-xs text-white/50 uppercase font-bold tracking-wider">Approval Rate</div>
                            </div>
                            <div
                                class="col-span-2 bg-gradient-to-r from-secondary/20 to-blue-500/20 rounded-3xl p-6 border border-white/5 flex items-center justify-between group cursor-pointer hover:bg-white/5 transition-colors">
                                <div>
                                    <div class="text-xl font-bold text-white mb-1">Generate Link</div>
                                    <div class="text-xs text-white/50 uppercase font-bold tracking-wider">One-click creation
                                    </div>
                                </div>
                                <div
                                    class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white group-hover:bg-secondary transition-colors">
                                    <i class="fa-solid fa-link"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-black text-primary mb-4">How it works</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Start earning in three simple steps. No technical skills
                    required.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Connector Line (Desktop) -->
                <div class="hidden md:block absolute top-12 left-0 w-full h-0.5 bg-gray-100 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 text-center">
                    <div
                        class="w-24 h-24 mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 flex items-center justify-center text-3xl text-secondary mb-6 relative">
                        <i class="fa-solid fa-user-plus"></i>
                        <div
                            class="absolute -top-3 -right-3 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm border-4 border-white">
                            1</div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Register</h3>
                    <p class="text-gray-500 leading-relaxed px-4">Create your free account in seconds. Get instant access to
                        your dashboard.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 text-center">
                    <div
                        class="w-24 h-24 mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 flex items-center justify-center text-3xl text-secondary mb-6 relative">
                        <i class="fa-solid fa-share-nodes"></i>
                        <div
                            class="absolute -top-3 -right-3 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm border-4 border-white">
                            2</div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Share</h3>
                    <p class="text-gray-500 leading-relaxed px-4">Get your unique referral link. Share it on social media,
                        WhatsApp, or your website.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 text-center">
                    <div
                        class="w-24 h-24 mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 flex items-center justify-center text-3xl text-secondary mb-6 relative">
                        <i class="fa-solid fa-wallet"></i>
                        <div
                            class="absolute -top-3 -right-3 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm border-4 border-white">
                            3</div>
                    </div>
                    <h3 class="text-xl font-bold text-primary mb-3">Earn</h3>
                    <p class="text-gray-500 leading-relaxed px-4">Track visitors in real-time. Get paid monthly directly to
                        your bank account.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-5xl font-black text-primary mb-6">Why partner with us?</h2>
                    <p class="text-gray-500 text-lg mb-8 leading-relaxed">
                        We offer one of the most competitive affiliate programs in the UK property market. Our transparent
                        tracking and reliable payouts make us the preferred choice for property influencers.
                    </p>

                    <ul class="space-y-6">
                        @foreach(['Real-time Analytics Dashboard', 'Monthly Payouts via Bank Transfer', 'Dedicated Support Team', 'High-Converting Landing Pages'] as $feature)
                            <li class="flex items-center gap-4">
                                <span
                                    class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary text-sm">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                                <span class="font-bold text-primary">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-chart-pie"></i>
                        </div>
                        <h4 class="font-bold text-primary mb-1">Deep Stats</h4>
                        <p class="text-sm text-gray-500">Know where your traffic comes from</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:-translate-y-1 transition-transform duration-300 mt-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h4 class="font-bold text-primary mb-1">Fast Payments</h4>
                        <p class="text-sm text-gray-500">No waiting around for your money</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:-translate-y-1 transition-transform duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h4 class="font-bold text-primary mb-1">Community</h4>
                        <p class="text-sm text-gray-500">Join 500+ active partners</p>
                    </div>
                    <div
                        class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:-translate-y-1 transition-transform duration-300 mt-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h4 class="font-bold text-primary mb-1">Secure</h4>
                        <p class="text-sm text-gray-500">Bank-grade security standards</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary relative overflow-hidden">
        <div class="absolute inset-0 bg-secondary/10 opacity-50"></div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl font-black text-white mb-6">Ready to start earning?</h2>
            <p class="text-xl text-white mb-10 max-w-2xl mx-auto">
                Join thousands of partners today. It takes less than 2 minutes to get set up.
            </p>
            @guest
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-3 px-10 py-5 bg-white text-primary font-black rounded-2xl hover:bg-gray-50 transition-all shadow-xl shadow-white/10 text-lg">
                    Get Started Now <i class="fa-solid fa-rocket text-secondary"></i>
                </a>
            @else
                <a href="{{ route('affiliate.register.view') }}"
                    class="inline-flex items-center gap-3 px-10 py-5 bg-white text-primary font-black rounded-2xl hover:bg-gray-50 transition-all shadow-xl shadow-white/10 text-lg">
                    Activate Partner Account <i class="fa-solid fa-rocket text-secondary"></i>
                </a>
            @endguest
        </div>
    </section>
@endsection