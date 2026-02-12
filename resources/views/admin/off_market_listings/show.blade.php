@extends('layouts.admin')

@section('header', 'Confidential Asset Intel')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.off-market-listings.index') }}" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-[#ff931e] shadow-sm hover:shadow-md transition-all border border-slate-100">
                <i class='bx bx-left-arrow-alt text-2xl'></i>
            </a>
            <div>
                <h3 class="text-2xl font-black text-black tracking-tighter">{{ $listing->property_title }}</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em] italic">Secret Deal Node: {{ $listing->property_reference_number }} • Locked {{ $listing->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
             <span class="px-5 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest bg-orange-50 text-[#ff931e] ring-1 ring-orange-200 shadow-xl shadow-orange-500/10">
                OFF-MARKET ASSET
            </span>
            <button class="w-12 h-12 bg-black text-white rounded-2xl flex items-center justify-center hover:bg-[#ff931e] transition-all shadow-xl">
                <i class='bx bxs-edit-alt text-xl'></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Hero Section Swiper -->
            <div class="relative group rounded-[2.5rem] overflow-hidden shadow-2xl bg-black border-4 border-white">
                <div class="swiper mainSwiper h-[500px]">
                    <div class="swiper-wrapper">
                        <!-- Thumbnail first -->
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $listing->thumbnail) }}" class="w-full h-full object-cover grayscale" alt="Deal Hero">
                        </div>
                        <!-- Gallery images -->
                        @if($listing->gallery)
                            @foreach($listing->gallery as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover grayscale" alt="Surveillance Image">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#000]/90 via-[#000]/20 to-transparent pointer-events-none z-10"></div>
                <!-- Controls overlay -->
                <div class="absolute bottom-10 left-10 right-10 flex items-end justify-between z-20">
                    <div>
                        <div class="flex gap-2 mb-4">
                            <span class="px-4 py-1.5 bg-[#ff931e] text-white rounded-xl text-[10px] font-black uppercase tracking-widest">OFF MARKET</span>
                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md text-white rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/20">{{ $listing->propertyType->title }}</span>
                        </div>
                        <h1 class="text-4xl font-black text-white tracking-tighter leading-tight">{{ $listing->property_title }}</h1>
                        <p class="text-white/60 flex items-center gap-2 mt-2 font-medium italic">
                            <i class='bx bxs-map-pin text-[#ff931e] animate-pulse'></i> Coordinates: {{ $listing->address }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-[#ff931e] text-[10px] font-black uppercase tracking-[0.2em] mb-1">Confidential Value</p>
                        <div class="text-5xl font-black text-white tracking-tighter italic">£{{ number_format($listing->price) }}</div>
                    </div>
                </div>
            </div>

            <!-- Thumbnail Swiper -->
            <div class="swiper thumbSwiper mt-4">
                <div class="swiper-wrapper">
                    <div class="swiper-slide cursor-pointer opacity-40 hover:opacity-100 transition-opacity !w-24 !h-20">
                        <img src="{{ asset('storage/' . $listing->thumbnail) }}" class="w-full h-full object-cover rounded-2xl border-2 border-transparent grayscale" alt="Thumb Hero">
                    </div>
                    @if($listing->gallery)
                        @foreach($listing->gallery as $image)
                            <div class="swiper-slide cursor-pointer opacity-40 hover:opacity-100 transition-opacity !w-24 !h-20">
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover rounded-2xl border-2 border-transparent grayscale" alt="Thumb Gallery">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <style>
                .thumbSwiper .swiper-slide-thumb-active { opacity: 1; }
                .thumbSwiper .swiper-slide-thumb-active img { border-color: #ff931e; grayscale: 0; }
                .mainSwiper .swiper-slide-active img { grayscale: 0; transition: grayscale 0.5s; }
            </style>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php 
                    $specs = [
                        ['icon' => 'bx-expand', 'label' => 'Total Area', 'value' => $listing->area_size . ' Sq Ft', 'bg' => 'bg-slate-900', 'text' => 'text-white'],
                        ['icon' => 'bx-bed', 'label' => 'Bedrooms', 'value' => $listing->bedrooms, 'bg' => 'bg-white', 'text' => 'text-[#ff931e]'],
                        ['icon' => 'bx-bath', 'label' => 'Bathrooms', 'value' => $listing->bathrooms, 'bg' => 'bg-white', 'text' => 'text-[#ff931e]'],
                        ['icon' => 'bx-shield-quarter', 'label' => 'Asset Class', 'value' => $listing->unitType->title ?? 'N/A', 'bg' => 'bg-slate-900', 'text' => 'text-white']
                    ];

                    if($listing->purpose === 'Buy' && $listing->ownershipStatus) {
                        $specs[] = ['icon' => 'bx-key', 'label' => 'Ownership', 'value' => $listing->ownershipStatus->title, 'bg' => 'bg-white', 'text' => 'text-[#ff931e]'];
                    }
                    if($listing->purpose === 'Rent') {
                        if($listing->rentFrequency) $specs[] = ['icon' => 'bx-timer', 'label' => 'Frequency', 'value' => $listing->rentFrequency->title, 'bg' => 'bg-slate-900', 'text' => 'text-white'];
                        if($listing->cheque) $specs[] = ['icon' => 'bx-wallet', 'label' => 'Payments', 'value' => $listing->cheque->title, 'bg' => 'bg-white', 'text' => 'text-[#ff931e]'];
                    }
                @endphp
                @foreach($specs as $spec)
                <div class="{{ $spec['bg'] }} p-6 rounded-[2rem] border border-slate-100 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-all group">
                    <div class="w-12 h-12 {{ $spec['bg'] === 'bg-white' ? 'bg-orange-50' : 'bg-white/10' }} {{ $spec['text'] }} rounded-2xl flex items-center justify-center text-2xl mb-4 transform transition-transform group-hover:rotate-12">
                        <i class='bx {{ $spec['icon'] }}'></i>
                    </div>
                    <p class="text-[10px] {{ $spec['bg'] === 'bg-white' ? 'text-slate-400' : 'text-slate-500' }} font-bold uppercase tracking-widest mb-1">{{ $spec['label'] }}</p>
                    <p class="text-lg font-black {{ $spec['bg'] === 'bg-white' ? 'text-black' : 'text-white' }} tracking-tight">{{ $spec['value'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Dealer Card -->
            <div class="bg-white rounded-[2.5rem] p-8 text-black shadow-xl border border-slate-50 relative group">
                <div class="absolute top-0 right-0 p-6">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-ping"></div>
                </div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#ff931e] mb-6 italic">Intel Source</h4>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-3xl font-black text-white shadow-xl">
                        {{ substr($listing->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-lg font-black tracking-tighter">{{ $listing->user->name }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $listing->user->roles->first()->name ?? 'Dealer' }}</p>
                    </div>
                </div>
                <div class="p-4 bg-orange-50 rounded-2xl mb-8">
                     <p class="text-[9px] text-[#ff931e] font-black uppercase tracking-widest mb-1 italic">Vetting Status</p>
                     <p class="text-xs font-bold text-slate-700">Level 4 Verified Affiliate</p>
                </div>
                <div class="space-y-4">
                    <button class="w-full py-4 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] active:scale-95 transition-all shadow-xl">Contact Intel Source</button>
                    <button class="w-full py-4 bg-white border border-slate-100 text-[#ff931e] rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-orange-50 transition-all">Download Asset PDF</button>
                </div>
            </div>

            <!-- Strategic Location -->
            @if($listing->latitude && $listing->longitude)
            <div class="bg-white rounded-[2.5rem] p-2 border border-slate-100 shadow-xl overflow-hidden">
                 <div id="map" class="w-full h-[300px] rounded-[2rem] bg-slate-50 grayscale hover:grayscale-0 transition-all"></div>
                 <div class="p-6">
                      <h5 class="font-black text-black italic">Strategic Deployment Node</h5>
                      <p class="text-xs text-slate-400 font-bold uppercase mt-1">Coordinates: Locked in UK Grid</p>
                 </div>
            </div>
            @endif

            <!-- Intel Video -->
            @if($listing->video)
            <div class="bg-[#ff931e] rounded-[2.5rem] overflow-hidden shadow-2xl relative p-1">
                <div class="bg-black rounded-[2.25rem] overflow-hidden">
                    <video controls class="w-full aspect-video">
                        <source src="{{ asset('storage/' . $listing->video) }}" type="video/mp4">
                        Link Broken.
                    </video>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 text-white mb-1">
                        <i class='bx bxs-zap animate-bounce'></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Asset Disclosure Video</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if($listing->latitude && $listing->longitude)
@push('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap"></script>
<script>
    var swiperThumbs = new Swiper(".thumbSwiper", {
        spaceBetween: 10,
        slidesPerView: "auto",
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiperMain = new Swiper(".mainSwiper", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiperThumbs,
        },
    });

    function initMap() {
        const pos = { lat: {{ $listing->latitude }}, lng: {{ $listing->longitude }} };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 14, center: pos, styles: [ { "featureType": "all", "elementType": "all", "stylers": [{ "saturation": -100 }, { "gamma": 0.5 }] } ]
        });
        new google.maps.Marker({ position: pos, map: map, icon: { path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, scale: 6, fillColor: '#ff931e', fillOpacity: 1, strokeWeight: 2, strokeColor: '#000000' } });
    }
</script>
@endpush
@endif

@endsection