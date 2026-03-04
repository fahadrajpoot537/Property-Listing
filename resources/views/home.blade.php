@extends('layouts.modern')

@section('content')

  <!-- Portal Hero Search Section -->
  <div class="relative bg-primary overflow-visible min-h-[60vh] md:min-h-[90vh] flex flex-col">
    <!-- Background Pattern -->
    <div class="absolute inset-0 z-0">
      <!-- Image with Overlay -->
      <img src="{{ asset('hero_premium.png') }}" class="w-full h-full object-cover" alt="Background">
      <!-- <div class="absolute inset-0 bg-primary/80 mix-blend-multiply"></div> -->
    </div>

    <div
      class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-48 md:pt-96 md:pb-[480px] flex-1 flex flex-col justify-center">
      <div class="text-center mb-16 md:mb-32 lg:mb-40 px-4">
        <h1 class="text-3xl md:text-5xl font-black text-white mb-1 md:mb-4 tracking-tight"
          style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
          Find Your Perfect Home
        </h1>
        <p class="text-base text-white font-medium mb-10 drop-shadow-md max-w-lg mx-auto leading-relaxed">
          The UK's fastest growing property search portal for sale and to rent.
        </p>

        <div class="flex justify-center mb-1">
          <a href="https://uk.trustpilot.com/review/propertyfinda.co.uk" target="_blank"
            class="inline-flex items-center gap-2 bg-white px-4 py-2.5 border border-[#00B67A] rounded hover:shadow-md transition-all">
            <span class="text-[#191919] text-base md:text-lg font-medium">Review us on</span>
            <div class="flex items-center gap-1.5">
              <svg viewBox="0 0 100 100" class="w-6 h-6">
                <rect width="100" height="100" fill="#00B67A" rx="4" />
                <path d="M50 20l8.1 16.2 17.9 2.6-13 12.6 3.1 17.8-16.1-8.5-16.1 8.5 3.1-17.8-13-12.6 17.9-2.6 8.1-16.2z"
                  fill="white" />
              </svg>
              <span class="text-[#00B67A] text-xl md:text-2xl font-black tracking-tighter"
                style="font-family: 'Outfit', sans-serif;">Trustpilot</span>
            </div>
          </a>
        </div>
      </div>

      <!-- Main Portal Search Box (Rightmove-meets-Zoopla Mixture) -->
      <div style="margin-bottom: 15%;"
        class="bg-white rounded-2xl md:rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] overflow-visible max-w-5xl mx-auto p-2 md:p-3 relative -mb-24 md:-mb-52 border border-gray-100">
        <div x-data="{ tab: 'buy' }">
          <!-- Tabs Style (Zoopla Inspired) -->
          <div class="flex p-1 bg-gray-100 rounded-xl mb-4">
            <button @click="tab = 'buy'"
              class="flex-1 py-3 text-base font-bold text-center transition-all rounded-lg font-effra"
              :class="tab === 'buy' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary'">
              For Sale
            </button>
            <button @click="tab = 'rent'"
              class="flex-1 py-3 text-base font-bold text-center transition-all rounded-lg font-effra"
              :class="tab === 'rent' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary'">
              To Rent
            </button>
          </div>

          <!-- Search Content (Rightmove Inspired Layout) -->
          <div class="p-4 md:p-6">
            <!-- Select2 CSS -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

            <style>
              /* Google Autocomplete Styling */
              .pac-container {
                border-radius: 1rem;
                margin-top: 0.5rem;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                border: 1px solid #f3f4f6;
                z-index: 9999 !important;
              }

              .pac-item {
                padding: 14px 16px;
                cursor: pointer;
                color: #374151;
                border-top: 1px solid #f9fafb;
              }

              .pac-item:hover {
                background-color: #f3f4f6;
              }

              .pac-icon {
                display: none;
              }

              /* Select2 Premium Styling (Zoopla Purple Accent) */
              .select2-container .select2-selection--single {
                height: 56px !important;
                background-color: #f9fafb;
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                display: flex !important;
                align-items: center;
                transition: all 0.2s;
              }

              .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 56px !important;
                padding-left: 2.5rem !important;
                color: #111827;
                font-weight: 500;
              }

              .select2-container--default.select2-container--open .select2-selection--single {
                border-color: #8046F1;
                background-color: #fff;
                box-shadow: 0 0 0 4px rgba(128, 70, 241, 0.1);
              }

              .select2-dropdown {
                border: 1px solid #f3f4f6;
                border-radius: 1rem !important;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                margin-top: 8px;
                overflow: hidden;
                z-index: 9999;
              }

              .select2-results__option--highlighted.select2-results__option--selectable {
                background-color: #f3f4f6;
                color: #8046F1;
                font-weight: 600;
              }

              .select2-container--default .select2-results__option--selected {
                background-color: #f5f3ff;
                color: #8046F1;
              }

              .filter-icon-wrapper {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                padding-left: 1rem;
                display: flex;
                align-items: center;
                pointer-events: none;
                z-index: 10;
                color: #9ca3af;
              }
            </style>

            <form action="{{ route('listings.index') }}" method="GET">
              <input type="hidden" name="purpose" :value="tab === 'buy' ? 'Buy' : (tab === 'rent' ? 'Rent' : '')">
              <input type="hidden" name="discounted" :value="tab === 'discounted' ? '1' : ''">
              <input type="hidden" name="lat" id="search-lat">
              <input type="hidden" name="lng" id="search-lng">

              <!-- Main Row: Location, Radius & Search Button -->
              <div class="flex flex-col md:flex-row gap-3 mb-6">
                <div class="relative flex-grow group">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
                  </div>
                  <input type="text" name="location" id="search-location" placeholder="e.g. 'London', 'SW1A' or 'Oxford'"
                    class="w-full pl-12 pr-4 py-4 text-lg font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-[56px] placeholder-gray-400">
                </div>

                <!-- Radius Select (Moved here) -->
                <div class="w-full md:w-48">
                  <select name="radius" class="select2-filter w-full" data-placeholder="Radius">
                    <option value="0.5">This area only</option>
                    <option value="1">+ 1 mile</option>
                    <option value="3">+ 3 miles</option>
                    <option value="5">+ 5 miles</option>
                    <option value="10">+ 10 miles</option>
                    <option value="15">+ 15 miles</option>
                    <option value="20">+ 20 miles</option>
                    <option value="30">+ 30 miles</option>
                    <option value="40">+ 40 miles</option>
                    <option value="50">+ 50 miles</option>
                  </select>
                </div>

                <button type="submit"
                  class="md:w-48 py-4 bg-secondary hover:bg-secondary-dark text-white font-bold rounded-xl shadow-xl shadow-secondary/20 transition-all flex items-center justify-center gap-2 font-effra h-[56px] group">
                  <span>Search</span>
                  <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </button>
              </div>

              <!-- Filters Grid -->
              <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Property Type (Moved from 2nd position to 1st) -->
                <div class="relative col-span-2 lg:col-span-1">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-house"></i></div>
                  <select name="property_type" class="select2-filter w-full" data-placeholder="Property type">
                    <option value="">Any Type</option>
                    @foreach(\App\Models\PropertyType::all() as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                  </select>
                </div>



                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-pound-sign"></i></div>
                  <input type="number" name="min_price" placeholder="Min Price"
                    class="w-full pl-12 pr-4 py-4 text-base font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-[56px] placeholder-gray-400 outline-none">
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-pound-sign"></i></div>
                  <input type="number" name="max_price" placeholder="Max Price"
                    class="w-full pl-12 pr-4 py-4 text-base font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-[56px] placeholder-gray-400 outline-none">
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bed"></i></div>
                  <select name="min_bedrooms" class="select2-filter w-full" data-placeholder="Bedrooms">
                    <option value="">Any Beds</option>
                    <option value="0">Studio</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}">{{ $i }} Bed{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10">10+ Beds</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bath"></i></div>
                  <select name="min_bathrooms" class="select2-filter w-full" data-placeholder="Bathrooms">
                    <option value="">Any Baths</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}">{{ $i }} Bath{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10">10+ Baths</option>
                  </select>
                </div>
              </div>
              <!-- Added some bottom padding space -->
              <div class="mb-5 md:mb-8"></div>
            </form>

            <!-- jQuery & Select2 JS -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>             $(document).ready(function () { $('.select2-filter').select2({ minimumResultsForSearch: 20, width: '100%', dropdownAutoWidth: true }); });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Browse by Category Section -->
  <section class="pt-4 pb-16 md:pt-80 md:pb-2 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-8 tracking-tight">Browse Properties</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
        @php
          $allTypes = \App\Models\PropertyType::all();
          // Helper to find ID by fuzzy name matching
          $getTypeId = function ($names) use ($allTypes) {
            if (!is_array($names))
              $names = [$names];
            foreach ($names as $name) {
              $t = $allTypes->first(function ($item) use ($name) {
                return stripos($item->title, $name) !== false;
              });
              if ($t)
                return $t->id;
            }
            return '';
          };

          $categories = [
            [
              'name' => 'Apartments',
              'icon' => 'fa-building',
              'params' => ['property_type' => $getTypeId(['Apartment', 'Flat'])]
            ],
            [
              'name' => 'Commercial',
              'icon' => 'fa-shop',
              'params' => ['property_type' => $getTypeId(['Commercial', 'Office', 'Retail', 'Shop'])]
            ],
            [
              'name' => 'Residential',
              'icon' => 'fa-house-chimney',
              'params' => ['property_type' => $getTypeId(['Residential', 'House', 'Villa', 'Bungalow'])]
            ],
            [
              'name' => 'Land',
              'icon' => 'fa-layer-group',
              'params' => ['property_type' => $getTypeId(['Land', 'Plot'])]
            ],
            [
              'name' => 'Discounted',
              'icon' => 'fa-percent',
              'params' => ['discounted' => '1']
            ],
            [
              'name' => 'Sell Yours',
              'icon' => 'fa-house-circle-check',
              'route' => 'register'
            ],
          ];
        @endphp
        @foreach($categories as $cat)
          <a href="{{ isset($cat['route']) ? route($cat['route']) : route('listings.index', $cat['params'] ?? []) }}"
            class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:border-secondary hover:shadow-xl hover:shadow-secondary/5 transition-all group h-full justify-center text-center">
            <div
              class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-primary group-hover:bg-secondary group-hover:text-white transition-colors mb-4 shadow-inner">
              <i class="fa-solid {{ $cat['icon'] }} text-2xl"></i>
            </div>
            <span
              class="font-bold text-gray-800 tracking-tight text-base group-hover:text-secondary transition-colors">{{ $cat['name'] }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  <style>
    .featured-swiper {
      height: 100%;
    }

    .featured-swiper .swiper-wrapper {
      align-items: stretch;
    }

    .featured-swiper .swiper-slide {
      height: auto !important;
    }
  </style>
  <!-- Featured Properties Section -->
  <section class="py-16 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-end mb-10">
        <div>
          <h2 class="text-3xl font-black text-primary tracking-tight">Featured Properties</h2>
          <p class="text-gray-500 mt-1 text-sm font-medium">Hand-picked homes from across the UK</p>
        </div>
        <a href="{{ route('listings.index') }}" class="text-secondary font-bold hover:underline flex items-center gap-2">
          View all properties <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
      </div>

      <div x-data="{ featuredTab: 'sale' }" class="min-h-[600px]">
        <div class="flex gap-4 mb-8">
          <button @click="featuredTab = 'sale'" class="px-8 py-3 rounded-xl font-bold transition-all shadow-sm"
            :class="featuredTab === 'sale' ? 'bg-primary text-white scale-105' : 'bg-white text-gray-500 hover:bg-gray-100'">Buy</button>
          <button @click="featuredTab = 'rent'" class="px-8 py-3 rounded-xl font-bold transition-all shadow-sm"
            :class="featuredTab === 'rent' ? 'bg-primary text-white scale-105' : 'bg-white text-gray-500 hover:bg-gray-100'">Rent</button>
        </div>

        <!-- Buy Listings -->
        <div x-show="featuredTab === 'sale'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
          @if($buyListings->count() > 0)
            <div class="swiper featured-swiper-results overflow-visible pb-12">
              <div class="swiper-wrapper">
                @foreach($buyListings as $listing)
                  <div class="swiper-slide h-auto">
                    @include('partials.property-card', ['listing' => $listing, 'user_favorite_ids' => $user_favorite_ids])
                  </div>
                @endforeach
              </div>
              <div class="swiper-pagination !-bottom-2"></div>
            </div>
          @else
            <div class="py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
              <i class="fa-solid fa-house-circle-exclamation text-4xl text-gray-200 mb-4"></i>
              <h3 class="text-xl font-bold text-gray-400">No properties available for sale.</h3>
            </div>
          @endif
        </div>

        <!-- Rent Listings -->
        <div x-show="featuredTab === 'rent'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
          @if($rentListings->count() > 0)
            <div class="swiper featured-swiper-results overflow-visible pb-12">
              <div class="swiper-wrapper">
                @foreach($rentListings as $listing)
                  <div class="swiper-slide h-auto">
                    @include('partials.property-card', ['listing' => $listing, 'user_favorite_ids' => $user_favorite_ids])
                  </div>
                @endforeach
              </div>
              <div class="swiper-pagination !-bottom-2"></div>
            </div>
          @else
            <div class="py-20 text-center bg-white rounded-3xl border-2 border-dashed border-gray-100">
              <i class="fa-solid fa-house-circle-exclamation text-4xl text-gray-200 mb-4"></i>
              <h3 class="text-xl font-bold text-gray-400">No rental properties featured yet.</h3>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Location Explorer Section -->
  <section class="py-3 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-10 text-center">
        <h2 class="text-3xl md:text-5xl font-black text-primary tracking-tight mb-4">Explore By Location</h2>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">Discover properties in the UK's most sought-after neighborhoods
        </p>
      </div>

      <div class="swiper location-swiper overflow-visible">
        <div class="swiper-wrapper">
          @foreach($propertyLocations as $location)
            <div class="swiper-slide h-auto">
              <a href="{{ route('listings.index', ['location' => $location->name, 'lat' => $location->latitude, 'lng' => $location->longitude, 'radius' => 50]) }}"
                class="group block relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 bg-white h-full flex flex-col">

                <!-- Background Image (Smaller fixed height) -->
                <div class="h-[180px] overflow-hidden relative flex-shrink-0">
                  <img
                    src="{{ $location->image ? asset('storage/' . $location->image) : asset('assets/img/all-images/hero/1.jpg') }}"
                    class="object-cover group-hover:scale-110 transition-transform duration-700" width="100%" height="50"
                    alt="{{ $location->name }}">
                </div>

                <!-- Content (Bottom white area) -->
                <div class="p-5 flex flex-col flex-grow bg-white">
                  <h3
                    class="text-lg font-black text-primary leading-tight group-hover:text-secondary transition-colors mb-2 line-clamp-1">
                    {{ $location->name }}
                  </h3>

                  <div class="flex items-center justify-between mt-auto">
                    <span
                      class="inline-block bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded-md">
                      {{ $location->listing_count }} Properties
                    </span>
                    </p>
                  </div>
                </div>

                <!-- Hover Action -->
                <div
                  class="absolute top-6 right-6 w-12 h-12 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-100 group-hover:bg-white group-hover:text-primary">
                  <i class="fa-solid fa-arrow-right"></i>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="swiper-pagination mt-12"></div>
      </div>
    </div>
  </section>

  <!-- Opportunity / Partner Section -->
  <!-- Opportunity / Partner Section -->
  <section class="py-16 bg-primary relative overflow-hidden">
    <!-- Decorative background -->
    <div
      class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary/10 rounded-full blur-[120px] -mr-64 -mt-64 pointer-events-none">
    </div>
    <div
      class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-secondary/5 rounded-full blur-[90px] -ml-20 -mb-20 pointer-events-none">
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <!-- Centered Header -->
      <div class="text-center mb-12">
        <div
          class="inline-flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded-full text-secondary font-bold text-[10px] uppercase tracking-widest mb-4 border border-white/5">
          <span class="w-1.5 h-1.5 bg-secondary rounded-full animate-pulse"></span> Partnership
        </div>
        <h2 class="text-3xl font-black text-white mb-3 tracking-tight">
          Grow With <span class="text-secondary">PropertyFinda</span>
        </h2>
        <p class="text-sm text-white/50 font-medium max-w-lg mx-auto leading-relaxed">
          Join our affiliate network and earn competitive commissions.
        </p>
      </div>

      <!-- Benefits Grid -->
      <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <!-- Card 1 -->
        <div
          class="bg-white/5 hover:bg-white/10 transition-colors border border-white/5 p-6 rounded-3xl backdrop-blur-sm group">
          <div
            class="w-10 h-10 rounded-xl bg-secondary/20 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-pound-sign text-lg"></i>
          </div>
          <div class="text-3xl font-black text-white mb-1">£{{ $affiliate_rate }}</div>
          <p class="text-white text-xs font-bold uppercase tracking-wide leading-relaxed">Per
            {{ number_format($affiliate_batch_size / 1000, 1) }}k visitors <br>referred
          </p>
        </div>

        <!-- Card 2 -->
        <div
          class="bg-white/5 hover:bg-white/10 transition-colors border border-white/5 p-6 rounded-3xl backdrop-blur-sm group">
          <div
            class="w-10 h-10 rounded-xl bg-secondary/20 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-bolt text-lg"></i>
          </div>
          <div class="text-2xl font-black text-white mb-1">Instant</div>
          <p class="text-white text-xs font-bold uppercase tracking-wide leading-relaxed">Approval & <br>Access</p>
        </div>

        <!-- Card 3 -->
        <div
          class="bg-white/5 hover:bg-white/10 transition-colors border border-white/5 p-6 rounded-3xl backdrop-blur-sm group">
          <div
            class="w-10 h-10 rounded-xl bg-secondary/20 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-chart-line text-lg"></i>
          </div>
          <div class="text-2xl font-black text-white mb-1">Tracking</div>
          <p class="text-white text-xs font-bold uppercase tracking-wide leading-relaxed">Advanced Live <br>Analytics
          </p>
        </div>

        <!-- Card 4 -->
        <div
          class="bg-white/5 hover:bg-white/10 transition-colors border border-white/5 p-6 rounded-3xl backdrop-blur-sm group">
          <div
            class="w-10 h-10 rounded-xl bg-secondary/20 flex items-center justify-center text-white mb-4 group-hover:scale-110 transition-transform">
            <i class="fa-solid fa-headset text-base"></i>
          </div>
          <div class="text-xl font-bold text-white mb-1">Support</div>
          <p class="text-white/70 text-[10px] font-bold uppercase tracking-wide leading-relaxed">Dedicated Partner Team
          </p>
        </div>
      </div>

      <!-- Compact CTA Bar -->
      <div
        class="bg-gradient-to-br from-white/10 to-white/5 border border-white/10 rounded-3xl p-2 pl-6 md:pl-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-center md:text-left py-4 md:py-0">
          <h3 class="text-white font-bold text-lg">Ready to start earning?</h3>
          <p class="text-white/50 text-xs font-medium">No payout thresholds. Monthly payments.</p>
        </div>

        <div class="w-full md:w-auto">
          @auth
            @if(auth()->user()->affiliate)
              <a href="{{ route('affiliate.dashboard') }}"
                class="flex items-center justify-center gap-2 bg-secondary text-white font-bold px-8 py-4 rounded-2xl hover:bg-secondary/90 transition-all shadow-lg hover:shadow-secondary/25 w-full md:w-auto">
                Dashboard <i class="fa-solid fa-gauge text-sm"></i>
              </a>
            @else
              <a href="{{ route('affiliate.register.view') }}"
                class="flex items-center justify-center gap-2 bg-white text-primary font-black px-8 py-4 rounded-2xl hover:bg-gray-50 transition-all shadow-lg w-full md:w-auto">
                Join Now <i class="fa-solid fa-arrow-right text-sm"></i>
              </a>
            @endif
          @else
            <a href="{{ route('affiliate.register.view') }}"
              class="flex items-center justify-center gap-2 bg-white text-primary font-black px-8 py-4 rounded-2xl hover:bg-gray-50 transition-all shadow-lg w-full md:w-auto">
              Join Now <i class="fa-solid fa-arrow-right text-sm"></i>
            </a>
          @endauth
        </div>
      </div>
    </div>
  </section>

  <!-- Trust Section -->
  <section class="py-4 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-4xl font-extrabold text-primary mb-16 tracking-tight">Everything You Need To Find A Home</h2>
      <div class="grid md:grid-cols-3 gap-12">
        <div class="group">
          <div class="text-secondary text-3xl mb-6 transition-transform group-hover:scale-110"><i
              class="fa-solid fa-shield"></i></div>
          <h3 class="text-xl font-bold mb-3">Verified Agents</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Every listing on PropertyFinda comes from registered, vetted UK
            estate agents.</p>
        </div>
        <div class="group">
          <div class="text-secondary text-3xl mb-6 transition-transform group-hover:scale-110"><i
              class="fa-solid fa-bolt"></i></div>
          <h3 class="text-xl font-bold mb-3">Instant Alerts</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Be the first to know. Get notified as soon as properties hit
            the market.</p>
        </div>
        <div class="group">
          <div class="text-secondary text-3xl mb-6 transition-transform group-hover:scale-110"><i
              class="fa-solid fa-map-location-dot"></i></div>
          <h3 class="text-xl font-bold mb-3">Market Data</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Access deep insights into local pricing, schools, and
            transport.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Latest News / Blogs Section -->
  <section class="py-4 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-end mb-12">
        <div>
          <h2 class="text-4xl font-black text-primary tracking-tight">Insights & News</h2>
          <p class="text-gray-500 mt-2 text-lg font-medium">The latest trends and advice in the UK property market</p>
        </div>
        <a href="{{ route('blog.list') }}"
          class="hidden md:flex items-center gap-2 text-secondary font-black uppercase tracking-widest text-xs hover:translate-x-1 transition-transform">
          Read All Articles <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>

      <div class="swiper blog-swiper overflow-visible">
        <div class="swiper-wrapper">
          @foreach($blogs as $blog)
            <div class="swiper-slide h-auto">
              <a href="{{ route('blog.show', $blog) }}" class="block h-full group">
                <div
                  class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 h-full flex flex-col">
                  <div class="relative h-64 overflow-hidden">
                    <img
                      src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('assets/img/all-images/hero/1.jpg') }}"
                      class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                      alt="{{ $blog->title }}">
                    <div class="absolute top-4 left-4">
                      <span
                        class="bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest text-primary shadow-sm">
                        {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Recent' }}
                      </span>
                    </div>
                  </div>
                  <div class="p-8 flex flex-col flex-grow">
                    <h3
                      class="text-xl font-black text-primary mb-4 line-clamp-2 leading-tight group-hover:text-secondary transition-colors">
                      {{ $blog->title }}
                    </h3>
                    <div class="text-gray-500 text-sm line-clamp-3 mb-6 font-medium leading-relaxed">
                      {!! Str::limit(strip_tags($blog->content), 120) !!}
                    </div>
                    <div class="mt-auto flex items-center justify-between pt-6 border-t border-gray-100">
                      <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                          <i class="fa-solid fa-user text-[10px]"></i>
                        </div>
                        <span
                          class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $blog->author ?? 'Expert Team' }}</span>
                      </div>
                      <div
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-primary group-hover:bg-black group-hover:text-white transition-all">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="mt-12 flex justify-center gap-4 md:hidden">
          <a href="{{ route('blog.list') }}"
            class="px-8 py-4 bg-white border border-gray-100 rounded-2xl text-xs font-black uppercase tracking-widest text-primary shadow-sm">
            View All News
          </a>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <!-- Swiper JS & CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Google Maps API with Places Library -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Initialize Google Places Autocomplete
      const locationInput = document.getElementById('search-location');
      if (locationInput && typeof google !== 'undefined') {
        const autocomplete = new google.maps.places.Autocomplete(locationInput, {
          types: ['geocode'],
          componentRestrictions: { country: 'uk' }
        });
        // Reset lat/lng when user types to ensure we don't use old coordinates for a new text search
        locationInput.addEventListener('input', function () {
          document.getElementById('search-lat').value = '';
          document.getElementById('search-lng').value = '';
        });
        autocomplete.addListener('place_changed', function () {
          const place = autocomplete.getPlace();
          if (!place.geometry) return;
          document.getElementById('search-lat').value = place.geometry.location.lat();
          document.getElementById('search-lng').value = place.geometry.location.lng();
        });
      }

      // Initialize Swiper for Each Featured Swiper instance individually
      document.querySelectorAll('.featured-swiper-results').forEach(el => {
        new Swiper(el, {
          slidesPerView: 1,
          spaceBetween: 24,
          autoHeight: false,
          loop: true,
          observer: true,
          observeParents: true,
          autoplay: { delay: 4000, disableOnInteraction: false },
          pagination: { el: el.querySelector('.swiper-pagination'), clickable: true, dynamicBullets: true },
          breakpoints: {
            768: { slidesPerView: 2, spaceBetween: 24 },
            1024: { slidesPerView: 3, spaceBetween: 32 }
          }
        });
      });

      // Initialize Location Swiper
      new Swiper('.location-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        observer: true,
        observeParents: true,
        autoplay: { delay: 4500, disableOnInteraction: false },
        pagination: { el: '.location-swiper .swiper-pagination', clickable: true },
        breakpoints: {
          640: { slidesPerView: 2, spaceBetween: 20 },
          768: { slidesPerView: 3, spaceBetween: 30 },
          1024: { slidesPerView: 4, spaceBetween: 30 }
        }
      });

      // Initialize Blog Swiper
      new Swiper('.blog-swiper', {
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        observer: true,
        observeParents: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        breakpoints: {
          768: { slidesPerView: 2, spaceBetween: 30 },
          1024: { slidesPerView: 3, spaceBetween: 30 }
        }
      });
    });

    function toggleFavorite(listingId, offMarketId, btn) {
      @if(!auth()->check())
        window.location.href = "{{ route('login') }}";
        return;
      @endif

                                                          const data = { _token: '{{ csrf_token() }}' };
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
        }
      });
    }
  </script>
@endpush