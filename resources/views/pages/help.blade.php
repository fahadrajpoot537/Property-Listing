@extends('layouts.modern')

@section('title', 'Help Center A-Z - Finda UK')

@section('content')
    <div class="bg-gray-50 min-h-screen pt-20">

        <!-- Hero Section -->
        <div class="relative bg-primary overflow-hidden py-24">
            <div class="absolute inset-0">
                <img src="{{ asset('assets/img/all-images/hero/hero-img2.png') }}" style="opacity:0.3"
                    class="w-full h-full object-cover opacity-20" alt="Help Center">
                <div class="absolute inset-0 bg-gradient-to-b from-primary/90 to-primary"></div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-secondary/20 text-white text-xs font-bold tracking-widest uppercase mb-6 border border-secondary/20 backdrop-blur-sm">
                    Documentation & Guide
                </span>
                <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight">
                    How can we <span class="text-secondary">help</span> you?
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto font-medium">
                    The complete A-Z guide to using PropertyFinda. Whether you're buying, selling, renting, or earning.
                </p>
            </div>
        </div>

        <!-- Navigation Tabs (Sticky) -->
        <div class="sticky top-20 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm"
            x-data="{ active: 'getting-started' }">
            <div class="max-w-7xl mx-auto px-4 overflow-x-auto">
                <div class="flex space-x-8 min-w-max">
                    <a href="#getting-started"
                        class="py-4 border-b-2 border-transparent hover:border-secondary font-bold text-gray-500 hover:text-primary transition-colors">Getting
                        Started</a>
                    <a href="#buying-renting"
                        class="py-4 border-b-2 border-transparent hover:border-secondary font-bold text-gray-500 hover:text-primary transition-colors">Buying
                        & Renting</a>
                    <a href="#selling-letting"
                        class="py-4 border-b-2 border-transparent hover:border-secondary font-bold text-gray-500 hover:text-primary transition-colors">Selling
                        & Letting</a>
                    <a href="#partners"
                        class="py-4 border-b-2 border-transparent hover:border-secondary font-bold text-gray-500 hover:text-primary transition-colors">Partner
                        Program</a>
                    <a href="#account-types"
                        class="py-4 border-b-2 border-transparent hover:border-secondary font-bold text-gray-500 hover:text-primary transition-colors">Account
                        Types</a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-24">

            <!-- Getting Started -->
            <section id="getting-started" class="scroll-mt-40">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="md:w-1/2">
                        <div
                            class="w-12 h-12 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary text-2xl mb-6">
                            <i class="fa-solid fa-flag-checkered"></i>
                        </div>
                        <h2 class="text-3xl font-black text-primary mb-4">Getting Started</h2>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            Welcome to the UK's most advanced property platform. PropertyFinda connects you with verified
                            estate agents, landlords, and exclusive off-market opportunities.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                                <span class="text-gray-700 font-medium">Create a free account to save searches and
                                    properties.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                                <span class="text-gray-700 font-medium">Verify your email to unlock unlimited
                                    enquiries.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                                <span class="text-gray-700 font-medium">Set up instant alerts for new listings in your
                                    area.</span>
                            </li>
                        </ul>
                    </div>
                    <!-- Mockup UI: Login Card -->
                    <div class="md:w-1/2 relative">
                        <div
                            class="bg-white p-8 rounded-[2rem] shadow-2xl border border-gray-100 rotate-2 hover:rotate-0 transition-transform duration-500">
                            <div class="flex justify-between items-center mb-8">
                                <h3 class="text-2xl font-black text-primary">Sign In</h3>
                                <div class="h-10 w-10 bg-gray-100 rounded-full"></div>
                            </div>
                            <div class="space-y-4">
                                <div class="h-12 bg-gray-50 rounded-xl border border-gray-200 w-full animate-pulse"></div>
                                <div class="h-12 bg-gray-50 rounded-xl border border-gray-200 w-full animate-pulse"></div>
                                <div class="h-12 bg-primary rounded-xl w-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Buying & Renting -->
            <section id="buying-renting" class="scroll-mt-40">
                <div class="flex flex-col md:flex-row-reverse gap-12 items-center">
                    <div class="md:w-1/2">
                        <div
                            class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500 text-2xl mb-6">
                            <i class="fa-solid fa-magnifying-glass-location"></i>
                        </div>
                        <h2 class="text-3xl font-black text-primary mb-4">Buying & Renting</h2>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            Our smart search engine helps you find the perfect home in seconds. Filter by price, location,
                            features, and even specific keywords.
                        </p>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
                            <h4 class="font-bold text-primary mb-2"><i
                                    class="fa-solid fa-map-pin text-secondary mr-2"></i>Smart Map Search</h4>
                            <p class="text-sm text-gray-500">Draw custom areas on the map to find properties exactly where
                                you want to live.</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h4 class="font-bold text-primary mb-2"><i
                                    class="fa-solid fa-filter text-secondary mr-2"></i>Advanced Filters</h4>
                            <p class="text-sm text-gray-500">Filter by 'Pet Friendly', 'Garden', 'Parking', and more to
                                match your lifestyle.</p>
                        </div>
                    </div>
                    <!-- Mockup UI: Search Bar -->
                    <div class="md:w-1/2">
                        <div class="bg-primary p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-secondary/20 rounded-full blur-3xl -mr-20 -mt-20">
                            </div>
                            <div class="relative z-10">
                                <div class="bg-white p-4 rounded-2xl shadow-lg flex gap-4 items-center">
                                    <div
                                        class="w-full h-10 bg-gray-100 rounded-lg flex items-center px-4 text-gray-400 text-sm">
                                        Enter location...</div>
                                    <div class="w-24 h-10 bg-secondary rounded-lg"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-6">
                                    <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm">
                                        <div class="w-8 h-8 bg-white/20 rounded-lg mb-2"></div>
                                        <div class="h-3 w-20 bg-white/30 rounded-full"></div>
                                    </div>
                                    <div class="bg-white/10 p-4 rounded-xl backdrop-blur-sm">
                                        <div class="w-8 h-8 bg-white/20 rounded-lg mb-2"></div>
                                        <div class="h-3 w-16 bg-white/30 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Selling & Letting -->
            <section id="selling-letting" class="scroll-mt-40">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="md:w-1/2">
                        <div
                            class="w-12 h-12 bg-green-500/10 rounded-2xl flex items-center justify-center text-green-500 text-2xl mb-6">
                            <i class="fa-solid fa-house-circle-check"></i>
                        </div>
                        <h2 class="text-3xl font-black text-primary mb-4">Selling & Letting</h2>
                        <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                            Get the best price for your property. Connect with top-rated local agents or request an instant
                            online valuation.
                        </p>
                        <div class="grid grid-cols-1 gap-4">
                            <div
                                class="flex gap-4 p-4 border border-gray-100 rounded-2xl hover:border-secondary/30 transition-colors bg-white">
                                <div
                                    class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0 font-black text-xl">
                                    1</div>
                                <div>
                                    <h4 class="font-bold text-primary">Get a Valuation</h4>
                                    <p class="text-sm text-gray-500">Provide your postcode and details to get an estimated
                                        market value.</p>
                                    <a href="{{ route('map') }}"
                                        class="text-secondary text-sm font-bold mt-1 inline-block">Use Valuation Tool →</a>
                                </div>
                            </div>
                            <div
                                class="flex gap-4 p-4 border border-gray-100 rounded-2xl hover:border-secondary/30 transition-colors bg-white">
                                <div
                                    class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0 font-black text-xl">
                                    2</div>
                                <div>
                                    <h4 class="font-bold text-primary">Choose an Agent</h4>
                                    <p class="text-sm text-gray-500">Compare reliable local agents based on performance and
                                        reviews.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2">
                        <div
                            class="bg-white border-8 border-gray-100 rounded-[3rem] shadow-xl overflow-hidden h-80 relative">
                            <!-- Valuation Mockup -->
                            <div class="absolute inset-0 bg-gray-50 flex items-center justify-center pb-12">
                                <div class="text-center">
                                    <div
                                        class="w-20 h-20 bg-secondary rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl shadow-lg ring-4 ring-secondary/20">
                                        <i class="fa-solid fa-pound-sign"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-primary">Free Valuation</h3>
                                    <div
                                        class="mt-4 bg-white px-4 py-2 rounded-lg shadow-sm w-64 mx-auto border border-gray-200 text-gray-400 text-sm text-left">
                                        Enter Postcode...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Partner Program -->
            <section id="partners" class="scroll-mt-40">
                <div class="bg-secondary rounded-[3rem] p-8 md:p-16 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-32 -mt-32"></div>

                    <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
                        <div>
                            <span
                                class="inline-block bg-white/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-white/20">Affiliate
                                Program</span>
                            <h2 class="text-4xl font-black mb-6">Earn with Us</h2>
                            <p class="text-white/80 text-lg mb-8 leading-relaxed">
                                Join our affiliate network and earn significant commissions by referring new users. We track
                                every visitor and pay you instantly.
                            </p>
                            <a href="{{ route('affiliate.register.view') }}"
                                class="inline-block bg-white text-secondary font-black px-8 py-4 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all">
                                Join Program <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div>
                            <!-- Earnings Dashboard Mockup -->
                            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                                <div class="flex justify-between items-end mb-6">
                                    <div>
                                        <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Total Earnings
                                        </p>
                                        <p class="text-4xl font-black text-white">£1,250.00</p>
                                    </div>
                                    <div class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">+12%</div>
                                </div>
                                <div class="space-y-3">
                                    <div class="bg-white/5 p-3 rounded-lg flex justify-between items-center">
                                        <span class="text-sm font-medium">Referrals</span>
                                        <span class="font-bold">245</span>
                                    </div>
                                    <div class="bg-white/5 p-3 rounded-lg flex justify-between items-center">
                                        <span class="text-sm font-medium">Clicks</span>
                                        <span class="font-bold">1,890</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Account Types -->
            <section id="account-types" class="scroll-mt-40">
                <h2 class="text-3xl font-black text-primary mb-12 text-center">Which account is for you?</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- User -->
                    <div
                        class="bg-white p-8 rounded-[2rem] border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all">
                        <div
                            class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 text-2xl mb-6">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">Home Seeker</h3>
                        <p class="text-gray-500 text-sm mb-6">Perfect for buying, renting, or browsing.</p>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Save
                                Favorites</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Contact
                                Agents</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Rate
                                Properties</li>
                        </ul>
                    </div>

                    <!-- Agent -->
                    <div
                        class="bg-white p-8 rounded-[2rem] border border-secondary/20 shadow-lg shadow-secondary/5 relative overflow-hidden hover:-translate-y-2 transition-all">
                        <div
                            class="absolute top-0 right-0 bg-secondary text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-widest">
                            Popular</div>
                        <div
                            class="w-14 h-14 bg-secondary/10 rounded-full flex items-center justify-center text-secondary text-2xl mb-6">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <h3 class="text-xl font-black text-primary mb-2">Estate Agent</h3>
                        <p class="text-gray-500 text-sm mb-6">For professionals listing properties.</p>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Unlimited
                                Listings</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> 360° Tours
                            </li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Lead
                                Management</li>
                        </ul>
                    </div>

                    <!-- Partner -->
                    <div
                        class="bg-white p-8 rounded-[2rem] border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all">
                        <div
                            class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 text-2xl mb-6">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">Partner</h3>
                        <p class="text-gray-500 text-sm mb-6">For marketers and affiliates.</p>
                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Earn
                                Commissions</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Instant
                                Payouts</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-secondary"></i> Marketing
                                Assets</li>
                        </ul>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection