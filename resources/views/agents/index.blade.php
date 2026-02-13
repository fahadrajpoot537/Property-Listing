@extends('layouts.modern')

@section('title', 'Find Estate Agents Near You - PropertyFinda')

@push('styles')
    <style>
        .agent-card {
            transition: all 0.3s ease;
        }

        .agent-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .search-container {
            background: linear-gradient(135deg, #131B31 0%, #1a2544 100%);
        }

        .radius-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #8046F1;
            cursor: pointer;
        }

        .radius-slider::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #8046F1;
            cursor: pointer;
            border: none;
        }
    </style>
@endpush

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <!-- Hero Section with Search -->
        <div class="search-container pt-32 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <h1 class="text-4xl md:text-5xl font-black text-white mb-2">Find Estate Agents Near You</h1>
                    <p class="text-xl text-gray-300 font-medium">Search by location and radius to find the best agents in
                        your area</p>
                </div>

                <!-- Search Form -->
                <div class="bg-white rounded-3xl p-8 shadow-2xl max-w-4xl mx-auto">
                    <form method="GET" action="{{ route('agents.index') }}" id="agentSearchForm">
                        <div class="space-y-6">
                            <!-- Location Search -->
                            <div>
                                <label for="location"
                                    class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2 block">
                                    <i class="fa-solid fa-location-dot text-secondary mr-2"></i>Search Location
                                </label>
                                <input type="text" id="location" name="location" value="{{ request('location') }}"
                                    class="w-full px-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:bg-white focus:ring-4 focus:ring-secondary/10 focus:border-secondary transition-all outline-none font-medium text-lg"
                                    placeholder="Enter postcode or area (e.g., London, SW1A 1AA)">
                                <input type="hidden" id="latitude" name="latitude" value="{{ request('latitude') }}">
                                <input type="hidden" id="longitude" name="longitude" value="{{ request('longitude') }}">
                            </div>

                            <!-- Radius Slider -->
                            <div>
                                <label class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-2 block">
                                    <i class="fa-solid fa-circle-dot text-secondary mr-2"></i>Search Radius: <span
                                        id="radiusValue" class="text-secondary">{{ request('radius', 10) }}</span> miles
                                </label>
                                <input type="range" id="radius" name="radius" min="1" max="50"
                                    value="{{ request('radius', 10) }}"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer radius-slider"
                                    oninput="document.getElementById('radiusValue').textContent = this.value">
                            </div>

                            <!-- Search Button -->
                            <button type="submit"
                                class="w-full py-4 bg-secondary hover:bg-secondary/90 text-white font-extrabold text-lg rounded-2xl shadow-xl shadow-secondary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                Search Agents
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Agents Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            @if(request()->filled(['latitude', 'longitude']))
                <div class="mb-8 bg-white p-6 rounded-2xl border-l-4 border-secondary">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-location-crosshairs text-secondary text-2xl"></i>
                        <div>
                            <p class="font-bold text-gray-900">Showing agents within {{ request('radius', 10) }} miles of your
                                location</p>
                            <p class="text-sm text-gray-600">{{ $agents->total() }} agent(s) found</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($agents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($agents as $agent)
                        <div class="agent-card bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-lg">
                            <!-- Agent Header -->
                            <div class="bg-gradient-to-r from-primary to-primary/80 p-6 text-white">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-2xl font-black text-black">
                                        {{ strtoupper(substr($agent->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-black text-black">{{ $agent->name }}</h3>
                                        @if(isset($agent->distance))
                                            <p class="text-sm text-black flex items-center gap-1">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ number_format($agent->distance, 1) }} miles away
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Agent Info -->
                            <div class="p-6 space-y-4">
                                @if($agent->address)
                                    <div class="flex items-start gap-3 text-sm">
                                        <i class="fa-solid fa-map-marker-alt text-secondary mt-1"></i>
                                        <span class="text-gray-600">{{ $agent->address }}</span>
                                    </div>
                                @endif

                                @if($agent->phone_number)
                                    <div class="flex items-center gap-3 text-sm">
                                        <i class="fa-solid fa-phone text-secondary"></i>
                                        <a href="tel:{{ $agent->phone_number }}" class="text-gray-600 hover:text-secondary font-medium">
                                            {{ $agent->phone_number }}
                                        </a>
                                    </div>
                                @endif

                                @if($agent->email)
                                    <div class="flex items-center gap-3 text-sm">
                                        <i class="fa-solid fa-envelope text-secondary"></i>
                                        <a href="mailto:{{ $agent->email }}" class="text-gray-600 hover:text-secondary font-medium">
                                            {{ $agent->email }}
                                        </a>
                                    </div>
                                @endif

                                <!-- Active Listings -->
                                @if($agent->listings->count() > 0)
                                    <div class="pt-4 border-t border-gray-100">
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Active Listings
                                            ({{ $agent->listings->count() }})</p>
                                        <div class="space-y-2">
                                            @foreach($agent->listings->take(2) as $listing)
                                                <a href="{{ route('listing.show', $listing->id) }}" class="block group">
                                                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors">
                                                        @if($listing->thumbnail)
                                                            <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                                                alt="{{ $listing->property_title }}" class="w-12 h-12 object-cover rounded-lg">
                                                        @endif
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-bold text-gray-900 truncate group-hover:text-secondary">
                                                                {{ $listing->property_title }}
                                                            </p>
                                                            <p class="text-xs text-secondary font-bold">
                                                                £{{ number_format($listing->price) }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Contact Button -->
                                <button onclick="contactAgent('{{ $agent->name }}', '{{ $agent->email }}')"
                                    class="w-full mt-4 py-3 bg-secondary hover:bg-secondary/90 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Contact Agent
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $agents->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <i class="fa-solid fa-user-slash text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-black text-gray-900 mb-3">No Agents Found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search location or increasing the radius</p>
                    <a href="{{ route('agents.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-secondary text-white font-bold rounded-xl hover:bg-secondary/90 transition-all">
                        <i class="fa-solid fa-rotate-right"></i>
                        Reset Search
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            let autocomplete;

            function initAutocomplete() {
                const locationInput = document.getElementById('location');

                if (!locationInput) return;

                // Initialize autocomplete
                autocomplete = new google.maps.places.Autocomplete(locationInput, {
                    componentRestrictions: { country: 'gb' },
                    fields: ['geometry', 'formatted_address']
                });

                // Listen for place selection
                autocomplete.addListener('place_changed', function () {
                    const place = autocomplete.getPlace();

                    if (!place.geometry) {
                        console.log('No geometry found for this place');
                        return;
                    }

                    // Set latitude and longitude
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();

                    console.log('Location selected:', place.formatted_address);
                    console.log('Latitude:', place.geometry.location.lat());
                    console.log('Longitude:', place.geometry.location.lng());
                });
            }

            // Initialize when Google Maps loads
            window.addEventListener('load', function () {
                if (typeof google !== 'undefined') {
                    initAutocomplete();
                }
            });

            function contactAgent(name, email) {
                window.location.href = `mailto:${email}?subject=Property Inquiry via PropertyFinda&body=Hello ${name},%0D%0A%0D%0AI am interested in your property services.%0D%0A%0D%0AThank you.`;
            }
        </script>
    @endpush
@endsection