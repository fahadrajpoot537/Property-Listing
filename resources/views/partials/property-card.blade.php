@php
    $isProperOffMarket = $listing instanceof \App\Models\OffMarketListing;
    $favIds = $isProperOffMarket ? ($user_favorite_off_market_ids ?? []) : ($user_favorite_ids ?? []);
@endphp

<div
    class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-500 border border-gray-100 flex flex-col h-full group">
    <!-- Image Section -->
    <div class="relative h-56 overflow-hidden bg-gray-100 shrink-0">
        <a href="{{ route($isProperOffMarket ? 'off-market-listing.show' : 'listing.show', $listing->slug ?? $listing->id) }}"
            class="block h-full w-full">
            @if($listing->thumbnail)
                <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    alt="{{ $listing->property_title }}">
            @else
                <div class="h-full w-full bg-gray-100 flex flex-col items-center justify-center gap-3">
                    <i class="fa-solid fa-house-chimney text-gray-300 text-5xl"></i>
                    <span class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">No Image Available</span>
                </div>
            @endif
        </a>

        <!-- Price Badge -->
        <div
            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-xl text-primary font-black shadow-sm flex flex-col items-start leading-none gap-1">
            @if($listing->old_price && $listing->old_price > 0 && $listing->old_price != $listing->price)
                <span class="text-[9px] text-gray-400 font-bold"
                    style="text-decoration: line-through;">£{{ number_format($listing->old_price) }}</span>
            @endif
            <span class="text-sm">£{{ number_format($listing->price) }}</span>
        </div>

        <!-- Favorite Button -->
        <button
            onclick="toggleFavorite({{ $isProperOffMarket ? 'null' : $listing->id }}, {{ $isProperOffMarket ? $listing->id : 'null' }}, this)"
            class="absolute top-4 right-4 w-10 h-10 bg-white/95 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all shadow-sm {{ in_array($listing->id, $favIds) ? 'text-red-500' : 'text-gray-400' }} hover:scale-110 z-10">
            <i class="{{ in_array($listing->id, $favIds) ? 'fa-solid' : 'fa-regular' }} fa-heart text-lg"></i>
        </button>
    </div>

    <!-- Content Section -->
    <div class="p-5 flex flex-col flex-grow">
        <div class="flex items-center gap-2 mb-3">
            <span
                class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm transition-all
                {{ $listing->purpose == 'Rent' ? 'bg-secondary text-white shadow-secondary/20' : 'bg-primary text-white shadow-primary/20' }}">
                {{ $listing->purpose }}
            </span>
            @if($listing->is_off_market)
                <span
                    class="px-3 py-1 rounded-lg bg-black text-white text-[10px] font-black uppercase tracking-wider shadow-sm">Vault</span>
            @endif
        </div>

        <h3
            class="font-black text-sm text-primary mb-1 line-clamp-1 group-hover:text-secondary transition-colors leading-tight">
            <a
                href="{{ route($isProperOffMarket ? 'off-market-listing.show' : 'listing.show', $listing->slug ?? $listing->id) }}">{{ $listing->property_title }}</a>
        </h3>

        <p class="text-gray-500 mb-4 flex items-center gap-1 text-xs font-medium">
            <i class="fa-solid fa-location-dot text-gray-300"></i> {{ Str::limit($listing->address, 50) }}
        </p>

        <!-- Features Grid -->
        <div class="mt-auto pt-4 border-t border-gray-100">
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="flex items-center gap-2 text-gray-700 font-bold text-xs">
                    <i class="fa-solid fa-bed text-gray-400"></i>
                    @if(strtolower($listing->bedrooms) === 'studio')
                        Studio
                    @elseif($listing->bedrooms && $listing->bedrooms > 0)
                        {{ $listing->bedrooms }} Bed{{ $listing->bedrooms > 1 ? 's' : '' }}
                    @else
                        N/A
                    @endif
                </div>

                <div class="flex items-center gap-1.5 text-gray-700 font-bold text-xs text-right justify-end">
                    <i class="fa-solid fa-bath text-gray-400"></i>
                    @if($listing->bathrooms && $listing->bathrooms > 0)
                        {{ $listing->bathrooms }} Bath{{ $listing->bathrooms > 1 ? 's' : '' }}
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="https://wa.me/{{ $listing->user?->phone_number ?? '440000000000' }}?text=Interested in {{ urlencode($listing->property_title) }}"
                    target="_blank" style="background-color:#25D366"
                    class="flex-1 bg-[#25D366] hover:bg-[#20bd5c] text-[10px] text-white font-bold py-2.5 px-2 rounded-lg flex items-center justify-center gap-1.5 transition-colors uppercase">
                    <i class="fab fa-whatsapp text-sm"></i> Chat
                </a>
                <a href="mailto:{{ $listing->user?->email }}?subject=Enquiry about {{ urlencode($listing->property_title) }}"
                    class="flex-1 bg-primary hover:bg-primary-dark text-[10px] text-white font-bold py-2.5 px-2 rounded-lg flex items-center justify-center gap-1.5 transition-colors uppercase">
                    <i class="fa-regular fa-envelope"></i> Mail
                </a>
                <a href="{{ route($isProperOffMarket ? 'off-market-listing.show' : 'listing.show', $listing->slug ?? $listing->id) }}"
                    class="flex-1 border border-gray-200 hover:border-secondary hover:text-secondary text-gray-600 text-[10px] font-bold py-2.5 px-2 rounded-lg flex items-center justify-center transition-all uppercase">
                    View
                </a>
            </div>
        </div>
    </div>
</div>