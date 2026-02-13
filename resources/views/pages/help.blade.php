@extends('layouts.modern')

@section('title', 'Help Center - PropertyFinda')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-primary via-primary-light to-secondary overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-96 h-96 bg-secondary rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-black mb-6">
                    How Can We <span class="text-secondary-light">Help You?</span>
                </h1>
                <p class="text-lg sm:text-xl text-whitemb-8 max-w-2xl mx-auto font-medium">
                    Find answers to your questions and learn how to make the most of PropertyFinda
                </p>

                <!-- Search Bar -->
                <div class="relative max-w-2xl mx-auto" style="margin-top:2%">
                    <input type="text" id="helpSearch"
                        class="w-full px-6 py-4 pr-14 rounded-full text-lg border-0 shadow-2xl focus:ring-4 focus:ring-secondary/50 transition-all text-gray-900"
                        placeholder="Search for help articles...">
                    <i class="fas fa-search absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white border-b sticky top-20 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-2 overflow-x-auto py-4 scrollbar-hide">
                <a href="#getting-started"
                    class="nav-pill whitespace-nowrap px-6 py-2 rounded-full font-semibold text-sm transition-all hover:bg-primary hover:text-white">
                    <i class="fas fa-rocket mr-2"></i>Getting Started
                </a>
                <a href="#roles"
                    class="nav-pill whitespace-nowrap px-6 py-2 rounded-full font-semibold text-sm transition-all hover:bg-primary hover:text-white">
                    <i class="fas fa-users mr-2"></i>User Roles
                </a>
                <a href="#search"
                    class="nav-pill whitespace-nowrap px-6 py-2 rounded-full font-semibold text-sm transition-all hover:bg-primary hover:text-white">
                    <i class="fas fa-search mr-2"></i>Search
                </a>
                <a href="#valuation"
                    class="nav-pill whitespace-nowrap px-6 py-2 rounded-full font-semibold text-sm transition-all hover:bg-primary hover:text-white">
                    <i class="fas fa-calculator mr-2"></i>Valuation
                </a>
                <a href="#affiliate"
                    class="nav-pill whitespace-nowrap px-6 py-2 rounded-full font-semibold text-sm transition-all hover:bg-primary hover:text-white">
                    <i class="fas fa-money-bill-wave mr-2"></i>Affiliate
                </a>
                <a href="#faq"
                    class="nav-pill whitespace-nowrap px-6 py-2 rounded-full font-semibold text-sm transition-all hover:bg-primary hover:text-white">
                    <i class="fas fa-question-circle mr-2"></i>FAQ
                </a>
            </div>
        </div>
    </div>

    <div class="bg-gray-50">
        <!-- Getting Started -->
        <section id="getting-started" class="py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-primary mb-4">Getting Started</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Everything you need to know to begin your property
                        journey</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm hover:shadow-xl transition-all group">
                        <div
                            class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-2xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">Create Account</h3>
                        <p class="text-gray-600">Sign up in seconds and choose your account type</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm hover:shadow-xl transition-all group">
                        <div
                            class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-2xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-envelope-circle-check"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">Verify Email</h3>
                        <p class="text-gray-600">Verify your email to unlock all features</p>
                    </div>

                    <div
                        class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm hover:shadow-xl transition-all group sm:col-span-2 lg:col-span-1">
                        <div
                            class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 text-2xl mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3 class="text-xl font-bold text-primary mb-2">Set Alerts</h3>
                        <p class="text-gray-600">Get notified about new properties instantly</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- User Roles -->
        <section id="roles" class="py-16 lg:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-primary mb-4">User Roles</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Understand what each role can do on PropertyFinda</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- User -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-6 border-2 border-blue-100 hover:border-blue-300 transition-all">
                        <span
                            class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full mb-4">REGULAR
                            USER</span>
                        <h3 class="text-2xl font-black text-primary mb-2">User</h3>
                        <p class="text-sm text-gray-600 mb-4">Browse and search properties</p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center"><i class="fas fa-check-circle text-blue-600 mr-2"></i> Search
                                properties</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-blue-600 mr-2"></i> Save
                                favorites</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-blue-600 mr-2"></i> Contact
                                agents</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-blue-600 mr-2"></i> Get
                                valuations</li>
                        </ul>
                    </div>

                    <!-- Agent -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-white rounded-2xl p-6 border-2 border-green-100 hover:border-green-300 transition-all">
                        <span
                            class="inline-block px-3 py-1 bg-green-600 text-white text-xs font-bold rounded-full mb-4">PROFESSIONAL</span>
                        <h3 class="text-2xl font-black text-primary mb-2">Agent</h3>
                        <p class="text-sm text-gray-600 mb-4">List and manage properties</p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center"><i class="fas fa-check-circle text-green-600 mr-2"></i> Create
                                listings</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-green-600 mr-2"></i> Manage
                                enquiries</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-green-600 mr-2"></i> Track
                                analytics</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-green-600 mr-2"></i> Agency
                                association</li>
                        </ul>
                    </div>

                    <!-- Agency -->
                    <div
                        class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-6 border-2 border-purple-100 hover:border-purple-300 transition-all">
                        <span
                            class="inline-block px-3 py-1 bg-purple-600 text-white text-xs font-bold rounded-full mb-4">BUSINESS</span>
                        <h3 class="text-2xl font-black text-primary mb-2">Agency</h3>
                        <p class="text-sm text-gray-600 mb-4">Manage team & properties</p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i> Add
                                agents</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i> Bulk
                                uploads</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i> Team
                                analytics</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-purple-600 mr-2"></i> Lead
                                management</li>
                        </ul>
                    </div>

                    <!-- Affiliate -->
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-white rounded-2xl p-6 border-2 border-yellow-100 hover:border-yellow-300 transition-all">
                        <span
                            class="inline-block px-3 py-1 bg-yellow-600 text-white text-xs font-bold rounded-full mb-4">EARN
                            MONEY</span>
                        <h3 class="text-2xl font-black text-primary mb-2">Affiliate</h3>
                        <p class="text-sm text-gray-600 mb-4">Earn commissions</p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-center"><i class="fas fa-check-circle text-yellow-600 mr-2"></i> Referral
                                links</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-yellow-600 mr-2"></i> Track
                                earnings</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-yellow-600 mr-2"></i> Instant
                                payouts</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-yellow-600 mr-2"></i> Marketing
                                tools</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Property Search -->
        <section id="search" class="py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-primary mb-6">Property Search</h2>
                        <p class="text-lg text-gray-600 mb-8">Find your dream property with our powerful search tools</p>

                        <div class="space-y-4">
                            <div class="flex items-start gap-4 bg-white p-4 rounded-xl shadow-sm">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">Location-Based Search</h4>
                                    <p class="text-sm text-gray-600">Search by postcode, city, or area with radius filters
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 bg-white p-4 rounded-xl shadow-sm">
                                <div
                                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 flex-shrink-0">
                                    <i class="fas fa-sliders-h"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">Advanced Filters</h4>
                                    <p class="text-sm text-gray-600">Filter by price, bedrooms, property type, and more</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 bg-white p-4 rounded-xl shadow-sm">
                                <div
                                    class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-600 flex-shrink-0">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-primary mb-1">Save Favorites</h4>
                                    <p class="text-sm text-gray-600">Bookmark properties and get alerts on price changes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-xl">
                        <h3 class="text-xl font-bold text-primary mb-4">Try Search Now</h3>
                        <div class="space-y-4">
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary focus:border-transparent"
                                placeholder="Enter location...">
                            <div class="grid grid-cols-2 gap-4">
                                <select
                                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary focus:border-transparent">
                                    <option>Property Type</option>
                                    <option>House</option>
                                    <option>Flat</option>
                                </select>
                                <select
                                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary focus:border-transparent">
                                    <option>Bedrooms</option>
                                    <option>1+</option>
                                    <option>2+</option>
                                    <option>3+</option>
                                </select>
                            </div>
                            <button
                                class="w-full bg-secondary hover:bg-secondary-dark text-white font-bold py-3 px-6 rounded-xl transition-all transform hover:scale-105">
                                <i class="fas fa-search mr-2"></i> Search Properties
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Valuation -->
        <section id="valuation" class="py-16 lg:py-24 bg-gradient-to-br from-green-50 via-blue-50 to-purple-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#131B31] mb-6">Property Valuation</h2>
                        <p class="text-lg text-[#131B31] mb-8 font-medium">Get an instant, accurate estimate of your
                            property's market
                            value</p>

                        <div class="grid sm:grid-cols-2 gap-4 mb-8">
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-location-dot text-green-600 text-xl"></i>
                                    <h4 class="font-bold text-primary">Enter Postcode</h4>
                                </div>
                                <p class="text-sm text-gray-600">Enter your property's postcode</p>
                            </div>

                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-home text-blue-600 text-xl"></i>
                                    <h4 class="font-bold text-primary">Property Details</h4>
                                </div>
                                <p class="text-sm text-gray-600">Provide basic information</p>
                            </div>

                            <div class="bg-white rounded-xl p-4 shadow-sm sm:col-span-2">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                                    <h4 class="font-bold text-primary">Instant Estimate</h4>
                                </div>
                                <p class="text-sm text-gray-600">Receive instant market valuation</p>
                            </div>
                        </div>

                        <a href="{{ route('map') }}"
                            class="inline-block bg-green-600 hover:bg-green-700 text-black font-bold py-4 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg">
                            <i class="fas fa-calculator mr-2"></i> Get Free Valuation
                        </a>
                    </div>

                    <div class="order-1 lg:order-2">
                        <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-2xl text-center">
                            <div
                                class="w-24 h-24 bg-green-600 rounded-full flex items-center justify-center text-white text-4xl mx-auto mb-6 shadow-lg">
                                <i class="fas fa-pound-sign"></i>
                            </div>
                            <h3 class="text-2xl font-black text-[#131B31] mb-2">Free Valuation</h3>
                            <p class="text-gray-800 mb-6 font-medium">Get your property value in seconds</p>
                            <div class="bg-gray-100 px-6 py-4 rounded-xl">
                                <i class="fas fa-location-dot text-green-600 mr-2"></i>
                                <span class="text-gray-700 font-bold">Enter Postcode...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Affiliate -->
        <section id="affiliate" class="py-16 lg:py-24 bg-[#131B31] text-white relative overflow-hidden"
            style="background: linear-gradient(135deg, #131B31 0%, #8046F1 50%, #6D28D9 100%);">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span
                            class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-bold mb-4text-white">EARN
                            MONEY</span>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-6 text-white">Affiliate Program</h2>
                        <p class="text-lg text-white mb-8">Join our affiliate network and earn generous commissions by
                            referring new users</p>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-percent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white">High Commission Rates</h4>
                                    <p class="text-white text-sm">Earn up to 20% on every referral</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chart-simple"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white">Real-Time Analytics</h4>
                                    <p class="text-white text-sm">Track clicks, conversions, and earnings live</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white">Instant Payouts</h4>
                                    <p class="text-white text-sm">Withdraw your earnings anytime</p>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('affiliate.register.view') }}"
                            class="inline-block bg-white text-secondary font-bold py-4 px-8 rounded-xl hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                            Join Affiliate Program <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <div>
                        <div class="bg-white/25 backdrop-blur-md rounded-2xl p-6 lg:p-8 border border-white/30 shadow-2xl">
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <p class="text-white text-sm mb-1 font-medium">Total Earnings</p>
                                    <h3 class="text-4xl lg:text-5xl font-black text-white">£1,250.00</h3>
                                </div>
                                <span class="px-3 py-1 bg-green-500 text-white text-sm font-bold rounded-lg">+12%</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                    <p class="text-white text-sm mb-1 font-medium">Referrals</p>
                                    <h4 class="text-2xl font-bold text-white">245</h4>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                    <p class="text-white text-sm mb-1 font-medium">Clicks</p>
                                    <h4 class="text-2xl font-bold text-white">1,890</h4>
                                </div>
                                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 col-span-2">
                                    <p class="text-white text-sm mb-1 font-medium">Conversion Rate</p>
                                    <h4 class="text-2xl font-bold text-white">13%</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="py-16 lg:py-24 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-primary mb-4">Frequently Asked Questions
                    </h2>
                    <p class="text-lg text-gray-600">Find quick answers to common questions</p>
                </div>

                <div class="space-y-4" x-data="{ open: 1 }">
                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200">
                        <button @click="open = open === 1 ? null : 1"
                            class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                            <span class="font-bold text-primary text-lg">How do I create an account?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 1 }"></i>
                        </button>
                        <div x-show="open === 1" x-collapse class="px-6 pb-5 text-gray-600">
                            Click "Sign Up" in the top right corner, choose your account type (User, Agent, Agency, or
                            Affiliate), fill in your details, and verify your email address.
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200">
                        <button @click="open = open === 2 ? null : 2"
                            class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                            <span class="font-bold text-primary text-lg">Is PropertyFinda free to use?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 2 }"></i>
                        </button>
                        <div x-show="open === 2" x-collapse class="px-6 pb-5 text-gray-600">
                            Yes! Browsing properties, saving favorites, and contacting agents is completely free for regular
                            users. Agents and agencies may have subscription plans for premium features.
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200">
                        <button @click="open = open === 3 ? null : 3"
                            class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                            <span class="font-bold text-primary text-lg">How do off-market listings work?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 3 }"></i>
                        </button>
                        <div x-show="open === 3" x-collapse class="px-6 pb-5 text-gray-600">
                            Off-market listings are exclusive properties not advertised publicly. They're available only to
                            verified users and often represent below-market-value investment opportunities.
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200">
                        <button @click="open = open === 4 ? null : 4"
                            class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                            <span class="font-bold text-primary text-lg">How accurate is the property valuation tool?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 4 }"></i>
                        </button>
                        <div x-show="open === 4" x-collapse class="px-6 pb-5 text-gray-600">
                            Our valuation tool uses real-time market data, comparable sales, and local trends to provide
                            estimates. While highly accurate, we recommend getting a professional valuation for final
                            decisions.
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-200">
                        <button @click="open = open === 5 ? null : 5"
                            class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                            <span class="font-bold text-primary text-lg">How do I earn money as an affiliate?</span>
                            <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': open === 5 }"></i>
                        </button>
                        <div x-show="open === 5" x-collapse class="px-6 pb-5 text-gray-600">
                            Sign up for our affiliate program, get your unique referral link, share it on your website or
                            social media, and earn commissions when people sign up or list properties through your link.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-16 lg:py-24 bg-gradient-to-br from-primary via-primary-light to-secondary text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div
                    class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-4xl mx-auto mb-6">
                    <i class="fas fa-headset"></i>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl text-black mb-4">Still Need Help?</h2>
                <p class="text-lg text-black mb-8 max-w-2xl mx-auto" style="color:black">Our support team is here to help
                    you with any
                    questions or issues you may have</p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact.create') }}"
                        class="inline-block bg-white text-primary font-bold py-4 px-8 rounded-xl hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-envelope mr-2"></i> Contact Support
                    </a>
                    <a href="mailto:support@propertyfinda.co.uk"
                        class="inline-block bg-white text-primary font-bold py-4 px-8 rounded-xl hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i> Email Us
                    </a>
                </div>
            </div>
        </section>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-pill {
            background: #f3f4f6;
            color: #1f2937;
        }

        .nav-pill:hover {
            background: #131B31;
            color: white;
        }
    </style>

    <script>
        // Search functionality
        document.getElementById('helpSearch').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const sections = document.querySelectorAll('section[id]');

            sections.forEach(section => {
                const text = section.textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) {
                    const offset = 120;
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without jump
                    history.pushState(null, null, targetId);
                }
            });
        });

        // ScrollSpy
        const observerOptions = {
            root: null,
            rootMargin: '-10% 0px -80% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    document.querySelectorAll('.nav-pill').forEach(pill => {
                        pill.classList.remove('bg-primary', 'text-white');
                        if (pill.getAttribute('href') === `#${id}`) {
                            pill.classList.add('bg-primary', 'text-white');
                        }
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('section[id]').forEach((section) => {
            observer.observe(section);
        });
    </script>
@endsection