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
            /* Propertyfinda Theme Colors */
            --brand-primary: #1CD494;
            /* Teal Green */
            --brand-secondary: #073B3A;
            /* Dark Green */
            --brand-accent: #FCC608;
            /* Yellow/Gold */
            --brand-dark: #2E2E2E;
            /* Dark Grey */

            --brand-blue: var(--brand-primary);
            /* Map to primary for existing classes */
            --brand-orange: var(--brand-accent);
            /* Map to accent for existing classes */
        }

        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f8f9fa;
        }

        /* Override Selection Color */
        ::selection {
            background: var(--brand-primary);
            color: #fff;
        }

        /* Sidebar Styling */
        aside {
            background-color: #fff;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Sidebar Scrollbar Hide */
        aside::-webkit-scrollbar,
        nav::-webkit-scrollbar {
            display: none;
        }

        aside,
        nav {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .active-link {
            background: linear-gradient(135deg, var(--brand-primary) 0%, #15a875 100%) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(28, 212, 148, 0.3) !important;
        }

        /* Hover effects for sidebar links */
        nav a:hover:not(.active-link) {
            color: var(--brand-primary);
            background-color: rgba(28, 212, 148, 0.05);
        }

        /* Glass Header */
        .glass-header {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 30;
        }

        /* Buttons */
        .btn-brand {
            background-color: var(--brand-primary);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-brand:hover {
            background-color: #15a875;
            /* Darker shade of teal */
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(28, 212, 148, 0.3);
        }

        .btn-accent {
            background-color: var(--brand-dark);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-accent:hover {
            background-color: black;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Card Styling to look more premium */
        main .bg-white {
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.03);
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
            background-color: #f0fdf9 !important;
            /* Very light teal bg on hover */
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

        /* Badge Colors mapping */
        .text-\[\#02b8f2\] {
            color: var(--brand-primary) !important;
        }

        .hover\:text-\[\#02b8f2\]:hover {
            color: var(--brand-primary) !important;
        }

        .bg-blue-50\/50 {
            background-color: rgba(28, 212, 148, 0.08) !important;
        }

        .text-\[\#ff931e\] {
            color: var(--brand-dark) !important;
        }

        .hover\:text-\[\#ff931e\]:hover {
            color: var(--brand-dark) !important;
        }

        .bg-orange-50\/50 {
            background-color: rgba(46, 46, 46, 0.05) !important;
        }

        /* General Premium Curves */
        .rounded-premium {
            border-radius: 1.5rem;
        }

        .shadow-premium {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside
            class="w-64 bg-white text-black flex-shrink-0 flex flex-col h-screen sticky top-0 transition-all duration-300 z-20 border-r border-slate-100">
            <div class="h-20 flex items-center px-6 border-b border-slate-50">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center w-full">
                    <img src="{{ asset('logo.png') }}" class="h-12 w-auto object-contain" alt="Finda-UK Logo">
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-2 px-4">
                <!-- Core Panel -->
                <div class="mb-4">
                    <p class="px-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Core Engine
                    </p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-2xl text-slate-600 font-bold hover:bg-slate-50 transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active-link !text-white' : '' }}">
                        <i class='bx bxs-dashboard mr-3 text-xl'></i>
                        <span class="text-xs uppercase tracking-widest">Overview</span>
                    </a>
                </div>

                <!-- Access Management -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.affiliates.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-slate-400 hover:text-black hover:bg-slate-50 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-user-badge mr-3 text-xl'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Access Control</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l-2 border-slate-50 pl-2">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#02b8f2] transition-all {{ request()->routeIs('admin.users.*') ? 'text-[#02b8f2] bg-blue-50/50' : '' }}">
                            System Users
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#02b8f2] transition-all {{ request()->routeIs('admin.roles.*') ? 'text-[#02b8f2] bg-blue-50/50' : '' }}">
                            Permissions & Roles
                        </a>
                        <a href="{{ route('admin.affiliates.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#02b8f2] transition-all {{ request()->routeIs('admin.affiliates.*') ? 'text-[#02b8f2] bg-blue-50/50' : '' }}">
                            Affiliates Node
                        </a>
                    </div>
                </div>

                <!-- Asset Setup -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.property-types.*', 'admin.unit-types.*', 'admin.features.*', 'admin.property-locations.*', 'admin.mortgage-settings.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-slate-400 hover:text-black hover:bg-slate-50 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-cog mr-3 text-xl'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Asset Setup</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l-2 border-slate-50 pl-2">
                        <a href="{{ route('admin.property-types.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.property-types.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Property Categories
                        </a>
                        <a href="{{ route('admin.mortgage-settings.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.mortgage-settings.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Mortgage Setup
                        </a>
                        <a href="{{ route('admin.unit-types.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.unit-types.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Unit Definitions
                        </a>
                        <a href="{{ route('admin.ownership-statuses.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.ownership-statuses.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Ownership Status
                        </a>
                        <a href="{{ route('admin.rent-frequencies.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.rent-frequencies.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Rent Frequencies
                        </a>
                        <a href="{{ route('admin.cheques.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.cheques.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Cheque Definitions
                        </a>
                        <a href="{{ route('admin.features.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.features.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Amenity Tags
                        </a>
                        <a href="{{ route('admin.property-locations.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.property-locations.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Property Locations
                        </a>
                    </div>
                </div>

                <!-- Strategic Operations -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.listings.*', 'admin.off-market-listings.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-slate-400 hover:text-black hover:bg-slate-50 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-zap mr-3 text-xl'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Operations</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l-2 border-slate-50 pl-2">
                        <a href="{{ route('admin.listings.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#02b8f2] transition-all {{ request()->routeIs('admin.listings.*') ? 'text-[#02b8f2] bg-blue-50/50' : '' }}">
                            Public Asset Pool
                        </a>
                        <a href="{{ route('admin.off-market-listings.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.off-market-listings.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Confidential Deals
                        </a>
                    </div>
                </div>

                <!-- Content Management -->
                <div class="mb-2"
                    x-data="{ open: {{ request()->routeIs('admin.blogs.*', 'admin.services.*', 'admin.contact.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-slate-400 hover:text-black hover:bg-slate-50 transition-all duration-300">
                        <div class="flex items-center">
                            <i class='bx bxs-book-content mr-3 text-xl'></i>
                            <span class="text-[10px] font-black uppercase tracking-[0.15em]">Content</span>
                        </div>
                        <i class='bx bx-chevron-down transition-transform duration-300'
                            :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 ml-4 border-l-2 border-slate-50 pl-2">
                        <a href="{{ route('admin.blogs.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#02b8f2] transition-all {{ request()->routeIs('admin.blogs.*') ? 'text-[#02b8f2] bg-blue-50/50' : '' }}">
                            Blog Articles
                        </a>
                        <a href="{{ route('admin.services.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#ff931e] transition-all {{ request()->routeIs('admin.services.*') ? 'text-[#ff931e] bg-orange-50/50' : '' }}">
                            Service Catalog
                        </a>
                        <a href="{{ route('admin.contact.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-xl text-[11px] font-bold text-slate-500 hover:text-[#02b8f2] transition-all {{ request()->routeIs('admin.contact.*') ? 'text-[#02b8f2] bg-blue-50/50' : '' }}">
                            Contact Messages
                        </a>
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-black/10 border border-black/20 flex items-center justify-center text-sm font-black text-black">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-black text-black truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-black/50 font-bold uppercase truncate">
                            {{ Auth::user()->roles->first()->name ?? 'Admin' }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar -->
            <header class="glass-header h-16 flex justify-between items-center px-6">
                <div class="flex items-center">
                    <h2 class="font-bold text-xl text-slate-800 leading-tight">
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