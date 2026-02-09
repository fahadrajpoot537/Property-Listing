@extends('layouts.modern')

@section('title', 'Property Search - FindaUK')

@section('content')
    <style>
        /* Premium Portal Styling */
        :root {
            --ztc-bg-bg-3: #8046F1;
            /* Zoopla Purple from tailwind config */
        }

        .search-results-page {
            padding-top: 80px;
            /* Offset for fixed navbar */
            background-color: #F9FAFB;
        }

        /* Filters Sidebar */
        .filters-sidebar {
            background: white;
            border-radius: 1.5rem;
            border: 1px solid #E5E7EB;
            padding: 1.5rem;
            position: sticky;
            top: 100px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #131B31;
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        /* Purpose Tabs (Zoopla Style) */
        .purpose-tabs {
            display: flex;
            background: #F3F4F6;
            padding: 0.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .sidebar-purpose-btn {
            flex: 1;
            padding: 0.5rem;
            font-size: 0.875rem;
            font-weight: 700;
            border-radius: 0.5rem;
            transition: all 0.2s;
            border: none;
            color: #6B7280;
            background: transparent;
        }

        .sidebar-purpose-btn.active {
            background: white;
            color: #131B31;
            shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        /* Form Controls */
        .form-group-custom {
            margin-bottom: 1rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .sidebar-input,
        .select2-container .select2-selection--single {
            width: 100% !important;
            background-color: #F9FAFB !important;
            border: 1px solid #E5E7EB !important;
            border-radius: 0.75rem !important;
            height: 48px !important;
            padding: 0.5rem 35px !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
        }

        .select2-container .select2-selection--single {
            display: flex !important;
            align-items: center !important;
            padding: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 48px !important;
            padding-left: 1rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
        }

        /* Property Cards (Premium Grid) */
        .property-card-results {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1px solid #E5E7EB;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .property-card-results:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: #8046F1;
        }

        .img-container {
            position: relative;
            height: 240px;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .price-badge {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-blur: 4px;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 800;
            color: #131B31;
            font-size: 1.125rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .property-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #131B31;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .property-addr {
            font-size: 0.875rem;
            color: #6B7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .stats-row {
            display: flex;
            gap: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #F3F4F6;
            margin-top: auto;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.875rem;
        }

        .stat-item i {
            color: #9CA3AF;
            font-size: 1rem;
        }

        /* List View Specifics */
        .list-view-card {
            flex-direction: row;
            height: 220px;
        }

        .list-view-card .img-container {
            width: 300px;
            height: 100%;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .list-view-card {
                flex-direction: column;
                height: auto;
            }

            .list-view-card .img-container {
                width: 100%;
                height: 200px;
            }
        }

        /* Buttons */
        .btn-apply {
            background: #8046F1;
            color: white;
            font-weight: 800;
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.2s;
            margin-top: 1rem;
        }

        .btn-apply:hover {
            background: #6D28D9;
            transform: translateY(-1px);
        }

        /* View Switcher */
        .view-switcher {
            display: flex;
            gap: 0.5rem;
        }

        .view-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            border: 1px solid #E5E7EB;
            background: white;
            color: #6B7280;
            transition: all 0.2s;
        }

        .view-btn.active {
            background: #131B31;
            color: white;
            border-color: #131B31;
        }

        /* Amenities Custom Checkbox */
        .amenity-checkbox-group {
            display: grid;
            grid-template-cols: 1fr;
            gap: 0.5rem;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .custom-checkbox:hover {
            background: #F3F4F6;
        }

        .custom-checkbox input {
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 0.25rem;
            border: 2px solid #D1D5DB;
            accent-color: #8046F1;
        }

        .custom-checkbox span {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        /* Scrollbar */
        .amenity-checkbox-group::-webkit-scrollbar {
            width: 4px;
        }

        .amenity-checkbox-group::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .amenity-checkbox-group::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
    </style>

    <div class="search-results-page">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Unified Layout using Tailwind Flex -->
            <div class="flex flex-col-reverse lg:flex-row gap-8">

                <!-- Results Section (Left) -->
                <div class="w-full lg:w-3/4">
                    <!-- Results Header / Top Bar -->
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 px-2">
                        <div>
                            <h1 class="text-3xl font-extrabold text-primary tracking-tighter">
                                {{ $listings->total() }} results
                                <span class="text-secondary opacity-80">found</span>
                            </h1>
                            <p class="text-gray-400 text-sm font-medium mt-1">Properties for
                                {{ request('purpose', 'Sale') }} in {{ request('location', 'United Kingdom') }}
                            </p>
                        </div>


                        <div class="flex items-center gap-3">
                            <a href="{{ route('map') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-primary transition-colors h-[42px] shadow-sm">
                                <i class="fa-solid fa-map-location-dot"></i> <span class="hidden sm:inline">Map View</span>
                            </a>

                            <div class="relative">
                                <select id="sort-select"
                                    class="appearance-none block w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-primary text-sm h-[42px] shadow-sm"
                                    style="min-width: 150px;">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest listed
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest listed
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price
                                        (Lowest)</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price
                                        (Highest)</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>

                            <div class="view-switcher flex items-center bg-gray-100p-1 rounded-lg">
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
                                        <div
                                            class="property-card-results {{ request('view', 'list') == 'list' ? 'list-view-card' : '' }}">
                                            <div class="img-container">
                                                <a href="{{ route('listing.show', $listing->id) }}">
                                                    <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : asset('assets/img/all-images/hero/1.jpg') }}"
                                                        alt="Property">
                                                </a>
                                                <div class="price-badge flex flex-col items-end">
                                                    @if($listing->old_price && $listing->old_price > 0 && $listing->old_price != $listing->price)
                                                        <span class="text-[10px] text-gray-500 font-bold"
                                                            style="text-decoration: line-through; margin-bottom: -4px;">£{{ number_format($listing->old_price) }}</span>
                                                    @endif
                                                    <span>£{{ number_format($listing->price) }}</span>
                                                </div>
                                                @php
                                                    $isOffMarket = $listing instanceof \App\Models\OffMarketListing;
                                                    $favIds = $isOffMarket ? ($user_favorite_off_market_ids ?? []) : ($user_favorite_ids ?? []);
                                                    $isFavorited = in_array($listing->id, $favIds);
                                                @endphp
                                                <button
                                                    onclick="toggleFavorite({{ $isOffMarket ? 'null' : $listing->id }}, {{ $isOffMarket ? $listing->id : 'null' }}, this)"
                                                    class="absolute top-4 right-4 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center {{ $isFavorited ? 'text-red-500' : 'text-gray-400' }} hover:text-red-500 transition-colors shadow-sm">
                                                    <i class="{{ $isFavorited ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                </button>
                                            </div>
                                            <div class="card-content">
                                                <div
                                                    class="inline-block bg-purple-50 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider mb-2 w-fit">
                                                    {{ $listing->purpose }}
                                                </div>
                                                <h3 class="property-title">
                                                    <a href="{{ route('listing.show', $listing->id) }}"
                                                        class="hover:text-secondary transition-colors">{{ $listing->property_title }}</a>
                                                </h3>
                                                <p class="property-addr">
                                                    <i class="fa-solid fa-location-dot"></i> {{ Str::limit($listing->address, 50) }}
                                                </p>

                                                <div class="stats-row">
                                                    <div class="stat-item"><i class="fa-solid fa-bed"></i> {{ $listing->bedrooms }}
                                                    </div>
                                                    <div class="stat-item"><i class="fa-solid fa-bath"></i> {{ $listing->bathrooms }}
                                                    </div>
                                                    <div class="stat-item"><i class="fa-solid fa-vector-square"></i>
                                                        {{ $listing->area_size ?? 'N/A' }} sqft</div>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <a href="whatsapp://send?phone={{ $listing->user?->phone }}"
                                                        class="flex-1 text-center py-2 px-3 bg-green-500 text-white rounded-lg text-xs font-bold hover:bg-green-600 transition-colors">
                                                        <i class="fab fa-whatsapp"></i> Whatsapp
                                                    </a>
                                                    <a href="{{ route('listing.show', $listing->id) }}"
                                                        class="flex-1 text-center py-2 px-3 border border-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-50 transition-colors">
                                                        Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="col-span-full text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
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

                        <!-- Sidebar Section (Right) -->
                        <div class="w-full lg:w-1/4" x-data="{ showFilters: window.innerWidth >= 1024 }">

                            <button @click="showFilters = !showFilters" type="button"
                                class="w-full bg-white border border-gray-200 py-3 px-4 rounded-xl font-bold text-gray-700 shadow-sm mb-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-filter text-secondary"></i> Filter
                                    Results</span>
                                <i class="fa-solid transition-transform duration-200"
                                    :class="showFilters ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>

                            <div class="filters-sidebar" x-show="showFilters" x-transition>
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="sidebar-title !mb-0">Filters</h2>
                                    <button @click="showFilters = false" class="text-gray-400 hover:text-gray-600">
                                        <i class="fa-solid fa-xmark text-xl"></i>
                                    </button>
                                </div>

                                <form id="sidebar-filter-form"
                                    action="{{ request()->routeIs('off-market-listings.index') ? route('off-market-listings.index') : route('listings.index') }}"
                                    method="GET">
                                    <input type="hidden" name="view" id="sidebar-view" value="{{ request('view', 'list') }}">
                                    <input type="hidden" name="sort" id="sidebar-sort" value="{{ request('sort', 'newest') }}">
                                    <input type="hidden" name="lat" id="sidebar-lat" value="{{ request('lat') }}">
                                    <input type="hidden" name="lng" id="sidebar-lng" value="{{ request('lng') }}">
                                    <input type="hidden" name="discounted" value="{{ request('discounted') }}">

                                    <!-- Purpose Switching -->
                                    <div class="purpose-tabs">
                                        <button type="button"
                                            onclick="document.getElementById('purpose-hidden-input').value = 'Buy'; this.form.submit()"
                                            class="sidebar-purpose-btn {{ request('purpose', 'Buy') == 'Buy' ? 'active' : '' }}">Buy</button>
                                        <button type="button"
                                            onclick="document.getElementById('purpose-hidden-input').value = 'Rent'; this.form.submit()"
                                            class="sidebar-purpose-btn {{ request('purpose') == 'Rent' ? 'active' : '' }}">Rent</button>
                                        <input type="hidden" name="purpose" id="purpose-hidden-input"
                                            value="{{ request('purpose', 'Buy') }}">
                                    </div>

                                    <!-- Filter Controls -->
                                    <div class="space-y-4">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Location</label>
                                            <div class="relative">
                                                <i
                                                    class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                                <input type="text" name="location" id="sidebar-location" class="sidebar-input pl-16"
                                                    placeholder="e.g. London" value="{{ request('location') }}">
                                            </div>
                                        </div>

                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Search Radius</label>
                                            <select name="radius" class="select2-filter">
                                                <option value="0.5" {{ request('radius') == '0.5' ? 'selected' : '' }}>This area only
                                                </option>
                                                <option value="1" {{ request('radius') == '1' ? 'selected' : '' }}>+ 1 mile</option>
                                                <option value="3" {{ request('radius') == '3' ? 'selected' : '' }}>+ 3 miles</option>
                                                <option value="5" {{ request('radius') == '5' ? 'selected' : '' }}>+ 5 miles</option>
                                                <option value="10" {{ request('radius') == '10' ? 'selected' : '' }}>+ 10 miles
                                                </option>
                                                <option value="15" {{ request('radius') == '15' ? 'selected' : '' }}>+ 15 miles
                                                </option>
                                                <option value="20" {{ request('radius') == '20' ? 'selected' : '' }}>+ 20 miles
                                                </option>
                                                <option value="30" {{ request('radius') == '30' ? 'selected' : '' }}>+ 30 miles
                                                </option>
                                                <option value="40" {{ request('radius') == '40' ? 'selected' : '' }}>+ 40 miles
                                                </option>
                                                <option value="50" {{ request('radius') == '50' ? 'selected' : '' }}>+ 50 miles
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Property Type</label>
                                            <select name="property_type" class="select2-filter">
                                                <option value="">Any Type</option>
                                                @foreach(\App\Models\PropertyType::all() as $type)
                                                    <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Bedrooms</label>
                                            <select name="min_bedrooms" class="select2-filter">
                                                <option value="">Any Beds</option>
                                                <option value="1" {{ request('min_bedrooms') == '1' ? 'selected' : '' }}>1+ Beds
                                                </option>
                                                <option value="2" {{ request('min_bedrooms') == '2' ? 'selected' : '' }}>2+ Beds
                                                </option>
                                                <option value="3" {{ request('min_bedrooms') == '3' ? 'selected' : '' }}>3+ Beds
                                                </option>
                                                <option value="4" {{ request('min_bedrooms') == '4' ? 'selected' : '' }}>4+ Beds
                                                </option>
                                            </select>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="form-label-custom">Min Price</label>
                                                <select name="min_price" class="select2-filter">
                                                    <option value="">No Min</option>
                                                    <option value="100000" {{ request('min_price') == '100000' ? 'selected' : '' }}>
                                                        £100k</option>
                                                    <option value="250000" {{ request('min_price') == '250000' ? 'selected' : '' }}>
                                                        £250k</option>
                                                    <option value="500000" {{ request('min_price') == '500000' ? 'selected' : '' }}>
                                                        £500k</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="form-label-custom">Max Price</label>
                                                <select name="max_price" class="select2-filter">
                                                    <option value="">No Max</option>
                                                    <option value="500000" {{ request('max_price') == '500000' ? 'selected' : '' }}>
                                                        £500k</option>
                                                    <option value="1000000" {{ request('max_price') == '1000000' ? 'selected' : '' }}>
                                                        £1m</option>
                                                    <option value="5000000" {{ request('max_price') == '5000000' ? 'selected' : '' }}>
                                                        £5m</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Amenities List -->
                                        <div class="form-group-custom !mb-6">
                                            <label class="form-label-custom mb-3">Must have features</label>
                                            <div class="amenity-checkbox-group">
                                                @foreach($features_all as $feature)
                                                    <label class="custom-checkbox">
                                                        <input type="checkbox" name="feature_ids[]" value="{{ $feature->id }}" {{ in_array($feature->id, (array) request('feature_ids')) ? 'checked' : '' }}>
                                                        <span>{{ $feature->title }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-apply">
                                        Update results
                                    </button>

                                    <a href="{{ request()->routeIs('off-market-listings.index') ? route('off-market-listings.index') : route('listings.index') }}"
                                        class="block text-center text-sm font-bold text-gray-400 mt-4 hover:text-primary transition-colors">
                                        Clear all filters
                                    </a>
                                </form>
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
            // Initialize Select2 with current theme styling
            $('.select2-filter').select2({
                minimumResultsForSearch: 10,
                width: '100%'
            });

            // Initialize Google Places Autocomplete
            const locationInput = document.getElementById('sidebar-location');
            if (locationInput && typeof google !== 'undefined') {
                const autocomplete = new google.maps.places.Autocomplete(locationInput, {
                    types: ['geocode'],
                    componentRestrictions: { country: 'uk' }
                });

                // Reset lat/lng when user types to ensure we don't use old coordinates for a new text search
                locationInput.addEventListener('input', function () {
                    $('#sidebar-lat').val('');
                    $('#sidebar-lng').val('');
                });

                autocomplete.addListener('place_changed', function () {
                    const place = autocomplete.getPlace();
                    if (place.geometry) {
                        $('#sidebar-lat').val(place.geometry.location.lat());
                        $('#sidebar-lng').val(place.geometry.location.lng());

                        // Auto submit when location changes
                        $('#sidebar-filter-form').submit();
                    }
                });
            }

            // Auto-submit form when selects change
            $('.select2-filter').on('change', function () {
                if ($(this).attr('id') === 'sort-select') {
                    $('#sidebar-sort').val($(this).val());
                }
                $('#sidebar-filter-form').submit();
            });

            // Handle pagination clicks within the form context
            $('.pagination a').on('click', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                window.location.href = url;
            });
        });

        function toggleView(view) {
            const grid = $('#results-grid');
            const cards = $('.property-card-results');
            const sidebarView = $('#sidebar-view');
            const activeClasses = 'bg-white shadow-sm text-primary';
                const inactiveClasses = 'text-gray-400 hover:text-gray-600';

                sidebarView.val(view);

                // Reset buttons
                $('#grid-view-btn, #list-view-btn').removeClass(activeClasses).addClass(inactiveClasses);

                if (view === 'list') {
                    grid.removeClass('md:grid-cols-2').addClass('grid-cols-1');
                    cards.addClass('list-view-card');
                    $('#list-view-btn').removeClass(inactiveClasses).addClass(activeClasses);
                } else {
                    grid.addClass('md:grid-cols-2');
                    cards.removeClass('list-view-card');
                    $('#grid-view-btn').removeClass(inactiveClasses).addClass(activeClasses);
                }
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
        </script>
@endpush