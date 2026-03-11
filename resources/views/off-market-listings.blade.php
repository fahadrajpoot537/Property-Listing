@extends('layouts.modern')

@push('styles')
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

    [x-cloak] {
      display: none !important;
    }
  </style>
@endpush

@section('title', 'Off Market Listings - PropertyFinda')

@section('content')
  <!-- Portal Hero Search Section -->
  <div class="relative bg-primary overflow-visible flex flex-col">
    <!-- Background Pattern -->
    <div class="absolute inset-0 z-0">
      <img src="{{ asset('hero22.jpg') }}" class="w-full h-full object-cover" alt="Background">
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24 md:pt-20 md:pb-48">
      <div class="text-center mb-10">
        <div
          class="inline-flex items-center gap-2 px-4 py-2 bg-secondary/20 backdrop-blur-md rounded-full border border-secondary/30 text-white text-xs font-black uppercase tracking-[0.2em] mb-6">
          <i class="fa-solid fa-lock "></i> Exclusive Portfolio
        </div>
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 tracking-tight"
          style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
          Off-Market <span class="text-white">Opportunities</span>
        </h1>
        <p class="text-lg text-white font-medium max-w-3xl mx-auto drop-shadow-md">
          Access strictly confidential deals across the UK. Exclusive properties that never hit the open market, available
          only to our verified network.
        </p>
      </div>

      <!-- Main Portal Search Box (Homepage Design) -->
      <div
        class="bg-white rounded-2xl md:rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] overflow-visible max-w-5xl mx-auto p-2 md:p-3 relative z-20 -mb-24 md:-mb-52 border border-gray-100">
        <div x-data="{ tab: '{{ request('purpose') == 'Rent' ? 'rent' : 'buy' }}' }">
          <!-- Tabs Style -->
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

          <div class="p-4 md:p-6">
            <form action="{{ route('off-market-listings.index') }}" method="GET" id="off-market-search-form">
              <input type="hidden" name="purpose" :value="tab === 'buy' ? 'Buy' : 'Rent'">
              <input type="hidden" name="lat" id="search-lat" value="{{ request('lat') }}">
              <input type="hidden" name="lng" id="search-lng" value="{{ request('lng') }}">

              <!-- Main Row: Location, Radius & Search Button -->
              <div class="flex flex-col md:flex-row gap-3 mb-6">
                <div class="relative flex-grow group">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
                  </div>
                  <input type="text" name="location" id="search-location" placeholder="e.g. 'London', 'SW1A' or 'Oxford'"
                    value="{{ request('location') }}"
                    class="w-full pl-12 pr-4 py-4 text-lg font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-[56px] placeholder-gray-400">
                </div>

                <!-- Radius Select -->
                <div class="w-full md:w-48">
                  <select name="radius" class="select2-filter w-full" data-placeholder="Radius">
                    <option value="0.5" {{ request('radius') == '0.5' ? 'selected' : '' }}>This area only</option>
                    <option value="1" {{ request('radius') == '1' ? 'selected' : '' }}>1 mile</option>
                    <option value="3" {{ request('radius') == '3' ? 'selected' : '' }}>3 miles</option>
                    <option value="5" {{ request('radius') == '5' ? 'selected' : '' }}>5 miles</option>
                    <option value="10" {{ request('radius') == '10' ? 'selected' : '' }}>10 miles</option>
                    <option value="15" {{ request('radius') == '15' ? 'selected' : '' }}>15 miles</option>
                    <option value="20" {{ request('radius') == '20' ? 'selected' : '' }}>20 miles</option>
                    <option value="50" {{ request('radius') == '50' ? 'selected' : '' }}>+ 50 miles</option>
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
                <!-- Property Type -->
                <div class="relative col-span-2 lg:col-span-1">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-house"></i></div>
                  <select name="property_type" class="select2-filter w-full" data-placeholder="Property type">
                    <option value="">Any Type</option>
                    @foreach($propertyTypes as $type)
                      <option value="{{ $type->id }}" {{ (request('property_type_id') == $type->id || request('property_type') == $type->id) ? 'selected' : '' }}>
                        {{ $type->title }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-pound-sign"></i></div>
                  <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}"
                    class="w-full pl-12 pr-4 py-4 text-base font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-[56px] placeholder-gray-400 outline-none">
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-pound-sign"></i></div>
                  <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}"
                    class="w-full pl-12 pr-4 py-4 text-base font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-[56px] placeholder-gray-400 outline-none">
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bed"></i></div>
                  <select name="min_bedrooms" class="select2-filter w-full" data-placeholder="Min Bedrooms">
                    <option value="">Min Beds</option>
                    <option value="0" {{ request('min_bedrooms') === '0' ? 'selected' : '' }}>Studio</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}" {{ request('min_bedrooms') == $i ? 'selected' : '' }}>{{ $i }}
                        Bed{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10" {{ request('min_bedrooms') == '10' ? 'selected' : '' }}>10+ Beds</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bath"></i></div>
                  <select name="min_bathrooms" class="select2-filter w-full" data-placeholder="Min Bathrooms">
                    <option value="">Min Baths</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}" {{ request('min_bathrooms') == $i ? 'selected' : '' }}>{{ $i }}
                        Bath{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10" {{ request('min_bathrooms') == '10' ? 'selected' : '' }}>10+ Baths</option>
                  </select>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--===== HERO AREA ENDS =======-->
  <!--===== PROPERTIES GRID STARTS =======-->
  <div class="pt-16 sm:pt-24 md:pt-32 lg:pt-40 pb-24 bg-[#F9FAFB] mt-0 relative z-10" id="listings-section"
    x-data="{ resultsTab: '{{ request('purpose') == 'Rent' ? 'rent' : 'buy' }}' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
        <div>
          <h2 class="text-3xl font-black text-primary mb-1">Available Opportunities</h2>
          <p class="text-gray-500 font-bold text-sm">Confidential off-market deals currently available.</p>

          <!-- Quick Tabs Filter - Alpine Style like Home -->
          <div class="flex gap-2 mt-6 p-1 bg-gray-100 rounded-2xl w-fit">
            <button @click="resultsTab = 'buy'"
              class="px-8 py-2.5 rounded-xl font-black transition-all text-sm uppercase tracking-wider"
              :class="resultsTab === 'buy' ? 'bg-primary text-white shadow-lg' : 'text-gray-500 hover:text-primary'">Buy</button>
            <button @click="resultsTab = 'rent'"
              class="px-8 py-2.5 rounded-xl font-black transition-all text-sm uppercase tracking-wider"
              :class="resultsTab === 'rent' ? 'bg-primary text-white shadow-lg' : 'text-gray-500 hover:text-primary'">Rent</button>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="relative">
            <select id="sort-select" onchange="applySort(this.value)"
              class="appearance-none block w-full pl-3 pr-8 py-2 border border-blue-100 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-secondary text-sm h-[42px] shadow-sm font-bold text-gray-600 bg-white"
              style="min-width: 150px;">
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest listed</option>
              <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest listed</option>
              <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price (Lowest)</option>
              <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price (Highest)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="listing-results">
        <!-- Buy Tab (Alpine) -->
        <div x-show="resultsTab === 'buy'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

          @if($buyListings->count() > 0)
            <div class="swiper off-market-swiper-results overflow-visible pb-12">
              <div class="swiper-wrapper">
                @foreach($buyListings as $listing)
                  <div class="swiper-slide h-auto">
                    @include('partials.property-card', ['listing' => $listing, 'user_favorite_off_market_ids' => $user_favorite_off_market_ids])
                  </div>
                @endforeach
              </div>
              <div class="swiper-pagination !-bottom-2"></div>
            </div>
          @else
            <div class="py-20 text-center bg-white rounded-3xl border border-dashed border-gray-100">
              <p class="text-gray-400 font-bold">No off-market sale opportunities found.</p>
            </div>
          @endif

          <div class="mt-8 flex justify-center">
            {{ $buyListings->appends(['purpose' => 'Buy'])->links() }}
          </div>
        </div>

        <!-- Rent Tab (Alpine) -->
        <div x-show="resultsTab === 'rent'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>

          @if($rentListings->count() > 0)
            <div class="swiper off-market-swiper-results overflow-visible pb-12">
              <div class="swiper-wrapper">
                @foreach($rentListings as $listing)
                  <div class="swiper-slide h-auto">
                    @include('partials.property-card', ['listing' => $listing, 'user_favorite_off_market_ids' => $user_favorite_off_market_ids])
                  </div>
                @endforeach
              </div>
              <div class="swiper-pagination !-bottom-2"></div>
            </div>
          @else
            <div class="py-20 text-center bg-white rounded-3xl border border-dashed border-gray-100">
              <p class="text-gray-400 font-bold">No off-market rental opportunities found.</p>
            </div>
          @endif

          <div class="mt-8 flex justify-center">
            {{ $rentListings->appends(['purpose' => 'Rent'])->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Load Google Maps API
    function loadGoogleMapsAPI() {
      const script = document.createElement('script');
      script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initLocationAutocomplete';
      script.async = true;
      script.defer = true;
      document.head.appendChild(script);
    }

    function initLocationAutocomplete() {
      const locationInput = document.getElementById('search-location');
      if (locationInput) {
        const options = {
          componentRestrictions: { country: 'gb' },
          fields: ['geometry', 'formatted_address', 'name', 'place_id'],
          types: ['geocode', 'establishment']
        };
        const autocomplete = new google.maps.places.Autocomplete(locationInput, options);

        // Reset stored coordinates when user types
        locationInput.addEventListener('input', function () {
          const latInput = document.getElementById('search-lat');
          const lngInput = document.getElementById('search-lng');
          if (latInput) latInput.value = '';
          if (lngInput) lngInput.value = '';
        });

        autocomplete.addListener('place_changed', function () {
          const place = autocomplete.getPlace();
          if (place.geometry) {
            const latInput = document.getElementById('search-lat');
            const lngInput = document.getElementById('search-lng');
            if (latInput) latInput.value = place.geometry.location.lat();
            if (lngInput) lngInput.value = place.geometry.location.lng();
            console.log('Location selected:', place.formatted_address, 'Lat:', place.geometry.location.lat(), 'Lng:', place.geometry.location.lng());
          }
        });
      }
    }

    // Load Google Maps API when DOM is ready
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
      document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
    } else {
      initLocationAutocomplete();
    }
  </script>
  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/currency-converter.js') }}"></script>
    <script>
      $(document).ready(function () {
        $('.select2-filter').select2({
          width: '100%',
          minimumResultsForSearch: Infinity
        });

        // Initialize Off-Market Carousel Results
        document.querySelectorAll('.off-market-swiper-results').forEach(el => {
          new Swiper(el, {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            observer: true,
            observeParents: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: el.querySelector('.swiper-pagination'), clickable: true, dynamicBullets: true },
            breakpoints: {
              768: { slidesPerView: 2, spaceBetween: 24 },
              1024: { slidesPerView: 3, spaceBetween: 24 }
            }
          });
        });

        if (typeof initializeCurrencyConverter === 'function') {
          initializeCurrencyConverter();
        }
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
          },
          error: function () {
            alert('Something went wrong. Please try again.');
          }
        });
      }

      function applySort(sort) {
        const params = new URLSearchParams(window.location.search);
        params.set('sort', sort);
        window.location.href = window.location.pathname + '?' + params.toString();
      }
    </script>
  @endpush

@endsection