@extends('layouts.modern')

@section('title', 'My Favorite Properties - FindaUK')

@section('content')
    <div class="pt-24 pb-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-4xl font-extrabold text-[#131B31] tracking-tight">My Favorites</h1>
                <p class="text-gray-500 mt-2 font-medium">Manage your saved listings and deals.</p>
            </div>

            @if($favorites->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($favorites as $favorite)
                        @php
                            $listing = $favorite->listing ?? $favorite->offMarketListing;
                            $route = $favorite->listing_id ? route('listing.show', $listing->id) : route('off-market-listing.show', $listing->id);
                            $typeLabel = $favorite->listing_id ? 'Public Listing' : 'Distress Deal';
                            $typeColor = $favorite->listing_id ? 'bg-purple-100 text-purple-700' : 'bg-amber-100 text-amber-700';
                        @endphp
                        @if($listing)
                            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
                                <div class="relative h-64 overflow-hidden">
                                    <a href="{{ $route }}">
                                        <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : asset('assets/img/all-images/hero/1.jpg') }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Listing">
                                    </a>
                                    <div class="absolute top-4 left-4">
                                        <span class="{{ $typeColor }} text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm backdrop-blur-md">
                                            {{ $typeLabel }}
                                        </span>
                                    </div>
                                    <button onclick="toggleFavorite({{ $favorite->listing_id ?? 'null' }}, {{ $favorite->off_market_listing_id ?? 'null' }}, this)" 
                                            class="absolute top-4 right-4 w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-red-500 shadow-lg hover:scale-110 transition-all">
                                        <i class="fa-solid fa-heart text-xl"></i>
                                    </button>
                                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-sm">
                                        <span class="text-lg font-black text-[#131B31]">£{{ number_format($listing->price) }}</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $listing->propertyType->title ?? 'Property' }}</span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $listing->purpose }}</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-[#131B31] mb-2 line-clamp-1">
                                        <a href="{{ $route }}" class="hover:text-[#8046F1] transition-colors">{{ $listing->property_title }}</a>
                                    </h3>
                                    <p class="text-gray-500 text-sm mb-6 flex items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-gray-400"></i> {{ Str::limit($listing->address, 40) }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                                        <div class="flex gap-4">
                                            <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                                <i class="fa-solid fa-bed text-gray-300"></i> {{ $listing->bedrooms }}
                                            </div>
                                            <div class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                                <i class="fa-solid fa-bath text-gray-300"></i> {{ $listing->bathrooms }}
                                            </div>
                                        </div>
                                        <a href="{{ $route }}" class="text-[#8046F1] font-black text-xs uppercase tracking-widest hover:translate-x-1 transition-transform inline-flex items-center gap-2">
                                            View Details <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-32 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-200">
                        <i class="fa-solid fa-heart text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-400">Your favorites is empty</h2>
                    <p class="text-gray-400 mt-2">Start exploring properties and save them to your list.</p>
                    <a href="{{ route('listings.index') }}" class="inline-block mt-8 px-10 py-4 bg-[#131B31] text-white font-black rounded-2xl shadow-xl shadow-gray-200 hover:scale-105 transition-all uppercase tracking-widest text-sm">
                        Explore Properties
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleFavorite(listingId, offMarketId, btn) {
            const data = {
                _token: '{{ csrf_token() }}'
            };
            if (listingId) data.listing_id = listingId;
            if (offMarketId) data.off_market_listing_id = offMarketId;

            $.ajax({
                url: '{{ route('favorites.toggle') }}',
                type: 'POST',
                data: data,
                success: function(res) {
                    if (res.status === 'removed') {
                        $(btn).closest('.group').fadeOut(300, function() {
                            $(this).remove();
                            if ($('.group').length === 0) {
                                location.reload();
                            }
                        });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                }
            });
        }
    </script>
@endsection
