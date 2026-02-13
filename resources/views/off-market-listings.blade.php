@extends('layouts.modern')

@push('styles')
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

    /* Select2 Premium Styling */
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

    [x-cloak] { display: none !important; }
  </style>
@endpush

@section('title', 'Off Market Listings - FindaUk')

@section('content')
  <!-- Portal Hero Search Section -->
  <div class="relative bg-primary overflow-visible">
    <!-- Background Pattern -->
    <div class="absolute inset-0 z-0">
    <img src="{{ asset('hero22.jpg') }}"
         class="w-full h-full object-cover"
         alt="Background">
</div>


    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
      <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-secondary/20 backdrop-blur-md rounded-full border border-secondary/30 text-white text-xs font-black uppercase tracking-[0.2em] mb-6">
          <i class="fa-solid fa-lock "></i> Exclusive Portfolio
        </div>
        <h1 class="text-3xl md:text-6xl font-extrabold text-white mb-4 tracking-tight">
          Off-Market <span class="text-white">Opportunities</span>
        </h1>
        <p class="text-xl text-white font-medium max-w-3xl mx-auto">
          Access strictly confidential deals across the UK. Exclusive properties that never hit the open market, available only to our verified network.
        </p>
      </div>

      <!-- Main Portal Search Box -->
      <div class="bg-white rounded-2xl shadow-2xl overflow-visible max-w-5xl mx-auto p-2">
        <div x-data="{ tab: 'sale' }">
          <!-- Tabs Style -->
          <div class="flex p-1 bg-gray-100 rounded-xl mb-4">
            <button @click="tab = 'sale'" class="flex-1 py-3 text-base font-bold text-center transition-all rounded-lg"
              :class="tab === 'sale' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary'">
              For Sale
            </button>
            <button @click="tab = 'rent'" class="flex-1 py-3 text-base font-bold text-center transition-all rounded-lg"
              :class="tab === 'rent' ? 'bg-white text-primary shadow-sm' : 'text-gray-500 hover:text-primary'">
              To Rent
            </button>
          </div>

          <div class="p-4 md:p-6">
            <!-- For Sale Tab Content -->
            <div x-show="tab === 'sale'">
              <div class="flex flex-col md:flex-row gap-3 mb-6">
                <div class="relative flex-grow group">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                   
                  </div>
                  <input type="text" id="location-sale" placeholder="Enter city, area or postcode"
                    class="w-full pl-16 pr-4 py-4 text-lg font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-16 placeholder-gray-400">
                </div>
                
                <!-- Radius Select (Moved here) -->
                <div class="w-full md:w-48">
                  <select id="radius-sale" class="select2-filter w-full" data-placeholder="Radius">
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

                <button onclick="searchOffMarketProperties('sale')"
                  class="md:w-64 px-10 bg-secondary hover:bg-secondary-dark text-white font-extrabold text-xl rounded-xl shadow-lg shadow-secondary/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 h-16">
                  Search
                </button>
              </div>

              <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
                <!-- Property Type (Moved to first position) -->
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-house text-secondary"></i></div>
                  <select id="property-type-sale" class="select2-filter w-full" data-placeholder="Property Type">
                    <option value="">Any Type</option>
                    @foreach(\App\Models\PropertyType::all() as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Unit Type (New) -->
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-building text-secondary"></i></div>
                  <select id="unit-type-sale" class="select2-filter w-full" data-placeholder="Unit Type">
                    <option value="">Any Unit</option>
                    @foreach(\App\Models\UnitType::all() as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-sterling-sign text-secondary"></i></div>
                  <select id="min-price-sale" class="select2-filter w-full" data-placeholder="Min Price">
                    <option value="">No Min</option>
                    <option value="100000">£100,000</option>
                    <option value="250000">£250,000</option>
                    <option value="500000">£500,000</option>
                    <option value="1000000">£1,000,000</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-sterling-sign text-secondary"></i></div>
                  <select id="max-price-sale" class="select2-filter w-full" data-placeholder="Max Price">
                    <option value="">No Max</option>
                    <option value="500000">£500,000</option>
                    <option value="1000000">£1,000,000</option>
                    <option value="5000000">£5,000,000</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bed text-secondary"></i></div>
                  <select id="min-bedrooms-sale" class="select2-filter w-full" data-placeholder="Bedrooms">
                    <option value="">Any Beds</option>
                    <option value="0">Studio</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}">{{ $i }} Bed{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10">10+ Beds</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bath text-secondary"></i></div>
                  <select id="min-bathrooms-sale" class="select2-filter w-full" data-placeholder="Bathrooms">
                    <option value="">Any Baths</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}">{{ $i }} Bath{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10">10+ Baths</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- For Rent Tab Content -->
            <div x-show="tab === 'rent'" x-cloak>
              <div class="flex flex-col md:flex-row gap-3 mb-6">
                <div class="relative flex-grow group">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <i class="fa-solid fa-location-dot text-gray-400 text-lg"></i>
                  </div>
                  <input type="text" id="location-rent" placeholder="Enter city, area or postcode"
                    class="w-full pl-16 pr-4 py-4 text-lg font-medium text-gray-900 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all h-16 placeholder-gray-400">
                </div>
                
                <!-- Radius Select (Moved here) -->
                <div class="w-full md:w-48">
                  <select id="radius-rent" class="select2-filter w-full" data-placeholder="Radius">
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

                <button onclick="searchOffMarketProperties('rent')"
                  class="md:w-64 px-10 bg-secondary hover:bg-secondary-dark text-white font-extrabold text-xl rounded-xl shadow-lg shadow-secondary/20 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 h-16">
                  Search
                </button>
              </div>

              <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
                <!-- Property Type (Moved to first position) -->
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-house text-secondary"></i></div>
                  <select id="property-type-rent" class="select2-filter w-full" data-placeholder="Property Type">
                    <option value="">Any Type</option>
                    @foreach(\App\Models\PropertyType::all() as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                  </select>
                </div>

                <!-- Unit Type (New) -->
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-building text-secondary"></i></div>
                  <select id="unit-type-rent" class="select2-filter w-full" data-placeholder="Unit Type">
                    <option value="">Any Unit</option>
                    @foreach(\App\Models\UnitType::all() as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-sterling-sign text-secondary"></i></div>
                  <select id="min-price-rent" class="select2-filter w-full" data-placeholder="Min Price">
                    <option value="">No Min</option>
                    <option value="500">£500 pcm</option>
                    <option value="1000">£1,000 pcm</option>
                    <option value="1500">£1,500 pcm</option>
                    <option value="2000">£2,000 pcm</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-sterling-sign text-secondary"></i></div>
                  <select id="max-price-rent" class="select2-filter w-full" data-placeholder="Max Price">
                    <option value="">No Max</option>
                    <option value="1000">£1,000 pcm</option>
                    <option value="2000">£2,000 pcm</option>
                    <option value="5000">£5,000 pcm</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bed text-secondary"></i></div>
                  <select id="min-bedrooms-rent" class="select2-filter w-full" data-placeholder="Bedrooms">
                    <option value="">Any Beds</option>
                    <option value="0">Studio</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}">{{ $i }} Bed{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10">10+ Beds</option>
                  </select>
                </div>
                <div class="relative">
                  <div class="filter-icon-wrapper"><i class="fa-solid fa-bath text-secondary"></i></div>
                  <select id="min-bathrooms-rent" class="select2-filter w-full" data-placeholder="Bathrooms">
                    <option value="">Any Baths</option>
                    @for($i = 1; $i <= 9; $i++)
                      <option value="{{ $i }}">{{ $i }} Bath{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                    <option value="10">10+ Baths</option>
                  </select>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--===== HERO AREA ENDS =======-->
  <!--===== PROPERTIES GRID STARTS =======-->
  <div class="pb-24 bg-[#F9FAFB] mt-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-end mb-12">
        <div>
          <h2 class="text-4xl font-black text-primary mb-2">Available Opportunities</h2>
          <p class="text-gray-500 font-bold">Confidential off-market deals currently available.</p>
        </div>
        <div class="hidden md:block">
          <span class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-black uppercase tracking-widest text-gray-400">
            Sorted by: Exclusive First
          </span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($offMarketListings as $listing)
          <div class="h-full">
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 h-full flex flex-col group">
              <div class="relative h-64 overflow-hidden shrink-0">
                <a href="{{ route('off-market-listing.show', $listing->id) }}">
                  @php 
                    $gallery = is_array($listing->gallery) ? $listing->gallery : json_decode($listing->gallery, true) ?? []; 
                  @endphp
                  <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : (isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg')) }}" 
                       class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Listing">
                </a>
                
                <div class="absolute top-4 left-4 flex flex-col gap-2">
                  <div class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-xl text-primary font-bold shadow-sm whitespace-nowrap">
                    £{{ number_format($listing->price) }}
                  </div>
                  <span class="px-3 py-1 bg-secondary text-white rounded-md text-[10px] font-black uppercase tracking-widest w-fit">Off-Market</span>
                </div>

                <button onclick="toggleFavorite(null, {{ $listing->id }}, this)" 
                  class="absolute top-4 right-4 w-10 h-10 bg-white/95 backdrop-blur-sm rounded-full flex items-center justify-center {{ in_array($listing->id, $user_favorite_off_market_ids ?? []) ? 'text-red-500' : 'text-gray-400' }} hover:text-red-500 transition-colors shadow-sm">
                  <i class="{{ in_array($listing->id, $user_favorite_off_market_ids ?? []) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                </button>
              </div>
              
              <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-primary mb-2">
                  <a href="{{ route('off-market-listing.show', $listing->id) }}" class="hover:text-secondary transition-colors">
                    {{ $listing->property_title }}
                  </a>
                </h3>
                
                <p class="text-gray-500 mb-6 flex items-center gap-2">
                  <i class="fa-solid fa-location-dot text-gray-300"></i>
                  {{ Str::limit($listing->address, 45) ?? 'Location Confidential' }}
                </p>
                
                <div class="mt-auto grid grid-cols-2 gap-4 pt-6 border-t border-gray-50">
                  <div class="flex items-center gap-2 text-gray-700 font-medium">
                    <i class="fa-solid fa-bed text-gray-400"></i> {{ $listing->bedrooms }} Bedrooms
                  </div>
                  <div class="flex items-center gap-2 text-gray-700 font-medium text-right justify-end">
                    <i class="fa-solid fa-bath text-gray-400"></i> {{ $listing->bathrooms }} Baths
                  </div>
                </div>

                <div class="mt-4 flex gap-2 pt-4 border-t border-gray-50">
                  <a href="https://wa.me/{{ $listing->user?->phone_number }}?text=Interested%20in%20Of-Market%20{{ urlencode($listing->property_title) }}"
                      class="flex-1 text-center py-2 px-2 bg-green-500 text-white rounded-lg text-xs font-bold hover:bg-green-600 transition-colors flex items-center justify-center gap-1" target="_blank">
                      <i class="fab fa-whatsapp"></i> WhatsApp
                  </a>
                  <a href="mailto:{{ $listing->user?->email }}?subject=Enquiry%20about%20Off-Market%20{{ urlencode($listing->property_title) }}"
                      class="flex-1 text-center py-2 px-2 bg-blue-500 text-white rounded-lg text-xs font-bold hover:bg-blue-600 transition-colors flex items-center justify-center gap-1">
                      <i class="fa-regular fa-envelope"></i> Email
                  </a>
                  <a href="{{ route('off-market-listing.show', $listing->id) }}"
                      class="flex-1 text-center py-2 px-2 border border-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-50 transition-colors flex items-center justify-center gap-1">
                      Details
                  </a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-span-full py-20 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fa-solid fa-magnifying-glass text-2xl text-gray-300"></i>
            </div>
            <h3 class="text-2xl font-black text-primary">No properties found</h3>
            <p class="text-gray-500 font-bold mt-2">Try adjusting your filters to see more confidential deals.</p>
          </div>
        @endforelse
      </div>
      <!-- Pagination -->
      <div class="mt-12">
        {{ $offMarketListings->links() }}
      </div>
    </div>
  </div>
  <!--===== PROPERTIES GRID ENDS =======-->
  <style>
    /* Custom styles for Google Places Autocomplete */
    .pac-container {
      z-index: 1051 !important;
      /* Higher than Bootstrap modal's z-index */
    }
  </style>

  <script>
    // Load Google Maps API
    function loadGoogleMapsAPI() {
      const script = document.createElement('script');
      script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initLocationAutocomplete';
      script.async = true;
      script.defer = true;
      document.head.appendChild(script);
    }

    // Variables to store coordinates
    let selectedLatSale = null;
    let selectedLngSale = null;
    let selectedLatRent = null;
    let selectedLngRent = null;

    function initLocationAutocomplete() {
      // Initialize Google Places Autocomplete for sale tab
      const locationInputSale = document.getElementById('location-sale');
      if (locationInputSale) {
        const options = {
          componentRestrictions: { country: 'gb' },
          fields: ['geometry', 'formatted_address', 'name', 'place_id'],
          types: ['geocode', 'establishment']
        };
        const autocompleteSale = new google.maps.places.Autocomplete(locationInputSale, options);
        
        // Reset stored coordinates when user types to avoid using old coordinates with new text
        locationInputSale.addEventListener('input', function() {
            selectedLatSale = null;
            selectedLngSale = null;
        });

        autocompleteSale.addListener('place_changed', function () {
          const place = autocompleteSale.getPlace();
          if (place.geometry) {
            // Store coordinates for radius search
            selectedLatSale = place.geometry.location.lat();
            selectedLngSale = place.geometry.location.lng();
            console.log('Location selected for sale:', place.formatted_address, 'Lat:', selectedLatSale, 'Lng:', selectedLngSale);
          }
        });
      }

      // Initialize Google Places Autocomplete for rent tab
      const locationInputRent = document.getElementById('location-rent');
      if (locationInputRent) {
        const options = {
          componentRestrictions: { country: 'gb' },
          fields: ['geometry', 'formatted_address', 'name', 'place_id'],
          types: ['geocode', 'establishment']
        };
        const autocompleteRent = new google.maps.places.Autocomplete(locationInputRent, options);

        // Reset stored coordinates when user types
        locationInputRent.addEventListener('input', function() {
            selectedLatRent = null;
            selectedLngRent = null;
        });

        autocompleteRent.addListener('place_changed', function () {
          const place = autocompleteRent.getPlace();
          if (place.geometry) {
            // Store coordinates for radius search
            selectedLatRent = place.geometry.location.lat();
            selectedLngRent = place.geometry.location.lng();
            console.log('Location selected for rent:', place.formatted_address, 'Lat:', selectedLatRent, 'Lng:', selectedLngRent);
          }
        });
      }
    }

    function searchOffMarketProperties(tab) {
      // Determine purpose based on the active tab, not the dropdown value
      let purpose;
      if (tab === 'sale') {
        purpose = 'Buy';  // For Sale tab should always use 'Buy' purpose
      } else if (tab === 'rent') {
        purpose = 'Rent';  // For Rent tab should always use 'Rent' purpose
      } else {
        purpose = document.getElementById(`purpose-${tab}`).value;
      }

      const location = document.getElementById(`location-${tab}`).value;
      const radius = document.getElementById(`radius-${tab}`).value;

      // Get customize filter values
      const propertyType = document.getElementById(`property-type-${tab}`)?.value;
      const unitType = document.getElementById(`unit-type-${tab}`)?.value;
      const minPrice = document.getElementById(`min-price-${tab}`)?.value;
      const maxPrice = document.getElementById(`max-price-${tab}`)?.value;
      const minSize = document.getElementById(`min-size-${tab}`)?.value;
      const maxSize = document.getElementById(`max-size-${tab}`)?.value;
      const minBedrooms = document.getElementById(`min-bedrooms-${tab}`)?.value;
      const minBathrooms = document.getElementById(`min-bathrooms-${tab}`)?.value;
      const ownershipStatus = document.getElementById(`ownership-status-${tab}`)?.value;
      const rentFrequency = document.getElementById(`rent-frequency-${tab}`)?.value;
      const chequeOptions = document.getElementById(`cheque-options-${tab}`)?.value;

      // Get selected features (checkboxes)
      const featureCheckboxes = document.querySelectorAll(`input[name="features-${tab}[]"]:checked`);
      let features = [];
      featureCheckboxes.forEach(checkbox => {
        features.push(checkbox.value);
      })

      // Build query parameters
      const params = new URLSearchParams();
      if (purpose) params.append('purpose', purpose);

      // Use coordinates if available, otherwise use location name
      if (tab === 'sale' && selectedLatSale && selectedLngSale) {
        params.append('lat', selectedLatSale);
        params.append('lng', selectedLngSale);
        if (location) params.append('location', location); // Add location name too
      } else if (tab === 'rent' && selectedLatRent && selectedLngRent) {
        params.append('lat', selectedLatRent);
        params.append('lng', selectedLngRent);
        if (location) params.append('location', location); // Add location name too
      } else if (location) {
        params.append('location', location);
      }

      if (radius) params.append('radius', radius);
      if (propertyType) params.append('property_type_id', propertyType);
      if (unitType) params.append('unit_type_id', unitType);
      if (minPrice) params.append('min_price', minPrice);
      if (maxPrice) params.append('max_price', maxPrice);
      if (minSize) params.append('min_size', minSize);
      if (maxSize) params.append('max_size', maxSize);
      if (minBedrooms) params.append('min_bedrooms', minBedrooms);
      if (minBathrooms) params.append('min_bathrooms', minBathrooms);
      if (ownershipStatus) params.append('ownership_status_id', ownershipStatus);
      if (rentFrequency) params.append('rent_frequency_id', rentFrequency);
      if (chequeOptions) params.append('cheque_id', chequeOptions);
      if (features.length > 0) params.append('features', features.join(','));

      // Redirect to off-market listings page with filters
      window.location.href = `{{ route('off-market-listings.index') }}?${params.toString()}`;
    }

    // Handle customize filter toggle
    function toggleCustomizeFilter(tab) {
      const form = document.getElementById(`customize-form-${tab}`);
      const button = document.getElementById(`customize-${tab}`);

      if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        button.classList.add('active');
        button.innerHTML = 'Hide <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg></span>';
      } else {
        form.style.display = 'none';
        button.classList.remove('active');
        button.innerHTML = 'Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z"/></svg></span>';
      }
    }

    // Load Google Maps API when DOM is ready
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
      document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
    } else {
      // Google Maps API is already loaded
      initLocationAutocomplete();
    }
  </script>

  <!-- jQuery & Select2 JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2-filter').select2({
        width: '100%',
        minimumResultsForSearch: Infinity
      });
    });
  </script>
  <script src="{{ asset('js/currency-converter.js') }}"></script>
  <script>
    // Initialize currency converter
    document.addEventListener('DOMContentLoaded', function () {
      if (typeof initializeCurrencyConverter === 'function') {
        initializeCurrencyConverter();
      }
    });

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
        success: function(res) {
          if (res.status === 'added') {
            $(btn).removeClass('text-gray-400').addClass('text-red-500');
            icon.removeClass('fa-regular').addClass('fa-solid');
          } else {
            $(btn).removeClass('text-red-500').addClass('text-gray-400');
            icon.removeClass('fa-solid').addClass('fa-regular');
          }
        },
        error: function() {
          alert('Something went wrong. Please try again.');
        }
      });
    }
  </script>

@endsection