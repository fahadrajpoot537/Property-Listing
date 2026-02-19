<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PropertyFinda - Premium Property Listings')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles Stack -->
    @stack('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white text-gray-900">

    <!-- Top Bar -->
    <div style="background-color: #1F98AD;" class="py-2.5 border-b border-primary/20 relative z-[60]">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4 text-sm font-medium text-white/90">
                <a href="mailto:info@propertyfinda.co.uk"
                    class="text-white transition-colors flex items-center gap-2"><i
                        class="fa-solid fa-envelope text-white text-sm"></i> info@propertyfinda.co.uk</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://www.facebook.com/profile.php?id=61587630383066" target="_blank"
                    class="bg-white w-8 h-8 flex items-center justify-center rounded-full shadow-sm hover:scale-110 transition-transform">
                    <i class="fa-brands fa-facebook-f text-sm" style="color: #1877F2;"></i>
                </a>
                <a href="#"
                    class="bg-white w-8 h-8 flex items-center justify-center rounded-full shadow-sm hover:scale-110 transition-transform">
                    <i class="fa-brands fa-instagram text-sm" style="color: #E4405F;"></i>
                </a>

                <a href="#"
                    class="bg-white w-8 h-8 flex items-center justify-center rounded-full shadow-sm hover:scale-110 transition-transform">
                    <i class="fa-brands fa-linkedin-in text-sm" style="color: #0A66C2;"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sticky top-0 w-full z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm"
        id="navbar" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 group">
                        <div class="flex items-center gap-2">
                            <!-- Icon inspired by the modern logo concept -->
                            <img src="{{ asset('logoor.png') }}" alt="PropertyFinda" class="h-10 w-auto">
                        </div>
                    </a>
                    <div class="hidden md:ml-10 md:flex space-x-8">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out">Home</a>
                        <!-- Properties Dropdown -->
                        <a href="{{ route('listings.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('listings.index') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out">Properties</a>
                        <a href="{{ route('sold-properties.search') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('sold-properties.search') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out">Sold
                            Properties</a>
                        <a href="{{ route('off-market-listings.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('off-market-listings.index') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out">Off
                            Market</a>
                        <a href="{{ route('agents.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('agents.*') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out">Agents</a>
                        <a href="{{ route('blog.list') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('blog.*') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out">News</a>

                        <!-- Contact Dropdown -->
                        <div class="relative flex items-center h-20" x-data="{ open: false }" @mouseenter="open = true"
                            @mouseleave="open = false">
                            <button @click="open = !open"
                                class="inline-flex items-center gap-1 px-1 pt-1 border-b-2 {{ request()->routeIs('help') || request()->routeIs('contact.create') ? 'border-secondary text-primary' : 'border-transparent text-gray-500' }} text-sm font-medium leading-5 hover:text-primary hover:border-secondary transition duration-150 ease-in-out h-full focus:outline-none">
                                Support
                                <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-1/2 -translate-x-1/2 top-full mt-14 w-64 bg-white rounded-2xl shadow-xl shadow-primary/10 border border-gray-100 py-2 z-50"
                                style="margin-top:230%">

                                <div
                                    class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 bg-white transform rotate-45 border-t border-l border-gray-100">
                                </div>

                                <a href="{{ route('contact.create') }}"
                                    class="relative flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                                    <i class="fa-solid fa-envelope text-secondary w-5"></i>
                                    Contact Us
                                </a>
                                <a href="{{ route('help') }}"
                                    class="relative flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                                    <i class="fa-solid fa-circle-question text-secondary w-5"></i>
                                    Help Center
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-4">
                        @auth
                            <div class="relative" x-data="{ userDropdownOpen: false }">
                                <button @click="userDropdownOpen = !userDropdownOpen" @click.away="userDropdownOpen = false"
                                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-all duration-200">
                                    <div
                                        class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                                        <i class="fa-solid fa-user-circle text-xl"></i>
                                    </div>
                                    <div class="hidden lg:block text-left">
                                        <p
                                            class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">
                                            Signed in as</p>
                                        <p class="text-sm font-black text-primary leading-none">{{ Auth::user()->name }}</p>
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 transition-transform duration-200"
                                        :class="userDropdownOpen ? 'rotate-180' : ''"></i>
                                </button>

                                <div x-show="userDropdownOpen" x-cloak x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl shadow-primary/10 border border-gray-100 py-2 z-50">

                                    <a href="{{ route('dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-600 hover:text-primary hover:bg-gray-50 transition-all">
                                        <i class="fa-solid fa-gauge-high text-gray-400 w-5"></i>
                                        Dashboard
                                    </a>

                                    <a href="{{ route('favorites.index') }}"
                                        class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-gray-600 hover:text-secondary hover:bg-gray-50 transition-all">
                                        <i class="fa-solid fa-heart text-gray-400 w-5"></i>
                                        My Favorites
                                    </a>

                                    <hr class="my-1 border-gray-100">

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-rose-500 hover:bg-rose-50 transition-all">
                                            <i class="fa-solid fa-right-from-bracket w-5"></i>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-500 hover:text-primary transition">Log in</a>
                            <a href="{{ route('register') }}"
                                class="bg-primary hover:bg-primary-light text-white px-5 py-2.5 rounded-full text-sm font-medium transition duration-200 shadow-lg shadow-primary/20 hover:shadow-primary/30 transform hover:-translate-y-0.5">Sign
                                up</a>
                        @endauth
                    </div>
                    <div class="-mr-2 flex items-center md:hidden">
                        <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            @click="mobileMenuOpen = !mobileMenuOpen">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden bg-white/95 backdrop-blur-md border-b border-gray-100 absolute w-full shadow-lg"
            id="mobile-menu" style="display: none;">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('home') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Home</a>
                <a href="{{ route('listings.index') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('listings.index') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Properties</a>
                <a href="{{ route('sold-properties.search') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('sold-properties.search') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Sold
                    Properties</a>
                <a href="{{ route('off-market-listings.index') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('off-market-listings.index') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Off
                    Market</a>
                <a href="{{ route('agents.index') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('agents.*') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Agents</a>
                <a href="{{ route('blog.list') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('blog.list') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">News</a>
                <a href="{{ route('contact.create') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('contact.create') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Contact
                    Us</a>
                <a href="{{ route('help') }}"
                    class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium {{ request()->routeIs('help') ? 'text-primary bg-gray-50 border-secondary' : 'text-gray-600 border-transparent' }} hover:text-primary hover:bg-gray-50 transition duration-150 ease-in-out border-l-4">Help
                    Center (A-Z)</a>
                {{-- Removed from primary mobile menu as it goes into bottom section --}}
            </div>
            <div class="pt-4 pb-6 border-t border-gray-200 px-4">
                @auth
                    <div class="flex items-center px-4 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary">
                            <i class="fa-solid fa-user-circle text-2xl"></i>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-black text-primary">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-3 rounded-xl text-base font-bold text-gray-600 hover:bg-gray-50">
                            <i class="fa-solid fa-gauge-high mr-2 text-gray-400"></i>Dashboard
                        </a>
                        <a href="{{ route('favorites.index') }}"
                            class="block px-4 py-3 rounded-xl text-base font-bold text-gray-600 hover:bg-gray-50">
                            <i class="fa-solid fa-heart mr-2 text-gray-400"></i>My Favorites
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 rounded-xl text-base font-bold text-rose-500 hover:bg-rose-50">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>Sign Out
                            </button>
                        </form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}"
                            class="w-full flex items-center justify-center px-4 py-3 rounded-xl border border-gray-200 text-base font-bold text-gray-600">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="w-full flex items-center justify-center px-4 py-3 rounded-xl bg-primary text-white text-base font-bold">Sign
                            up</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-dark pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <!-- Icon -->
                        <img src="{{ asset('logoor.png') }}" alt="PropertyFinda" class="h-14 w-auto">
                    </div>
                    <p class="text-dark text-sm leading-relaxed mb-6">
                        Reimagining the property market with a premium, transparent, and seamless experience. Find your
                        dream home today.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="https://www.facebook.com/profile.php?id=61587630383066" target="_blank"
                            class="bg-white w-10 h-10 flex items-center justify-center rounded-full shadow-lg hover:-translate-y-1 transition-all">
                            <i class="fa-brands fa-facebook-f text-lg" style="color: #1877F2;"></i>
                        </a>
                        <a href="#"
                            class="bg-white w-10 h-10 flex items-center justify-center rounded-full shadow-lg hover:-translate-y-1 transition-all">
                            <i class="fa-brands fa-instagram text-lg" style="color: #E4405F;"></i>
                        </a>
                        <a href="#"
                            class="bg-white w-10 h-10 flex items-center justify-center rounded-full shadow-lg hover:-translate-y-1 transition-all">
                            <i class="fa-brands fa-linkedin-in text-lg" style="color: #1DA1F2;"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-serif font-semibold mb-6 flex items-center">Quick Links <span
                            class="h-px w-8 bg-secondary ml-3 text-black block"></span></h3>
                    <ul class="space-y-3 text-sm text-black">
                        <li><a href="{{ route('home') }}" class="hover:text-black transition duration-200">Home</a>
                        </li>
                        <li><a href="{{ route('listings.index') }}"
                                class="hover:text-black transition duration-200">Browse Properties</a></li>
                        <li><a href="{{ route('off-market-listings.index') }}"
                                class="hover:text-black transition duration-200">Off Market</a></li>
                        <li><a href="{{ route('contact.create') }}"
                                class="hover:text-black transition duration-200">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-serif font-semibold mb-6 flex items-center">Legal <span
                            class="h-px w-8 bg-secondary ml-3 text-black block"></span></h3>
                    <ul class="space-y-3 text-sm text-black">
                        <li><a href="{{ route('privacy') }}" class="hover:text-black transition duration-200">Privacy
                                Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-black transition duration-200">Terms of
                                Service</a></li>
                        <li><a href="{{ route('cookies') }}" class="hover:text-black transition duration-200">Cookie
                                Policy</a></li>
                        <li><a href="{{ route('gdpr') }}" class="hover:text-black transition duration-200">GDPR
                                Compliance</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-serif font-semibold mb-6 flex items-center">Contact <span
                            class="h-px w-8 bg-secondary ml-3 text-black block"></span></h3>
                    <ul class="space-y-4 text-sm text-gray-300">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-black mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                            <span class="text-black">5-7 High Street London United Kingdom. E13 0AD</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <a href="mailto:info@propertyfinda.co.uk"
                                class="hover:text-secondary transition text-black">info@propertyfinda.co.uk</a>
                        </li>

                    </ul>
                </div>
            </div>
            <div
                class="border-t border-primary-light pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} PropertyFinda. All Rights Reserved.</p>
                <p>Designed with <span class="text-secondary">&hearts;</span> by <a href="https://mediajunkie.co.uk"
                        target="_blank">Media Junkie</a></p>
            </div>
        </div>
    </footer>

    <!-- Google Maps API with Places Library -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places,drawing,geometry"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Google Places Autocomplete
            const locationInput = document.getElementById('search-location');
            if (locationInput && typeof google !== 'undefined') {
                const autocomplete = new google.maps.places.Autocomplete(locationInput, {
                    types: ['geocode'],
                    componentRestrictions: { country: 'uk' }
                });
            }
        });
    </script>

    @stack('modals')
    @stack('scripts')
</body>

</html>