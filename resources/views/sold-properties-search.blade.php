@extends('layouts.modern')

@section('title', 'Sold Properties Search - PropertyFinda')

@section('content')
    <div class="bg-primary pt-5 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-black text-white mb-6">
                Check Sold House Prices
            </h1>
            <p class="text-xl text-white/80 max-w-2xl mx-auto mb-10">
                Search recent property sales in your area instantly.
            </p>

            <form action="{{ route('sold-properties.search') }}" method="GET"
                class="max-w-3xl mx-auto bg-white p-2 rounded-full shadow-2xl flex flex-col md:flex-row gap-2">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="location" id="search-location" value="{{ request('location') }}"
                        placeholder="Enter postcode or area (e.g. ME1 1AA)"
                        class="block w-full pl-12 pr-4 py-4 rounded-full border-0 focus:ring-0 text-gray-900 placeholder-gray-500 font-bold"
                        autocomplete="off">
                </div>

                <div class="w-full md:w-48 relative border-t md:border-t-0 md:border-l border-gray-100">
                    <select name="radius"
                        class="block w-full pl-4 pr-10 py-4 rounded-full border-0 focus:ring-0 text-gray-900 font-bold bg-transparent">
                        <option value="0.1" {{ request('radius') == '0.1' ? 'selected' : '' }}>0.1 miles</option>
                        <option value="0.25" {{ request('radius') == '0.25' ? 'selected' : '' }}>0.25 miles</option>
                        <option value="0.5" {{ request('radius', 0.5) == '0.5' ? 'selected' : '' }}>0.5 miles</option>
                        <option value="1" {{ request('radius') == '1' ? 'selected' : '' }}>1 mile</option>
                    </select>
                </div>

                <button type="submit"
                    class="bg-secondary text-white px-10 py-4 rounded-full font-black uppercase tracking-widest hover:bg-secondary/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform">
                    Search
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-12 relative z-10">
        @if(isset($error))
            <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-8 border border-red-100 flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span class="font-bold">{{ $error }}</span>
            </div>
        @endif

        @if($searchPerformed && empty($results) && !isset($error))
            <div class="bg-white p-12 rounded-[2.5rem] shadow-sm border border-gray-100 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-house-chimney-crack text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">No results found</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    We couldn't find any sold property records matching "<strong>{{ $location }}</strong>" within {{ $radius }}
                    miles. Try extending the radius or checking the postcode.
                </p>
            </div>
        @endif

        @if(!empty($results))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($results as $property)
                    <div
                        class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all group">
                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                            @if(!empty($property['site_images']) && isset($property['site_images'][0]['url']))
                                <img src="{{ $property['site_images'][0]['url'] }}" alt="{{ $property['address'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @elseif(!empty($property['images']) && isset($property['images'][0]['url']))
                                <img src="{{ $property['images'][0]['url'] }}" alt="{{ $property['address'] }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-300">
                                    <i class="fa-solid fa-image text-4xl mb-2"></i>
                                    <span class="text-xs font-black uppercase tracking-widest">No Image</span>
                                </div>
                            @endif

                            @if($property['price'])
                                <div
                                    class="absolute bottom-4 right-4 bg-secondary text-white px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest shadow-lg">
                                    Sold: £{{ number_format($property['price']) }}
                                </div>
                            @endif

                            @if($property['is_internal'])
                                <div
                                    class="absolute top-4 left-4 bg-primary text-white px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest shadow-lg">
                                    Listed on PropertyFinda
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-black text-primary leading-tight mb-1 line-clamp-2"
                                        title="{{ $property['address'] }}">
                                        {{ $property['address'] }}
                                    </h3>
                                    <p class="text-sm font-bold text-gray-400">{{ $property['postcode'] }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6 pt-4 border-t border-gray-50">
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Type</p>
                                    <p class="text-sm font-bold text-gray-600">{{ $property['type'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Tenure</p>
                                    <p class="text-sm font-bold text-gray-600">{{ $property['tenure'] ?? 'N/A' }}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Transaction Date
                                    </p>
                                    <p class="text-sm font-bold text-gray-600">
                                        {{ \Carbon\Carbon::parse($property['date'])->format('d M, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Bedrooms</p>
                                    <p class="text-sm font-bold text-gray-600">{{ $property['bedrooms'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Area</p>
                                    <p class="text-sm font-bold text-gray-600">{{ $property['floor_area'] ?? 'N/A' }}</p>
                                </div>
                            </div>

                            @if($property['is_internal'] && $property['url'] != '#')
                                <a href="{{ $property['url'] }}"
                                    class="block w-full py-3 bg-primary text-white font-bold rounded-xl text-center hover:bg-primary/90 transition-colors">
                                    View Full Listing
                                </a>
                            @else
                                <a href="{{ route('property.external-details') }}?postcode={{ urlencode($property['postcode']) }}&address={{ urlencode($property['address']) }}&search_postcode={{ urlencode($property['search_postcode']) }}"
                                    class="block w-full py-3 bg-gray-50 text-gray-900 font-bold rounded-xl text-center hover:bg-primary hover:text-white transition-colors">
                                    View Details
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection