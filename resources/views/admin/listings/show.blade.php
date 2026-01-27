@extends('layouts.admin')

@section('header', 'Asset Intelligence')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Top Action Bar -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.listings.index') }}"
                    class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 hover:text-[#02b8f2] shadow-sm hover:shadow-md transition-all border border-slate-100">
                    <i class='bx bx-left-arrow-alt text-2xl'></i>
                </a>
                <div>
                    <h3 class="text-2xl font-black text-black tracking-tighter">{{ $listing->property_title }}</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.2em]">Reference:
                        {{ $listing->property_reference_number }} • Posted {{ $listing->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span
                    class="px-5 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest {{ $listing->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : ($listing->status === 'rejected' ? 'bg-rose-50 text-rose-600' : 'bg-amber-50 text-amber-600') }}">
                    {{ $listing->status }}
                </span>
                <button
                    class="w-12 h-12 bg-black text-white rounded-2xl flex items-center justify-center hover:opacity-80 transition-all shadow-xl">
                    <i class='bx bxs-edit-alt text-xl'></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Hero Section Swiper -->
                <div class="relative group rounded-[2.5rem] overflow-hidden shadow-2xl bg-white border border-slate-100">
                    <div class="swiper mainSwiper h-[500px]">
                        <div class="swiper-wrapper">
                            <!-- Thumbnail first -->
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $listing->thumbnail) }}" class="w-full h-full object-cover" alt="Property Hero">
                            </div>
                            <!-- Gallery images -->
                            @if($listing->gallery)
                                @foreach($listing->gallery as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover" alt="Gallery Image">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="swiper-button-next !text-white after:!text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="swiper-button-prev !text-white after:!text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </div>

                <!-- Thumbnail Swiper -->
                <div class="swiper thumbSwiper mt-4">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide cursor-pointer opacity-40 hover:opacity-100 transition-opacity !w-24 !h-20">
                            <img src="{{ asset('storage/' . $listing->thumbnail) }}" class="w-full h-full object-cover rounded-2xl border-2 border-transparent" alt="Thumb Hero">
                        </div>
                        @if($listing->gallery)
                            @foreach($listing->gallery as $image)
                                <div class="swiper-slide cursor-pointer opacity-40 hover:opacity-100 transition-opacity !w-24 !h-20">
                                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover rounded-2xl border-2 border-transparent" alt="Thumb Gallery">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <style>
                    .thumbSwiper .swiper-slide-thumb-active { opacity: 1; }
                    .thumbSwiper .swiper-slide-thumb-active img { border-color: #02b8f2; }
                </style>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @php 
                        $specs = [
                            ['icon' => 'bx-expand', 'label' => 'Total Area', 'value' => $listing->area_size . ' Sq Ft', 'bg' => 'bg-blue-50', 'text' => 'text-[#02b8f2]'],
                            ['icon' => 'bx-bed', 'label' => 'Bedrooms', 'value' => $listing->bedrooms, 'bg' => 'bg-orange-50', 'text' => 'text-[#ff931e]'],
                            ['icon' => 'bx-bath', 'label' => 'Bathrooms', 'value' => $listing->bathrooms, 'bg' => 'bg-blue-50', 'text' => 'text-[#02b8f2]'],
                            ['icon' => 'bx-id-card', 'label' => 'Asset Type', 'value' => $listing->unitType->title ?? 'N/A', 'bg' => 'bg-orange-50', 'text' => 'text-[#ff931e]']
                        ];
                        
                        if($listing->purpose === 'Buy' && $listing->ownershipStatus) {
                            $specs[] = ['icon' => 'bx-key', 'label' => 'Ownership', 'value' => $listing->ownershipStatus->title, 'bg' => 'bg-blue-50', 'text' => 'text-[#02b8f2]'];
                        }
                        if($listing->purpose === 'Rent') {
                            if($listing->rentFrequency) $specs[] = ['icon' => 'bx-timer', 'label' => 'Frequency', 'value' => $listing->rentFrequency->title, 'bg' => 'bg-orange-50', 'text' => 'text-[#ff931e]'];
                            if($listing->cheque) $specs[] = ['icon' => 'bx-wallet', 'label' => 'Payments', 'value' => $listing->cheque->title, 'bg' => 'bg-blue-50', 'text' => 'text-[#02b8f2]'];
                        }
                    @endphp
                    @foreach($specs as $spec)
                        <div class="bg-white p-6 rounded-[2rem] border border-slate-50 flex flex-col items-center text-center shadow-sm hover:shadow-md transition-all">
                            <div class="w-12 h-12 {{ $spec['bg'] }} {{ $spec['text'] }} rounded-2xl flex items-center justify-center text-2xl mb-4">
                                <i class='bx {{ $spec['icon'] }}'></i>
                            </div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">{{ $spec['label'] }}</p>
                            <p class="text-lg font-black text-black tracking-tight">{{ $spec['value'] }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Description -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-50 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <i class='bx bxs-quote-right text-8xl'></i>
                    </div>
                    <h4 class="text-xl font-black text-black mb-6 italic tracking-tight flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-[#ff931e] rounded-full"></span> Internal Disclosure & Notes
                    </h4>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed font-medium">
                        {!! $listing->description !!}
                    </div>
                </div>

                <!-- Features -->
                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-50 shadow-sm">
                   <h4 class="text-xl font-black text-black mb-8 tracking-tight flex items-center gap-3 italic">
                        <span class="w-1.5 h-6 bg-[#02b8f2] rounded-full"></span> Premium Amenities
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($listing->features as $feature)
                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 bg-slate-50 text-slate-400 group-hover:bg-[#02b8f2] group-hover:text-white rounded-xl flex items-center justify-center transition-all">
                                     <i class='bx bx-check-circle text-xl'></i>
                                </div>
                                <span class="text-slate-700 font-black text-[13px] uppercase tracking-tighter">{{ $feature->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>


                            </div>


            <!-- Sidebar Inf
                           o -->
            <div class="space-y-8">
                <!-- Owner Card -->
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full rotate-12 transition-transform group-hover:scale-125"></div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#02b8f2] mb-6"
                                >Asset Representative</h4>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-3xl font-black text-white ring-4 ring-white/5">
                            {{ substr($listing->user->name, 0, 1) }}
                        </div>

                                               <div>
                            <p class="text-lg font-black tracking-tighter">{{ $listing->user->name }}</p>
                            <p class="text-[10px] text-white/50 font-bold uppercase tracking-widest">{{ $listing->user->roles->first()->name ?? 'Representative' }}</p>
                        </div>


                                           </div>
                    <div class="space-y-4">
                        <a href="mailto:{{ $listing->user->email }}" class="flex items-center gap-3 px-6 py-4 bg-white/5 hover:bg-[#02b8f2] rounded-2xl transition-all group/call">
                            <i class='bx bx-envelope text-xl text-[#02b8f2] group-hover/call:text-white'></i>
                            <span class="text-sm font-bold">Inquiry Email</span>
                        </a>
                       <button class="w-full py-4 bg-[#ff931e] text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-xl shadow-orange-500/20 active:scale-95 transition-all">Direct Message</button>
                   </div>
              </div>

                                      <!-- Map Placeholder -->
                @if($listing->latitude && $listing->longitude)
                    <div class="bg-white rounded-[2.5rem] p-2 border border-slate-100 shadow-xl">
                         <div id="map" class="w-full h-[300px] rounded-[2rem] bg-slate-50"></div>
                         <div class="p-6">
                              <h5 class="font-black text-black">Geographical Node</h5>
                              <p class="text-xs text-slate-400 font-bold uppercase mt-1">LAT: {{ $listing->latitude }} | LONG: {{ $listing->longitude }}</p>
                         </div>
                    </div>
                @endif

                <!-- Video Player -->
                @if($listing->video)
                    <div class="bg-black rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/10">
                        <video controls class="w-full aspect-video">
                            <source src="{{ asset('storage/' . $listing->video) }}" type="video/mp4">
                            Browser incompatible.
                        </video>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-rose-500 mb-1">
                                <i class='bx bxs-video-recording'></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">Live Inspection</span>
                            </div>
                            <h5 class="text-white font-black tracking-tighter">Deal Walkthrough</h5>
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
                        zoom: 15, center: pos, styles: [ { "featureType": "all", "elementType": "labels.text.fill", "stylers": [{ "color": "#7c93a3" }] }, { "featureType": "administrative.country", "elementType": "geometry.fill", "stylers": [{ "color": "#ff0000" }] } ]
                    });
                    new google.maps.Marker({ position: pos, map: map, icon: { path: google.maps.SymbolPath.CIRCLE, scale: 10, fillColor: '#02b8f2', fillOpacity: 1, strokeWeight: 5, strokeColor: '#ffffff' } });
                }
            </script>
        @endpush
    @endif

@endsection