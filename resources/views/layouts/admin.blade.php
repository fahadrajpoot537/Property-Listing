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
    <style>
        .select2-container--default .select2-selection--single {
            border-color: #e2e8f0;
            border-radius: 0.5rem;
            height: 42px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .select2 {
            width: 100% !important;
        }
    </style>

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
            background-color: #f8fafc;
            /* Lighter background for minimal feel */
            height: 100vh;
            overflow: hidden;
            font-size: 13px;
            /* Slightly smaller base font */
        }

        /* Effra Font Fallback */
        .font-effra {
            font-family: 'Effra', 'Outfit', sans-serif !important;
        }

        /* CKEditor Heading Visibility & Content Styling */
        .ck-content h2,
        .ck-editor__editable h2 {
            font-size: 1.875rem !important;
            font-weight: 800 !important;
            margin-top: 2rem !important;
            margin-bottom: 1rem !important;
            color: #1a202c !important;
            display: block !important;
            line-height: 1.25 !important;
            border-bottom: 2px solid #edf2f7 !important;
            padding-bottom: 0.5rem !important;
        }

        .ck-content h3,
        .ck-editor__editable h3 {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            margin-top: 1.5rem !important;
            margin-bottom: 0.75rem !important;
            color: #2d3748 !important;
            display: block !important;
            line-height: 1.3 !important;
        }

        .ck-content h4,
        .ck-editor__editable h4 {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
            margin-top: 1.25rem !important;
            margin-bottom: 0.5rem !important;
            color: #4a5568 !important;
            display: block !important;
            line-height: 1.4 !important;
        }

        .ck-content p,
        .ck-editor__editable p {
            margin-bottom: 1.25rem !important;
            line-height: 1.7 !important;
            color: #4a5568 !important;
        }

        .ck-content ul,
        .ck-editor__editable ul {
            list-style-type: disc !important;
            margin-left: 1.5rem !important;
            margin-bottom: 1.25rem !important;
        }

        .ck-content ol,
        .ck-editor__editable ol {
            list-style-type: decimal !important;
            margin-left: 1.5rem !important;
            margin-bottom: 1.25rem !important;
        }

        /* Ensure the editor has a comfortable minimum height */
        .ck-editor__editable {
            min-height: 300px !important;
            background: white !important;
        }

        /* Sidebar Styling (Dark Theme) */
        aside {
            background-color: var(--brand-primary);
            border-right: none;
        }

        aside nav a,
        aside nav button {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }

        aside nav a:hover,
        aside nav button:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        aside nav span {
            font-size: 11px !important;
        }

        .active-link {
            background: rgba(128, 70, 241, 0.1) !important;
            color: white !important;
            border-left: 3px solid var(--brand-secondary);
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

        /* Card Styling - More Minimal */
        main .bg-white {
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            /* Softer shadow */
            border: 1px solid #eef2f6;
        }

        /* Table enhancements */
        table.dataTable {
            border-collapse: separate;
            border-spacing: 0;
        }

        table.dataTable thead th {
            background-color: #f1f5f9;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            /* Small text for headers */
            letter-spacing: 0.1em;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 0.75rem 1rem !important;
        }

        table.dataTable tbody td {
            padding: 0.75rem 1rem !important;
            border-bottom: 1px solid #f8fafc;
            font-size: 13px;
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
        .active-link .nav-icon {
            color: var(--brand-secondary);
        }
    </style>
    @stack('styles')
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
            <div class="h-16 flex items-center justify-between px-5 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('logoor.png') }}" alt="FindaAdmin" class="h-6 w-auto">
                </a>

                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white transition-colors">
                    <i class='bx bx-x text-xl'></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 space-y-0.5 px-2">
                <!-- Core Panel -->
                <div class="mb-4">
                    <p class="px-3 text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2">Core Panel
                    </p>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                        <i class='bx bxs-pie-chart-alt-2 mr-3 text-lg nav-icon'></i>
                        <span class="text-[12px] uppercase tracking-widest">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.profile.edit') }}"
                        class="flex items-center px-3 py-2 rounded-lg text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('admin.profile.edit') ? 'active-link' : '' }}">
                        <i class='bx bxs-user-circle mr-3 text-lg nav-icon'></i>
                        <span class="text-[12px] uppercase tracking-widest">Profile</span>
                    </a>
                </div>
                @canany(['listing.view', 'listing.create', 'off-market.view'])
                    <div class="mb-4">
                        <p class="px-3 text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2">Live Trading
                        </p>
                        @can('listing.view')
                            <a href="{{ route('admin.listings.index') }}"
                                class="flex items-center px-3 py-2 rounded-lg text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ (request()->routeIs('admin.listings.*') && !request()->routeIs('admin.listings.create') && !request()->routeIs('admin.listings.drafts')) ? 'active-link' : '' }}">
                                <i class='bx bx-list-ul mr-3 text-lg nav-icon'></i>
                                <span class="text-[12px] uppercase tracking-widest">Listings</span>
                            </a>
                        @endcan
                        @can('off-market.view')
                            <a href="{{ route('admin.off-market-listings.index') }}"
                                class="flex items-center px-3 py-2 rounded-lg text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ (request()->routeIs('admin.off-market-listings.*') && !request()->routeIs('admin.off-market-listings.drafts')) ? 'active-link' : '' }}">
                                <i class='bx bx-hide mr-3 text-lg nav-icon'></i>
                                <span class="text-[12px] uppercase tracking-widest">Off Market Listings</span>
                            </a>
                        @endcan
                        <a href="{{ route('admin.walkthrough.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg text-white/70 font-bold hover:bg-white/5 transition-all duration-300 {{ request()->routeIs('admin.walkthrough.*') ? 'active-link' : '' }}">
                            <i class='bx bx-message-detail mr-3 text-lg nav-icon'></i>
                            <span class="text-[12px] uppercase tracking-widest">enquiries</span>
                        </a>
                    </div>
                @endcanany
                <!-- Access Management -->
                @if(auth()->user()->hasAnyRole(['admin', 'Agency']) || auth()->user()->canAny(['role.view', 'partner.view']))
                    <div class="mb-2"
                        x-data="{ open: {{ request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.affiliates.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                            <div class="flex items-center">
                                <i class='bx bxs-user-badge mr-3 text-lg nav-icon'></i>
                                <span class="text-[11px] font-black uppercase tracking-[0.1em]">Access Management</span>
                            </div>
                            <i class='bx bx-chevron-down transition-transform duration-300 text-white/20'
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak class="mt-0.5 space-y-0.5 ml-3 border-l border-white/5 pl-2">
                            @if(auth()->user()->hasAnyRole(['admin', 'Agency']))
                                <a href="{{ route('admin.users.index') }}"
                                    class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.users.*') ? 'text-white bg-white/5' : '' }}">
                                    Users
                                </a>
                            @endif
                            @can('role.view')
                                <a href="{{ route('admin.roles.index') }}"
                                    class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.roles.*') ? 'text-white bg-white/5' : '' }}">
                                    Roles
                                </a>
                            @endcan
                            @can('partner.view')
                                <a href="{{ route('admin.affiliates.index') }}"
                                    class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.affiliates.*') ? 'text-white bg-white/5' : '' }}">
                                    Partners
                                </a>
                            @endcan
                        </div>
                    </div>
                @endif

                <!-- Asset Configuration -->
                @can('asset.manage')
                    <div class="mb-1"
                        x-data="{ open: {{ request()->routeIs('admin.property-types.*', 'admin.unit-types.*', 'admin.features.*', 'admin.property-locations.*', 'admin.mortgage-settings.*', 'admin.ownership-statuses.*', 'admin.rent-frequencies.*', 'admin.cheques.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                            <div class="flex items-center">
                                <i class='bx bxs-box mr-3 text-lg nav-icon'></i>
                                <span class="text-[11px] font-black uppercase tracking-[0.1em]">Asset Data</span>
                            </div>
                            <i class='bx bx-chevron-down transition-transform duration-300 text-white/20'
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak class="mt-0.5 space-y-0.5 ml-3 border-l border-white/5 pl-2">
                            <a href="{{ route('admin.property-types.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.property-types.*') ? 'text-white bg-white/5' : '' }}">
                                Categories
                            </a>
                            <a href="{{ route('admin.mortgage-settings.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.mortgage-settings.*') ? 'text-white bg-white/5' : '' }}">
                                Mortgages
                            </a>

                            <a href="{{ route('admin.features.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.features.*') ? 'text-white bg-white/5' : '' }}">
                                Amenities
                            </a>
                            <a href="{{ route('admin.ownership-statuses.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.ownership-statuses.*') ? 'text-white bg-white/5' : '' }}">
                                Ownership Statuses
                            </a>
                            <a href="{{ route('admin.property-locations.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.property-locations.*') ? 'text-white bg-white/5' : '' }}">
                                Property Locations
                            </a>
                        </div>
                    </div>
                @endcan

                <!-- Active Operations -->


                <!-- Pending Work -->
                @canany(['listing.create', 'listing.edit', 'off-market.create', 'off-market.edit'])
                    <div class="mb-1"
                        x-data="{ open: {{ request()->routeIs('admin.listings.drafts', 'admin.off-market-listings.drafts') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                            <div class="flex items-center">
                                <i class='bx bx-edit mr-3 text-lg nav-icon'></i>
                                <span class="text-[11px] font-black uppercase tracking-[0.1em]">Listing Drafts</span>
                            </div>
                            <i class='bx bx-chevron-down transition-transform duration-300 text-white/20'
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak class="mt-0.5 space-y-0.5 ml-3 border-l border-white/5 pl-2">
                            <a href="{{ route('admin.listings.drafts') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.listings.drafts') ? 'text-white bg-white/5' : '' }}">
                                Listing Drafts
                            </a>
                            <a href="{{ route('admin.off-market-listings.drafts') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.off-market-listings.drafts') ? 'text-white bg-white/5' : '' }}">
                                Off Market Listing Drafts
                            </a>
                        </div>
                    </div>
                @endcanany

                <!-- Marketing -->
                @canany(['blog.view', 'content.manage'])
                    <div class="mb-1"
                        x-data="{ open: {{ request()->routeIs('admin.blogs.*', 'admin.services.*', 'admin.contact.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-white/50 hover:text-white hover:bg-white/5 transition-all duration-300">
                            <div class="flex items-center">
                                <i class='bx bx-paper-plane mr-3 text-lg nav-icon'></i>
                                <span class="text-[11px] font-black uppercase tracking-[0.1em]">Engage</span>
                            </div>
                            <i class='bx bx-chevron-down transition-transform duration-300 text-white/20'
                                :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open" x-cloak class="mt-0.5 space-y-0.5 ml-3 border-l border-white/5 pl-2">
                            <a href="{{ route('admin.blogs.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.blogs.*') ? 'text-white bg-white/5' : '' }}">
                                Articles
                            </a>
                            <a href="{{ route('admin.contact.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.contact.*') ? 'text-white bg-white/5' : '' }}">
                                Contact Messages
                            </a>
                            <a href="{{ route('admin.email-templates.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.email-templates.*') ? 'text-white bg-white/5' : '' }}">
                                Email Templates
                            </a>
                            <a href="{{ route('admin.trustpilot-reviews.index') }}"
                                class="flex items-center px-3 py-1.5 rounded-lg text-[12px] font-bold text-white/60 hover:text-white transition-all {{ request()->routeIs('admin.trustpilot-reviews.*') ? 'text-white bg-white/5' : '' }}">
                                Trustpilot Reviews
                            </a>
                        </div>
                    </div>
                @endcanany

                @if(!auth()->user()->hasAnyRole(['admin', 'manager', 'listing director', 'Q/A']))
                    <!-- Partner System: Visible for everyone except Internal Staff -->
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

            <div class="p-3 border-t border-white/5">
                <div class="flex items-center gap-3 bg-white/5 p-2 rounded-xl">
                    <div
                        class="w-8 h-8 rounded-lg bg-[#8046F1] flex items-center justify-center text-[10px] font-black text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[8px] text-white/30 uppercase tracking-tighter truncate font-black">
                            {{ Auth::user()->roles->first()->name ?? 'Access Granted' }}
                        </p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white/20 hover:text-rose-400 transition-colors">
                            <i class='bx bx-power-off text-base'></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar -->
            <header class="glass-header h-16 flex justify-between items-center px-4 lg:px-6">
                <div class="flex items-center gap-2">
                    <!-- Mobile Menu Toggle -->
                    <button @click="sidebarOpen = true"
                        class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 text-slate-600 active:scale-95 transition-all">
                        <i class='bx bx-menu-alt-left text-xl'></i>
                    </button>

                    <h2 class="font-black text-sm lg:text-base text-slate-800 tracking-tight uppercase truncate">
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
                <div class="max-w-7xl mx-auto min-h-full flex flex-col">
                    @if(session('success'))
                        <div class="bg-emerald-50 border-emerald-100 text-emerald-700 p-3 rounded-lg border shadow-sm mb-4 flex items-center justify-between"
                            role="alert">
                            <div class="flex items-center text-xs font-bold">
                                <i class='bx bx-check-double text-lg mr-2'></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-rose-50 border-rose-100 text-rose-700 p-3 rounded-lg border shadow-sm mb-4"
                            role="alert">
                            <ul class="list-disc list-inside text-xs font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    @yield('content')
                    <div class="h-20"></div> <!-- Buffer space at bottom -->
                </div>
            </main>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Auto-initialize Select2 if not manually handled
            if (typeof $.fn.select2 !== 'undefined' && $('.select2').length > 0) {
                // Check if any instance is not initialized
                $('.select2').each(function () {
                    if (!$(this).data('select2')) {
                        $(this).select2({
                            width: '100%',
                            placeholder: "Select an option",
                            allowClear: true
                        });
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>