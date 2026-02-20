@extends('layouts.modern')

@section('title', ($property['address'] ?? 'Property Details') . ' - PropertyFinda')

@section('content')
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-gray-400">
                            <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                            <li><i class="fa-solid fa-chevron-right text-[8px]"></i></li>
                            <li>External Property</li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl md:text-4xl font-black text-primary">
                        {{ $property['address'] ?? ($property['label'] ?? 'N/A') }}</h1>
                    <p class="text-gray-500 font-bold mt-2 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-secondary"></i> {{ $property['postcode'] ?? 'N/A' }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="bg-secondary/10 text-secondary px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest">
                        {{ $property['property_type'] ?? 'Residential' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Media & Description -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Image Gallery -->
                <div class="rounded-[2.5rem] overflow-hidden bg-gray-100 aspect-video relative shadow-2xl">
                    @if(!empty($property['site_images']) && count($property['site_images']) > 0)
                        <img src="{{ $property['site_images'][0]['url'] }}" alt="Property Image"
                            class="w-full h-full object-cover">
                    @elseif(!empty($property['images']) && count($property['images']) > 0)
                        <img src="{{ is_array($property['images'][0]) ? $property['images'][0]['url'] : $property['images'][0] }}" alt="Property Image"
                            class="w-full h-full object-cover">
                    @elseif(!empty($property['latitude']) && !empty($property['longitude']))
                        <div class="w-full h-full">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_api_key') }}&q={{ $property['latitude'] }},{{ $property['longitude'] }}" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @elseif(!empty($property['address']) || !empty($property['postcode']))
                        <div class="w-full h-full">
                            <iframe 
                                width="100%" 
                                height="100%" 
                                frameborder="0" 
                                style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google.maps_api_key') }}&q={{ urlencode(($property['address'] ?? '') . ' ' . ($property['postcode'] ?? '')) }}" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 gap-4">
                            <i class="fa-solid fa-map-location-dot text-8xl"></i>
                            <span class="text-sm font-bold uppercase tracking-widest">No Image or Map Available</span>
                        </div>
                    @endif
                </div>

                <!-- Property Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <i class="fa-solid fa-bed text-secondary text-xl mb-4"></i>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bedrooms</p>
                        <p class="text-lg font-black text-primary">{{ $property['bedrooms'] ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <i class="fa-solid fa-bath text-secondary text-xl mb-4"></i>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bathrooms</p>
                        <p class="text-lg font-black text-primary">{{ $property['bathrooms'] ?? ($property['baths'] ?? ($property['habitable_rooms'] ?? 'N/A')) }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <i class="fa-solid fa-ruler-combined text-secondary text-xl mb-4"></i>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Floor Area</p>
                        <p class="text-lg font-black text-primary">
                            {{ isset($property['floor_area_sqft']) ? number_format($property['floor_area_sqft']) . ' sq ft' : 'N/A' }}
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <i class="fa-solid fa-key text-secondary text-xl mb-4"></i>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tenure</p>
                        <p class="text-lg font-black text-primary">{{ $property['tenure'] ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black text-primary mb-6 flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-secondary rounded-full"></span>
                        Property Description
                    </h3>
                    <div class="text-gray-600 leading-relaxed space-y-4 whitespace-pre-line text-lg">
                        {!! nl2br(e($property['description_text'] ?? ($property['description'] ?? 'No additional description available for this property.'))) !!}
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Price History / Quick Info -->
                <div class="bg-primary p-8 rounded-[2.5rem] shadow-xl text-white">
                    <h3 class="text-lg font-black mb-6 uppercase tracking-widest opacity-80">Last Sold Price</h3>
                    @if(!empty($property['sold_history']))
                        @php $lastSale = $property['sold_history'][0]; @endphp
                        <div class="mb-8 font-black">
                            <span class="text-4xl">£{{ number_format($lastSale['amount']) }}</span>
                            <p class="text-sm opacity-60 mt-2 font-medium">Sold on
                                {{ \Carbon\Carbon::parse($lastSale['date'])->format('d M, Y') }}</p>
                        </div>
                    @else
                        <div class="mb-8 font-black">
                            <span class="text-2xl italic tracking-normal">Price details not available</span>
                        </div>
                    @endif

                    <div class="space-y-4 pt-6 border-t border-white/10">
                        <a href="{{ $property['url'] ?? '#' }}" target="_blank"
                            class="w-full py-4 bg-secondary text-white font-bold rounded-2xl flex items-center justify-center gap-3 hover:bg-secondary/90 transition-all shadow-xl shadow-secondary/20">
                            View Original Source <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- More Sold History -->
                @if(!empty($property['sold_history']) && count($property['sold_history']) > 1)
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                        <h3
                            class="text-sm font-black text-primary uppercase tracking-widest mb-6 pb-2 border-b border-gray-100">
                            Full Price History</h3>
                        <div class="space-y-4">
                            @foreach(array_slice($property['sold_history'], 1) as $sale)
                                <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                                    <div>
                                        <p class="text-sm font-black text-primary">£{{ number_format($sale['amount']) }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold">
                                            {{ \Carbon\Carbon::parse($sale['date'])->format('M Y') }}</p>
                                    </div>
                                    <span class="bg-gray-100 text-gray-400 text-[10px] font-black px-2 py-1 rounded">SOLD</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <p class="text-[10px] text-gray-400 text-center font-medium italic px-6">
                    Disclaimer: This information is provided via the PaTMa Property Prospector API and is for informational
                    purposes only. Information is fetched in real-time and not stored on Finda-UK.
                </p>
            </div>
        </div>
    </div>
@endsection