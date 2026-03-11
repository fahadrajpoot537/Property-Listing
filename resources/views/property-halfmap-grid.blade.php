@extends('layouts.modern')

@section('title', 'Property Search - PropertyFinda')

@section('content')
    <style>
        /* Property Cards (Premium Grid) */
        .property-card-results {
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .property-card-results:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
            border-color: #8046F1;
        }

        .img-container {
            position: relative;
            width: 100%;
            height: 220px;
            background: #F3F4F6;
            overflow: hidden;
            flex-shrink: 0;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .property-card-results:hover .img-container img {
            transform: scale(1.1);
        }

        .price-badge {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-weight: 900;
            color: #131B31;
            font-size: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .property-title {
            font-size: 16px;
            font-weight: 800;
            color: #131B31;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .property-addr {
            font-size: 13px;
            color: #6B7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
            font-weight: 500;
        }

        .stats-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.25rem;
            border-top: 1px solid #F3F4F6;
            margin-top: auto;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: #4B5563;
            font-size: 13px;
        }

        .stat-item i {
            color: #9CA3AF;
            font-size: 14px;
        }

        /* List View Specifics */
        .list-view-card {
            flex-direction: row !important;
            height: auto;
            min-height: 250px;
            max-height: none;
        }

        .list-view-card .img-container {
            width: 340px;
            height: auto;
            min-height: 100%;
            display: flex;
        }

        .list-view-card .card-content {
            padding: 2rem;
        }

        @media (max-width: 1024px) {
            .list-view-card .img-container {
                width: 300px;
            }
        }

        @media (max-width: 768px) {
            .list-view-card {
                flex-direction: column !important;
                max-height: none;
            }

            .list-view-card .img-container {
                width: 100%;
                height: 250px;
            }

            .list-view-card .card-content {
                padding: 1.5rem;
            }
        }

        /* Filter Tag Styling */
        .filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            border-radius: 2rem;
            border: 1px solid #E5E7EB;
            background: white;
            color: #131B31;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
        }

        .filter-tag:hover {
            border-color: #8046F1;
            background: #F5F3FF;
        }

        .filter-tag.active {
            background: #131B31;
            color: white;
            border-color: #131B31;
            box-shadow: 0 4px 12px rgba(19, 27, 49, 0.2);
        }

        .filter-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 1.5rem 0;
            border-bottom: 1px solid #F3F4F6;
        }

        .filter-section-header h4 {
            font-size: 16px;
            font-weight: 800;
            color: #131B31;
        }

        .filter-section-content {
            padding: 1.5rem 0;
        }

        /* Adjusting the Tray */
        #more-filters-tray {
            max-height: 80vh;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        #more-filters-tray::-webkit-scrollbar {
            width: 4px;
        }

        #more-filters-tray::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 10px;
        }

        /* Select2 Dark Mode Styles */
        .select2-filter-dark+.select2-container .select2-selection--single {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 0.5rem !important;
            height: 46px !important;
            color: white !important;
        }

        .select2-filter-dark+.select2-container .select2-selection__rendered {
            color: white !important;
            line-height: 46px !important;
            padding-left: 1rem !important;
            font-weight: 700 !important;
        }

        .select2-filter-dark+.select2-container .select2-selection__arrow b {
            border-color: white transparent transparent transparent !important;
        }

        .select2-filter-dark-simple+.select2-container .select2-selection--single {
            background: transparent !important;
            border: none !important;
            height: 46px !important;
            color: white !important;
        }

        .select2-filter-dark-simple+.select2-container .select2-selection__rendered {
            color: white !important;
            line-height: 46px !important;
            padding-right: 2rem !important;
            font-weight: 700 !important;
        }

        .select2-filter-dark-simple+.select2-container .select2-selection__arrow {
            right: 0 !important;
        }

        .select2-filter-dark-simple+.select2-container .select2-selection__arrow b {
            border-color: white transparent transparent transparent !important;
        }

        /* Dropdown Options Styling */
        .select2-dark-dropdown {
            background-color: #131B31 !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
        }

        .select2-dark-dropdown .select2-results__option {
            background-color: transparent !important;
            color: #e5e7eb !important;
            padding: 10px 16px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease;
        }

        .select2-dark-dropdown .select2-results__option--highlighted,
        .select2-dark-dropdown .select2-results__option:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
        }

        .select2-dark-dropdown .select2-results__option[aria-selected="true"] {
            background-color: #8046F1 !important;
            color: white !important;
        }

        /* Adjusting PAC container for dark mode input if needed, but it should be standard */
    </style>
    <div class="sticky top-[72px] z-40 bg-white border-b border-gray-200 py-2 sm:py-3 transition-all duration-300 shadow-sm"
        id="sticky-filter-bar">
        <div class="w-full mx-auto px-4 sm:px-6">
            <div
                class="flex flex-col md:flex-row md:items-center bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <!-- Location Group -->
                <div
                    class="w-[50px] md:flex-1 min-h-[48px] px-4 border-b md:border-b-0 md:border-r border-gray-100 flex items-center group">
                    <i class="fa-solid fa-location-dot text-primary text-[14px] mr-3"></i>
                    <input type="text" id="main-location" placeholder="Location..."
                        class="flex-1 bg-transparent border-none focus:ring-0 text-[14px] font-bold text-gray-900 placeholder-gray-400 h-full p-0"
                        value="{{ request('location') }}">
                    <button onclick="document.getElementById('main-location').value=''; autoSearch()"
                        class="px-2 text-gray-300 hover:text-gray-500 transition-colors">
                        <i class="fa-solid fa-xmark text-[14px]"></i>
                    </button>
                </div>

                <!-- Radius (Area) -->
                <div
                    class="w-[120px] md:w-[50px] min-h-[48px] border-b md:border-b-0 md:border-r border-gray-100 flex items-center relative">
                    <select id="main-radius" onchange="autoSearch()"
                        class="w-full h-full min-h-[48px] bg-transparent border-none focus:ring-0 pl-4 pr-10 text-[14px] font-bold text-gray-900 cursor-pointer appearance-none">
                        <option value="0.5" {{ request('radius') == '0.5' ? 'selected' : '' }}>Area</option>
                        <option value="1" {{ request('radius') == '1' ? 'selected' : '' }}>+1 mile</option>
                        <option value="3" {{ request('radius') == '3' ? 'selected' : '' }}>+3 miles</option>
                        <option value="5" {{ request('radius') == '5' ? 'selected' : '' }}>+5 miles</option>
                        <option value="10" {{ request('radius') == '10' ? 'selected' : '' }}>+10 miles</option>
                    </select>
                    <i
                        class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>

                <!-- Price Group -->
                <div
                    class="w-full md:w-auto flex items-center min-h-[48px] px-4 gap-3 border-b md:border-b-0 md:border-r border-gray-100 justify-center md:justify-start">
                        <div class="relative h-full flex-1 md:flex-none min-w-[100px]">
                            <input type="number" id="main-min-price" onblur="debouncedSearch()" placeholder="Min Price"
                                class="w-full h-full min-h-[48px] bg-transparent border-none focus:ring-0 text-[14px] font-bold text-gray-900 placeholder-gray-400 p-0 pr-6"
                                value="{{ request('min_price') }}">
                            <i
                                class="fa-solid fa-chevron-down absolute right-1 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none opacity-40"></i>
                        </div>
                        <span class="text-gray-300 font-bold text-[12px]">to</span>
                        <div class="relative h-full flex-1 md:flex-none min-w-[100px]">
                            <input type="number" id="main-max-price" onblur="debouncedSearch()" placeholder="Max Price"
                                class="w-full h-full min-h-[48px] bg-transparent border-none focus:ring-0 text-[14px] font-bold text-gray-900 placeholder-gray-400 p-0 pr-6"
                                value="{{ request('max_price') }}">
                            <i
                                class="fa-solid fa-chevron-down absolute right-1 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none opacity-40"></i>
                        </div>
                    </div>

                    <!-- Beds Group -->
                    <div
                        class="w-full md:w-auto flex items-center min-h-[48px] px-4 gap-3 border-b md:border-b-0 md:border-r border-gray-100 justify-center md:justify-start">
                        <div class="relative h-full flex-1 md:flex-none min-w-[100px]">
                            <select id="main-min-beds" onchange="autoSearch()"
                                class="w-full h-full bg-transparent border-none focus:ring-0 text-[14px] font-bold text-gray-900 appearance-none pr-8 cursor-pointer">
                                <option value="">Min Beds</option>
                                <option value="0" {{ request('min_bedrooms') === '0' ? 'selected' : '' }}>Studio</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ request('min_bedrooms') == $i ? 'selected' : '' }}>{{ $i }} Beds
                                    </option>
                                @endfor
                                <option value="11" {{ request('min_bedrooms') == '11' ? 'selected' : '' }}>11+</option>
                            </select>
                        </div>
                        <span class="text-gray-300 font-bold text-[12px]">to</span>
                        <div class="relative h-full flex-1 md:flex-none min-w-[100px]">
                            <select id="main-max-beds" onchange="autoSearch()"
                                class="w-full h-full bg-transparent border-none focus:ring-0 text-[14px] font-bold text-gray-900 appearance-none pr-8 cursor-pointer">
                                <option value="">Max Beds</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ request('max_bedrooms') == $i ? 'selected' : '' }}>{{ $i }} Beds
                                    </option>
                                @endfor
                                <option value="11" {{ request('max_bedrooms') == '11' ? 'selected' : '' }}>11+</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filters Button (Stacking on mobile) -->
                    <button onclick="toggleMoreFiltersFiltersTray()" id="more-filters-btn"
                        class="w-full md:w-auto h-[48px] px-6 flex items-center justify-center gap-2 hover:bg-gray-50 transition-colors bg-gray-50/50 md:bg-transparent">
                        <i class="fa-solid fa-sliders text-primary text-[14px]"></i>
                        <span class="text-[14px] font-bold text-gray-900">Filters</span>
                        <i class="fa-solid fa-chevron-down text-[11px] text-gray-400" id="more-filters-chevron"></i>
                    </button>

                    <input type="hidden" id="main-purpose" value="{{ request('purpose', 'Buy') }}">
                </div>
            </div>
        </div>

        <!-- More Filters Tray (Expandable) -->
        <div id="more-filters-tray"
            class="hidden transition-all duration-300 mt-4 border-t border-gray-100 pt-2 bg-white rounded-2xl shadow-2xl p-4 sm:p-6">

            <!-- Bathrooms Section -->
            <div class="filter-group mb-4">
                <div class="filter-section-header py-3 sm:py-4" onclick="toggleFilterAccordion(this)">
                    <h4>Bathrooms</h4>
                    <i class="fa-solid fa-chevron-up transition-transform"></i>
                </div>
                <div class="filter-section-content py-3 sm:py-4">
                    <div class="flex items-center gap-3 sm:gap-4 max-w-sm">
                        <select id="main-min-baths" onchange="autoSearch()"
                            class="w-full h-[46px] bg-gray-50 border border-gray-300 rounded-xl px-3 text-sm font-bold text-gray-900 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 cursor-pointer">
                            <option value="">Min Baths</option>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('min_bathrooms') == $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                            @endfor
                            <option value="7" {{ request('min_bathrooms') == '7' ? 'selected' : '' }}>7+</option>
                        </select>
                        <span class="text-gray-300 font-bold">-</span>
                        <select id="main-max-baths" onchange="autoSearch()"
                            class="w-full h-[46px] bg-gray-50 border border-gray-300 rounded-xl px-3 text-sm font-bold text-gray-900 focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 cursor-pointer">
                            <option value="">Max Baths</option>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('max_bathrooms') == $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                            @endfor
                            <option value="7" {{ request('max_bathrooms') == '7' ? 'selected' : '' }}>7+</option>
                        </select>
                    </div>
                </div>
            </div>


            <!-- Property Type Section -->
            <div class="filter-group">
                <div class="filter-section-header py-3 sm:py-4" onclick="toggleFilterAccordion(this)">
                    <h4>Property type</h4>
                    <i class="fa-solid fa-chevron-up transition-transform"></i>
                </div>
                <div class="filter-section-content py-3 sm:py-4">
                    <div class="flex flex-wrap gap-2 sm:gap-3" id="property-type-tags">
                        @php
                            $typeIcons = [
                                'Detached' => 'fa-house',
                                'Semi-detached' => 'fa-house-chimney-window',
                                'Terraced' => 'fa-house-chimney-crack',
                                'Flat' => 'fa-building',
                                'Bungalow' => 'fa-house-chimney',
                                'Land' => 'fa-tree',
                                'Park home' => 'fa-caravan',
                                'House' => 'fa-house'
                            ];
                            $selectedTypes = (array) explode(',', request('property_type_ids', ''));
                        @endphp
                        @foreach(\App\Models\PropertyType::all() as $type)
                            <div class="filter-tag {{ in_array($type->id, $selectedTypes) ? 'active' : '' }}"
                                data-id="{{ $type->id }}" onclick="toggleTag(this, 'property-type')">
                                <i class="fa-solid {{ $typeIcons[$type->title] ?? 'fa-house' }}"></i>
                                {{ $type->title }}
                            </div>
                        @endforeach
                        <input type="hidden" id="main-property-types-hidden" value="{{ request('property_type_ids') }}">
                    </div>
                </div>
            </div>

            <!-- Property Details Section -->
            <div class="filter-group">
                <div class="filter-section-header py-3 sm:py-4" onclick="toggleFilterAccordion(this)">
                    <h4>Property details</h4>
                    <i class="fa-solid fa-chevron-up transition-transform"></i>
                </div>
                <div class="filter-section-content py-3 sm:py-4 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-3 uppercase tracking-widest">Tenure</label>
                        <div class="flex flex-wrap gap-2" id="tenure-tags">
                            @php
                                $selectedTenure = request('tenure', '');
                                $tenures = ['Freehold', 'Leasehold', 'Share of freehold'];
                            @endphp
                            @foreach($tenures as $t)
                                <div class="filter-tag {{ $selectedTenure == $t ? 'active' : '' }}" data-id="{{ $t }}"
                                    onclick="toggleTag(this, 'tenure', true)">
                                    {{ $t }}
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="main-tenure-hidden" value="{{ request('tenure') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-3 uppercase tracking-widest">Must have
                            features</label>
                        <div class="flex flex-wrap gap-2" id="features-tags">
                            @php
                                $selectedFeatures = (array) explode(',', request('feature_ids', ''));
                            @endphp
                            @foreach($features_all as $feature)
                                <div class="filter-tag {{ in_array($feature->id, $selectedFeatures) ? 'active' : '' }}"
                                    data-id="{{ $feature->id }}" onclick="toggleTag(this, 'feature')">
                                    {{ $feature->title }}
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="main-features-hidden" value="{{ request('feature_ids') }}">
                    </div>
                </div>
            </div>

            <!-- Footer with Search Button -->
            <div
                class="mt-6 sm:mt-8 pt-6 sm:pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3 sm:gap-4">
                <button onclick="resetFiltersAndExecute()"
                    class="px-6 py-3 text-gray-400 font-bold hover:text-primary transition-colors text-sm sm:text-base">Reset
                    all
                    filters</button>
                <button onclick="executeSearch()"
                    class="px-8 sm:px-12 py-3 bg-primary hover:bg-primary-dark text-white font-black rounded-xl shadow-xl shadow-primary/20 transition-all flex items-center justify-center gap-2 text-sm sm:text-base">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Search
                </button>
            </div>
        </div>
        </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Unified Layout using Tailwind Flex -->
            <div class="flex flex-col-reverse lg:flex-row gap-8">

                <!-- Results Section (Left) -->
                <div class="w-full lg:w-3/4">
                    <!-- Results Header / Top Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 px-2">
                        <div class="w-full md:w-auto">
                            <div class="flex items-center justify-between md:justify-start gap-4">
                                <h1 class="text-2xl sm:text-3xl font-extrabold text-primary tracking-tighter">
                                    {{ $listings->total() }} Results
                                    <span class="text-secondary opacity-80">Found</span>
                                </h1>

                                <button type="button" onclick="saveSearch()"
                                    class="inline-flex items-center gap-2 px-3 py-1 bg-secondary/10 text-secondary border border-secondary/20 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-secondary hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-bell"></i> <span class="hidden xs:inline">Create Alert</span>
                                </button>
                            </div>
                            <p class="text-gray-400 text-xs sm:text-sm font-medium mt-1">Properties for
                                {{ request('purpose', 'Sale') }} in {{ request('location', 'United Kingdom') }}
                            </p>
                        </div>


                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full md:w-auto">
                            <a href="{{ route('map') }}"
                                class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 px-3 sm:px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-primary transition-colors h-[42px] shadow-sm">
                                <i class="fa-solid fa-map-location-dot"></i> <span class="hidden sm:inline">Map View</span>
                            </a>

                            <div class="relative flex-1 md:flex-none">
                                <select id="sort-select" onchange="autoSearch()"
                                    class="appearance-none block w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-primary text-sm h-[42px] shadow-sm">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price
                                        L
                                    </option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price
                                        H
                                    </option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>

                            <div class="view-switcher flex items-center bg-gray-100 p-1 rounded-lg">
                                <button type="button" onclick="toggleView('grid')" id="grid-view-btn"
                                    class="w-10 h-10 flex items-center justify-center rounded-md transition-all duration-200 {{ request('view', 'list') == 'grid' ? 'bg-white shadow-sm text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                                    <i class="fa-solid fa-border-all text-base"></i>
                                </button>
                                <button type="button" onclick="toggleView('list')" id="list-view-btn"
                                    class="w-10 h-10 flex items-center justify-center rounded-md transition-all duration-200 {{ request('view', 'list') == 'list' ? 'bg-white shadow-sm text-primary' : 'text-gray-400 hover:text-gray-600' }}">
                                    <i class="fa-solid fa-list-ul text-base"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Cards Display -->
                    <div id="results-grid"
                        class="grid {{ request('view', 'list') == 'list' ? 'grid-cols-1' : 'grid-cols-1 md:grid-cols-2' }} gap-6">
                        @forelse($listings as $listing)
                            <div>
                                <div class="property-card-results {{ request('view', 'list') == 'list' ? 'list-view-card' : '' }}">
                                    @php
                                        $isOffMarket = $listing instanceof \App\Models\OffMarketListing;
                                        $favIds = $isOffMarket ? ($user_favorite_off_market_ids ?? []) : ($user_favorite_ids ?? []);
                                        $isFavorited = in_array($listing->id, $favIds);
                                    @endphp
                                    <div class="img-container">
                                        <a href="{{ $isOffMarket ? route('off-market-listing.show', $listing->slug ?? $listing->id) : route('listing.show', $listing->slug ?? $listing->id) }}"
                                            class="block h-full w-full">
                                            @if($listing->thumbnail)
                                                <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                                    alt="{{ $listing->property_title }}">
                                            @else
                                                <div class="h-full w-full bg-slate-100 flex flex-col items-center justify-center gap-3">
                                                    <i class="fa-solid fa-house-chimney text-gray-200 text-4xl"></i>
                                                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">No
                                                        Image</span>
                                                </div>
                                            @endif
                                        </a>
                                        <div class="price-badge flex flex-col items-end">
                                            @if($listing->old_price && $listing->old_price > 0 && $listing->old_price != $listing->price)
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] text-gray-400 font-bold p-2"
                                                        style="text-decoration: line-through;">£{{ number_format($listing->old_price) }}</span>
                                                    @php
                                                        $percentage = round((($listing->old_price - $listing->price) / $listing->old_price) * 100);
                                                    @endphp
                                                    <span style="padding:4px"
                                                        class="text-[10px] bg-red-100 text-red-600 px-1.5 py-0.5 rounded-md">-{{ $percentage }}%</span>
                                                </div>
                                            @endif
                                            <span>£{{ number_format($listing->price) }}</span>
                                        </div>

                                        <button
                                            onclick="toggleFavorite({{ $isOffMarket ? 'null' : $listing->id }}, {{ $isOffMarket ? $listing->id : 'null' }}, this)"
                                            class="absolute top-4 right-4 w-11 h-11 bg-white/90 backdrop-blur-md rounded-2xl flex items-center justify-center transition-all shadow-lg {{ $isFavorited ? 'text-red-500' : 'text-gray-400' }} hover:scale-110 z-20 border border-white/20">
                                            <i class="{{ $isFavorited ? 'fa-solid' : 'fa-regular' }} fa-heart text-xl"></i>
                                        </button>
                                    </div>
                                    <div class="card-content">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-2">
                                                <span style="padding:4px"
                                                    class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm transition-all shadow-primary/10 
                                                                                                                                                                                                                                                                                    {{ $listing->purpose == 'Rent' ? 'bg-secondary text-white' : 'bg-primary text-white' }}">
                                                    {{ $listing->purpose }}
                                                </span>
                                                @if($isOffMarket)
                                                    <span style="padding:4px"
                                                        class="px-2.5 py-1 rounded-lg bg-black text-white text-[10px] font-black uppercase tracking-wider shadow-sm">Vault</span>
                                                @endif
                                            </div>
                                        </div>

                                        <h3 class="property-title">
                                            <a href="{{ $isOffMarket ? route('off-market-listing.show', $listing->slug ?? $listing->id) : route('listing.show', $listing->slug ?? $listing->id) }}"
                                                class="hover:text-secondary transition-colors">{{ $listing->property_title }}</a>
                                        </h3>

                                        <p class="property-addr">
                                            <i class="fa-solid fa-location-dot"></i> {{ Str::limit($listing->address, 65) }}
                                        </p>

                                        <div class="stats-row">
                                            <div class="stat-item">
                                                <i class="fa-solid fa-bed"></i>
                                                <span class="whitespace-nowrap">
                                                    @if(strtolower($listing->bedrooms) === 'studio')
                                                        Studio
                                                    @elseif($listing->bedrooms && $listing->bedrooms > 0)
                                                        {{ $listing->bedrooms }} Bed{{ $listing->bedrooms > 1 ? 's' : '' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="stat-item">
                                                <i class="fa-solid fa-bath"></i>
                                                <span class="whitespace-nowrap">
                                                    @if($listing->bathrooms && $listing->bathrooms > 0)
                                                        {{ $listing->bathrooms }} Bath{{ $listing->bathrooms > 1 ? 's' : '' }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="stat-item">
                                                <i class="fa-solid fa-vector-square"></i>
                                                <span class="whitespace-nowrap">
                                                    {{ $listing->area_size && is_numeric($listing->area_size) && $listing->area_size > 0 ? number_format((float) $listing->area_size) . ' sqft' : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-4 flex flex-col sm:flex-row gap-2">
                                            <a style="background-color:#25D366"
                                                href="https://wa.me/{{ $listing->user?->phone_number ?? '440000000000' }}?text=Interested%20in%20{{ urlencode($listing->property_title) }}"
                                                class="flex-1 bg-[#25D366] hover:bg-[#20bd5c] text-[10px] text-white font-bold py-2.5 px-2 rounded-lg flex items-center justify-center gap-1.5 transition-colors uppercase"
                                                target="_blank">
                                                <i class="fab fa-whatsapp text-sm"></i> Chat
                                            </a>
                                            <a href="mailto:{{ $listing->user?->email }}?subject=Enquiry%20about%20{{ urlencode($listing->property_title) }}"
                                                class="flex-1 bg-primary hover:bg-primary-dark text-[10px] text-white font-bold py-2.5 px-2 rounded-lg flex items-center justify-center gap-1.5 transition-colors uppercase">
                                                <i class="fa-regular fa-envelope"></i> Mail
                                            </a>
                                            <a href="{{ $isOffMarket ? route('off-market-listing.show', $listing->slug ?? $listing->id) : route('listing.show', $listing->slug ?? $listing->id) }}"
                                                class="flex-1 border border-gray-200 hover:border-secondary hover:text-secondary text-gray-600 text-[10px] font-bold py-2.5 px-2 rounded-lg flex items-center justify-center transition-all uppercase">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                                <div class="text-5xl text-gray-200 mb-6"><i class="fa-solid fa-house-circle-exclamation"></i>
                                </div>
                                <h2 class="text-xl font-bold text-gray-500">No properties found.</h2>
                                <p class="text-gray-400 mt-2">Try adjusting your filters.</p>
                                <a href="{{ request()->routeIs('off-market-listings.index') ? route('off-market-listings.index') : route('listings.index') }}"
                                    class="btn-apply inline-block px-8 py-3 bg-primary text-white rounded-xl mt-6">
                                    Reset Filters
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 pagination-container">
                        {{ $listings->links() }}
                    </div>
                </div>

                <!-- Sidebar Section - Hidden or Simplified -->
                <div class="hidden lg:block lg:w-1/4">
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm sticky top-[150px]">
                        <h3 class="font-black text-primary text-lg mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-fire-flame-curved text-secondary"></i>
                            Latest Vault
                        </h3>
                        <div class="space-y-6">
                            @foreach($latest_listings as $latest)
                                <a href="{{ route('listing.show', $latest->slug ?? $latest->id) }}" class="flex gap-4 group">
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm">
                                        <img src="{{ asset('storage/' . $latest->thumbnail) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            alt="{{ $latest->property_title }}">
                                    </div>
                                    <div class="flex-grow pt-1">
                                        <h4
                                            class="text-[13px] font-extrabold text-primary line-clamp-2 group-hover:text-secondary transition-colors leading-tight mb-1">
                                            {{ $latest->property_title }}
                                        </h4>
                                        <p class="text-[14px] text-secondary font-black">£{{ number_format($latest->price) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <a href="{{ route('off-market-listings.index') }}"
                            class="mt-8 block text-center py-3 bg-gray-50 hover:bg-gray-100 text-primary font-black text-xs rounded-xl transition-all uppercase tracking-widest">
                            View All Vault Properties
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>

@endsection

@push('scripts')
    <!-- Select2 JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Google Maps API with Places Library -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2-filter').select2({
                width: '100%',
                minimumResultsForSearch: Infinity
            });

            $('.select2-filter-dark').select2({
                width: '100%',
                minimumResultsForSearch: Infinity,
                dropdownCssClass: 'select2-dark-dropdown'
            });

            $('.select2-filter-dark-simple').select2({
                width: 'auto',
                minimumResultsForSearch: Infinity,
                dropdownCssClass: 'select2-dark-dropdown'
            });

            $('.select2-filter-multiple').select2({
                width: '100%',
                closeOnSelect: false
            });

            // Initialize Location Autocomplete
            initLocationAutocomplete();
        });

        function syncAndSearch(type) {
            if (type === 'min-price') {
                document.getElementById('main-min-price').value = document.getElementById('main-min-price-select').value;
            } else if (type === 'max-price') {
                document.getElementById('main-max-price').value = document.getElementById('main-max-price-select').value;
            }
            autoSearch();
        }

        function toggleMoreFiltersFiltersTray() {
            const tray = document.getElementById('more-filters-tray');
            const chevron = document.getElementById('more-filters-chevron');
            const btn = document.getElementById('more-filters-btn');

            if (tray.classList.contains('hidden')) {
                tray.classList.remove('hidden');
                tray.classList.add('active');
                chevron.style.transform = 'rotate(180deg)';
                btn.classList.add('border-primary', 'bg-primary/5');
            } else {
                tray.classList.add('hidden');
                tray.classList.remove('active');
                chevron.style.transform = 'rotate(0deg)';
                btn.classList.remove('border-primary', 'bg-primary/5');
            }
        }

        function toggleFilterAccordion(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('i');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(0deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        }

        function toggleTag(el, type, single = false) {
            if (single) {
                const isActive = el.classList.contains('active');
                const siblings = el.parentElement.querySelectorAll('.filter-tag');
                siblings.forEach(sibling => sibling.classList.remove('active'));
                if (!isActive) {
                    el.classList.add('active');
                }
            } else {
                el.classList.toggle('active');
            }

            if (type === 'property-type') {
                const activeTags = Array.from(document.querySelectorAll('#property-type-tags .filter-tag.active'));
                const ids = activeTags.map(tag => tag.dataset.id).join(',');
                document.getElementById('main-property-types-hidden').value = ids;
            } else if (type === 'feature') {
                const activeTags = Array.from(document.querySelectorAll('#features-tags .filter-tag.active'));
                const ids = activeTags.map(tag => tag.dataset.id).join(',');
                document.getElementById('main-features-hidden').value = ids;
            } else if (type === 'tenure') {
                const activeTag = el.parentElement.querySelector('.filter-tag.active');
                document.getElementById('main-tenure-hidden').value = activeTag ? activeTag.dataset.id : '';
            }

            autoSearch();
        }

        let searchTimeout;
        function debouncedSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                autoSearch();
            }, 800);
        }

        function autoSearch() {
            // Optional: You could call executeSearch() here directly
            // For now, let's keep it manual as requested "search button k bgair working kre"
            // but also "end pr aye search ka button". Auto-search usually means without button.
            executeSearch();
        }

        let selectedLat = '{{ request('lat') }}';
        let selectedLng = '{{ request('lng') }}';

        function initLocationAutocomplete() {
            const input = document.getElementById('main-location');
            if (!input || typeof google === 'undefined') return;

            const autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: { country: 'gb' },
                fields: ['geometry', 'formatted_address']
            });

            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    selectedLat = place.geometry.location.lat();
                    selectedLng = place.geometry.location.lng();
                    autoSearch();
                }
            });

            input.addEventListener('input', () => {
                selectedLat = '';
                selectedLng = '';
            });
        }

        function executeSearch() {
            const params = new URLSearchParams();

            const location = document.getElementById('main-location').value;
            const radius = document.getElementById('main-radius').value;
            const minPrice = document.getElementById('main-min-price').value;
            const maxPrice = document.getElementById('main-max-price').value;
            const minBeds = document.getElementById('main-min-beds').value;
            const maxBeds = document.getElementById('main-max-beds').value;
            const purpose = document.getElementById('main-purpose').value;
            const sort = document.getElementById('sort-select').value;
            const view = '{{ request('view', 'list') }}';

            // Advanced
            const propertyTypes = document.getElementById('main-property-types-hidden')?.value;
            const minBaths = document.getElementById('main-min-baths').value;
            const maxBaths = document.getElementById('main-max-baths').value;
            const tenure = document.getElementById('main-tenure-hidden')?.value;
            const features = document.getElementById('main-features-hidden')?.value;

            if (location) params.append('location', location);
            if (radius) params.append('radius', radius);
            if (minPrice) params.append('min_price', minPrice);
            if (maxPrice) params.append('max_price', maxPrice);
            if (minBeds !== '') params.append('min_bedrooms', minBeds);
            if (maxBeds !== '') params.append('max_bedrooms', maxBeds);
            if (purpose) params.append('purpose', purpose);
            if (sort) params.append('sort', sort);
            if (view) params.append('view', view);

            if (propertyTypes) {
                params.append('property_type_ids', propertyTypes);
            }
            if (minBaths) params.append('min_bathrooms', minBaths);
            if (maxBaths) params.append('max_bathrooms', maxBaths);
            if (tenure) params.append('tenure', tenure);
            if (features) {
                params.append('feature_ids', features);
            }

            // Use coordinates if available from autocomplete
            if (selectedLat) params.append('lat', selectedLat);
            if (selectedLng) params.append('lng', selectedLng);

            const routeName = '{{ request()->routeIs('off-market-listings.index') ? route('off-market-listings.index') : route('listings.index') }}';
            window.location.href = `${routeName}?${params.toString()}`;
        }

        function resetFiltersAndExecute() {
            const routeName = '{{ request()->routeIs('off-market-listings.index') ? route('off-market-listings.index') : route('listings.index') }}';
            window.location.href = routeName;
        }

        function toggleView(view) {
            const params = new URLSearchParams(window.location.search);
            params.set('view', view);
            window.location.href = window.location.pathname + '?' + params.toString();
        }

        function toggleView(view) {
            const params = new URLSearchParams(window.location.search);
            params.set('view', view);
            window.location.href = window.location.pathname + '?' + params.toString();
        }

        function toggleFavorite(listingId, offMarketId, btn) {
            @if(!auth()->check())
                window.location.href = "{{ route('login') }}";
                return;
            @endif

                        const data = {
                _token: '{{ csrf_token() }}'
            };
            if (listingId) data.listing_id = listingId;
            if (offMarketId) data.off_market_listing_id = offMarketId;

            const icon = $(btn).find('i');

            $.ajax({
                url: '{{ route('favorites.toggle') }}',
                type: 'POST',
                data: data,
                success: function (res) {
                    if (res.status === 'added') {
                        $(btn).removeClass('text-gray-400').addClass('text-red-500');
                        icon.removeClass('fa-regular').addClass('fa-solid');
                    } else {
                        $(btn).removeClass('text-red-500').addClass('text-gray-400');
                        icon.removeClass('fa-solid').addClass('fa-regular');
                    }
                },
                error: function () {
                    alert('Something went wrong. Please try again.');
                }
            });
        }
        function saveSearch() {
            @if(!auth()->check())
                window.location.href = "{{ route('login') }}";
                return;
            @endif

                        const filters = {
                purpose: $('#purpose-hidden-input').val() || 'Buy',
                location: $('#sidebar-location').val(),
                lat: $('#sidebar-lat').val(),
                lng: $('#sidebar-lng').val(),
                radius: $('select[name="radius"]').val() || 2,
                property_type_id: $('select[name="property_type"]').val(),

                min_price: $('input[name="min_price"]').val(),
                max_price: $('input[name="max_price"]').val(),
                bedrooms: $('select[name="min_bedrooms"]').val()
            };

            const locationName = filters.location || 'Recent Search';

            $.ajax({
                url: '{{ route('saved-searches.store') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: locationName + ' alert',
                    filters: filters
                },
                success: function (res) {
                    alert(res.message);
                },
                error: function (xhr) {
                    alert(xhr.responseJSON?.message || 'Error saving search.');
                }
            });
        }
    </script>
@endpush