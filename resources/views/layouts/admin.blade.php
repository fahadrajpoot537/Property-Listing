<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- CKEditor 5 JS -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            /* Propertyfinda Theme Colors (Matched to User Side) */
            --brand-primary: #131B31;
            /* Deep Navy */
            --brand-secondary: #8046F1;
            /* Purple */
            --brand-accent: #FCC608;
            /* Yellow/Gold */
            --brand-light: #F8FAFC;
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f1f5f9;
        }

        /* Sidebar Styling (Dark Theme) */
        aside {
            background-color: var(--brand-primary);
            border-right: none;
        }

        .active-link {
            background: rgba(128, 70, 241, 0.15) !important;
            color: white !important;
            border-left: 4px solid var(--brand-secondary);
        }

        /* Hover effects for sidebar links */
        nav a:hover:not(.active-link) {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Glass Header */
        .glass-header {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 30;
        }

        /* Buttons */
        .btn-brand {
            background-color: var(--brand-secondary);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-brand:hover {
            background-color: #6D28D9;
            /* Darker Purple */
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(128, 70, 241, 0.3);
        }

        /* Card Styling */
        main .bg-white {
            border-radius: 1.25rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        /* Table enhancements */
        table.dataTable {
            border-collapse: separate;
            border-spacing: 0;
        }

        table.dataTable thead th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 1rem !important;
        }

        table.dataTable tbody td {
            padding: 1rem !important;
            border-bottom: 1px solid #f1f5f9;
        }

        table.dataTable tbody tr:hover {
            background-color: rgba(128, 70, 241, 0.03) !important;
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length select {
            border-radius: 0.5rem;
            border-color: #e2e8f0;
            padding: 0.5rem 2rem 0.5rem 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 2rem;
            border-color: #e2e8f0;
            padding: 0.5rem 1.5rem;
            margin-left: 0.75rem;
            background: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        /* Google Maps Autocomplete Suggestion Box */
        .pac-container {
            border-radius: 1rem !important;
            border: none !important;
            margin-top: 8px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            font-family: 'Inter', sans-serif !important;
            padding: 10px !important;
            background: white !important;
            z-index: 9999 !important;
        }

        .pac-item {
            padding: 12px 15px !important;
            font-size: 14px !important;
            color: #444 !important;
            border-top: 1px solid #f8f8f8 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
        }

        .pac-item:hover {
            background: #f0fdf9 !important;
            color: var(--brand-primary) !important;
            border-radius: 0.5rem !important;
        }

        .pac-matched {
            color: var(--brand-primary) !important;
        }

        .pac-icon {
            display: none !important;
        }

        /* General Premium Curves */
        .rounded-premium {
            border-radius: 1.5rem;
        }

        .shadow-premium {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        /* Nav Icon Colors */
        .nav-icon {
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s;
        }

        .active-link .nav-icon {
            color: var(--brand-secondary);
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden" x-cloak></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#131B31] text-white transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 flex-shrink-0 flex flex-col h-screen lg:sticky lg:top-0">
            <div class="h-20 flex items-center justify-between px-6 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('logoor.png') }}" alt="FindaAdmin" class="h-8 w-auto">
                </a>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1 px-3">
                <!-- Core Panel -->
                <div class="mb-6">
                    <p class="px-4 text-[10px] font-black text-white/30 uppercase tracking-[0.2em] mb-3">Core Engine
                    </p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                        <i class='bx bxs-dashboard mr-3 text-xl nav-icon'></i>
                        <span class="text-[11px] uppercase tracking-widest">Overview</span>
                    </a>
                    <a href="{{ route('admin.profile.edit') }}"
                        class="flex items-center px-4 py-3 rounded-xl text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('admin.profile.edit') ? 'active-link' : '' }}">
                        <i class='bx bxs-user-circle mr-3 text-xl nav-icon'></i>
                        <span class="text-[11px] uppercase tracking-widest">My Profile</span>
                    </a>
                </div>

                @if(auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A', 'Agency']))
                    <!-- Access Management -->
                    <div class="mb-2"
                        x-data="{ open: {{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.affiliates.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                            <div class="flex items-center">
                                <i class='bx bxs-user-badge mr-3 text-xl nav-icon'></i>
                                <span class="text-[10px] font-black uppercase tracking-[0.15em]">Access Control</span>
                            </div>
                            <i class='bx bx-chevron-down transition-transform duration-300 text-white/30'
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l border-white/10 pl-2">
                            @if(auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.users.*') ? 'text-white bg-white/5' : '' }}">
                                    System Users
                                </a>
                                <a href="{{ route('admin.roles.index') }}"
                                    class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.roles.*') ? 'text-white bg-white/5' : '' }}">
                                    Permissions & Roles
                                </a>
                            @elseif(auth()->user()->hasRole('Agency'))
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.users.*') ? 'text-white bg-white/5' : '' }}">
                                    Team Management
                                </a>
                            @endif
                            <a href="{{ route('admin.affiliates.index') }}"
                                class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.affiliates.*') ? 'text-white bg-white/5' : '' }}">
                                Partner Network
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Asset Setup -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.property-types.*', 'admin.unit-types.*', 'admin.features.*', 'admin.property-locations.*', 'admin.mortgage-settings.*', 'admin.ownership-statuses.*', 'admin.rent-frequencies.*', 'admin.cheques.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-cog mr-3 text-xl nav-icon'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Asset Setup</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300 text-white/30'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l border-white/10 pl-2">
                        <a href="{{ route('admin.property-types.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.property-types.*') ? 'text-white bg-white/5' : '' }}">
                            Property Categories
                        </a>
                        <a href="{{ route('admin.mortgage-settings.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.mortgage-settings.*') ? 'text-white bg-white/5' : '' }}">
                            Mortgage Setup
                        </a>
                        <a href="{{ route('admin.unit-types.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.unit-types.*') ? 'text-white bg-white/5' : '' }}">
                            Unit Definitions
                        </a>
                        <a href="{{ route('admin.ownership-statuses.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.ownership-statuses.*') ? 'text-white bg-white/5' : '' }}">
                            Ownership Status
                        </a>
                        <a href="{{ route('admin.rent-frequencies.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.rent-frequencies.*') ? 'text-white bg-white/5' : '' }}">
                            Rent Frequencies
                        </a>
                        <a href="{{ route('admin.cheques.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.cheques.*') ? 'text-white bg-white/5' : '' }}">
                            Cheque Definitions
                        </a>
                        <a href="{{ route('admin.features.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.features.*') ? 'text-white bg-white/5' : '' }}">
                            Amenity Tags
                        </a>
                        <a href="{{ route('admin.property-locations.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.property-locations.*') ? 'text-white bg-white/5' : '' }}">
                            Property Locations
                        </a>
                    </div>
                </div>

                <!-- Strategic Operations -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.listings.*', 'admin.off-market-listings.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-zap mr-3 text-xl nav-icon'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Operations</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300 text-white/30'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l border-white/10 pl-2">
                        <a href="{{ route('admin.listings.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ (request()->routeIs('admin.listings.*') && !request()->routeIs('admin.listings.drafts')) ? 'text-white bg-white/5' : '' }}">
                            Listings
                        </a>
                        <a href="{{ route('admin.off-market-listings.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ (request()->routeIs('admin.off-market-listings.*') && !request()->routeIs('admin.off-market-listings.drafts')) ? 'text-white bg-white/5' : '' }}">
                            Off Market Listings
                        </a>
                    </div>
                </div>

                <!-- Drafts Management -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.listings.drafts', 'admin.off-market-listings.drafts') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-edit-alt mr-3 text-xl nav-icon'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Drafts</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300 text-white/30'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l border-white/10 pl-2">
                        <a href="{{ route('admin.listings.drafts') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.listings.drafts') ? 'text-white bg-white/5' : '' }}">
                            Draft Listings
                        </a>
                        <a href="{{ route('admin.off-market-listings.drafts') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.off-market-listings.drafts') ? 'text-white bg-white/5' : '' }}">
                            Draft Off-Market
                        </a>
                    </div>
                </div>

                <!-- Content Management -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.blogs.*', 'admin.services.*', 'admin.contact.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-book-content mr-3 text-xl nav-icon'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Content Hub</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300 text-white/30'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l border-white/10 pl-2">
                        <a href="{{ route('admin.blogs.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.blogs.*') ? 'text-white bg-white/5' : '' }}">
                            Blog Articles
                        </a>
                        <a href="{{ route('admin.services.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.services.*') ? 'text-white bg-white/5' : '' }}">
                            Service Catalog
                        </a>
                        <a href="{{ route('admin.contact.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.contact.*') ? 'text-white bg-white/5' : '' }}">
                            Contact Messages
                        </a>
                        <a href="{{ route('admin.email-templates.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-white/40 hover:text-white transition-all {{ request()->routeIs('admin.email-templates.*') ? 'text-white bg-white/5' : '' }}">
                            Email Templates
                        </a>
                    </div>
                </div>

                @if(!auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
                    <!-- Partner System -->
                    <div class="mb-4">
                        <p class="px-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Growth &
                            Rewards</p>
                        <a href="{{ route('affiliate.dashboard') }}"
                            class="flex items-center px-4 py-3 rounded-2xl text-slate-600 font-bold hover:bg-slate-50 transition-all duration-300 {{ request()->routeIs('affiliate.*') ? 'active-link !text-white' : '' }}">
                            <i class='bx bxs-award mr-3 text-xl'></i>
                            <span class="text-xs uppercase tracking-widest">Partner Program</span>
                        </a>
                    </div>
                @endif
            </nav>

            <div class="p-4 border-t border-white/5 bg-black/20">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-lg bg-[#8046F1] flex items-center justify-center text-xs font-black text-white shadow-lg shadow-purple-500/20">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] font-black text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] text-white/40 font-bold uppercase truncate">
                            {{ Auth::user()->roles->first()->name ?? 'Admin' }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white/30 hover:text-rose-500 transition-colors">
                            <i class='bx bx-log-out-circle text-lg'></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar -->
            <header class="glass-header h-16 flex justify-between items-center px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <!-- Mobile Menu Toggle -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 active:scale-95 transition-all">
                        <i class='bx bx-menu-alt-left text-2xl'></i>
                    </button>

                    <h2 class="font-bold text-lg lg:text-xl text-slate-800 leading-tight truncate">
                        @yield('header')
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route(name: 'home') }}"
                        class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors flex items-center gap-1">
                        <i class='bx bx-link-external'></i> View Site
                    </a>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-md shadow-sm mb-6 flex items-start"
                            role="alert">
                            <i class='bx bxs-check-circle text-xl mr-2'></i>
                            <div>
                                <p class="font-bold">Success</p>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-md shadow-sm mb-6"
                            role="alert">
                            <div class="flex items-start">
                                <i class='bx bxs-error-circle text-xl mr-2'></i>
                                <div>
                                    <p class="font-bold">Error</p>
                                    <ul class="list-disc list-inside text-sm mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>