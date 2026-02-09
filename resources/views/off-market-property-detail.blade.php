@extends('layouts.modern')

@push('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        :root {
            --primary-navy: #131B31;
            --secondary-purple: #8046F1;
            --accent-teal: #00DEB6;
            --bg-soft: #F9FAFB;
            --border-color: #E5E7EB;
            --text-main: #1F2937;
            --text-light: #6B7280;
        }

        body {
            background-color: var(--bg-soft);
            color: var(--text-main);
        }

        .premium-card-v2 {
            background: white;
            border-radius: 1.5rem;
            border: 1px solid var(--border-color);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Gallery Container */
        .gallery-container {
            border-radius: 1.5rem;
            overflow: hidden;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 1024px) {
            .gallery-grid-v2 {
                display: grid;
                grid-template-columns: 2fr 1fr;
                grid-template-rows: 250px 250px;
                gap: 12px;
                height: 512px;
            }
            .mobile-only-gallery { display: none !important; }
        }

        @media (max-width: 1023px) {
            .gallery-grid-v2 { display: none !important; }
            .mobile-only-gallery {
                display: block !important;
                height: 400px;
            }
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img { transform: scale(1.05); }

        .gallery-main {
            grid-row: span 2;
            position: relative;
        }

        .gallery-overlay-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            z-index: 10;
        }

        /* Lightbox Modal Stylings */
        #galleryLightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.98);
            backdrop-filter: blur(15px);
        }

        .lightbox-close {
            position: absolute;
            top: 25px;
            right: 25px;
            color: white;
            font-size: 2.5rem;
            cursor: pointer;
            z-index: 100;
            transition: all 0.2s;
            opacity: 0.8;
            line-height: 1;
        }

        .lightbox-close:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .lightbox-swiper {
            width: 100%;
            height: 100%;
            padding: 40px 0;
        }

        .lightbox-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .lightbox-slide img {
            max-width: 100%;
            max-height: 90vh;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .stat-badge-v2 {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 24px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .stat-badge-v2:hover {
            border-color: var(--secondary-purple);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .stat-badge-v2 i {
            color: var(--secondary-purple);
            font-size: 1.5rem;
        }

        .sidebar-v2 {
            position: sticky;
            top: 120px;
        }

        .agent-box-v2 {
            background: var(--primary-navy);
            color: white;
            border-radius: 2rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .amenity-item-v2 {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            background: #F9FAFB;
            border-radius: 1rem;
            font-weight: 600;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .amenity-item-v2:hover {
            border-color: var(--secondary-purple);
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .confidential-badge {
            background: #fee2e2;
            color: #ef4444;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 800;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
@endpush

@section('title', $listing->property_title . ' - Confidential Deal')

@section('content')
    <div class="pt-48 pb-12 bg-[#F9FAFB]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb & Header -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-12 gap-6">
                <div class="w-full md:w-auto">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="confidential-badge">
                            <i class="fa-solid fa-lock"></i> Confidential Deal
                        </span>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest bg-secondary/10 text-secondary border border-secondary/20">
                            {{ $listing->purpose }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black text-primary tracking-tight leading-tight mb-4">
                        {{ $listing->property_title }}
                    </h1>
                    <p class="text-gray-500 font-bold flex items-center gap-2 text-xl mt-2">
                        <i class="fa-solid fa-map-marker-alt text-secondary"></i>
                        {{ $listing->address ?? 'Location disclosed to qualified buyers only' }}
                    </p>
                </div>
                <div class="text-left md:text-right bg-white p-6 rounded-2xl shadow-sm border border-gray-100 min-w-[200px] flex md:flex-col justify-between items-center md:items-end gap-4">
                    <div class="flex flex-col items-start md:items-end">
                        <div class="text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-1">Confidential Price</div>
                        <div class="text-4xl font-black text-secondary">£{{ number_format($listing->price) }}</div>
                    </div>
                    <button onclick="toggleFavorite(null, {{ $listing->id }}, this)" 
                            class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center transition-all hover:scale-110 {{ in_array($listing->id, $user_favorite_off_market_ids ?? []) ? 'text-red-500' : 'text-gray-300' }}">
                        <i class="{{ in_array($listing->id, $user_favorite_off_market_ids ?? []) ? 'fa-solid' : 'fa-regular' }} fa-heart text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Gallery Container -->
            @php 
                $gallery = is_array($listing->gallery) ? $listing->gallery : json_decode($listing->gallery, true) ?? []; 
            @endphp
            <div class="gallery-container">
                @if(count($gallery) > 0 || $listing->thumbnail)
                    <!-- Desktop Grid -->
                    <div class="gallery-grid-v2">
                        <div class="gallery-main gallery-item cursor-pointer" onclick="openLightbox(0)">
                            <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : (isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg')) }}" alt="Main">
                        </div>
                        <div class="gallery-item cursor-pointer" onclick="openLightbox(1)">
                            <img src="{{ isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg') }}" alt="G1">
                        </div>
                        <div class="gallery-item relative cursor-pointer" onclick="openLightbox(2)">
                            <img src="{{ isset($gallery[1]) ? asset('storage/' . $gallery[1]) : asset('assets/img/all-images/hero/1.jpg') }}" alt="G2">
                            @if(count($gallery) > 2)
                                <div class="gallery-overlay-btn" onclick="openLightbox(0); event.stopPropagation();">
                                    <i class="fa-solid fa-camera mr-2"></i> Show all photos
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mobile Slider -->
                    <div class="mobile-only-gallery">
                        <div class="swiper property-mobile-slider h-full">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : (isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg')) }}" class="w-full h-full object-cover"></div>
                                @foreach($gallery as $img)
                                    <div class="swiper-slide"><img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover"></div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                @else
                    <div class="h-64 bg-gray-100 flex flex-col items-center justify-center rounded-3xl">
                        <i class="fa-solid fa-lock text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Visuals Confidential</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Content Area -->
                <div class="w-full lg:w-2/3">

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                        <div class="stat-badge-v2">
                            <i class="fa-solid fa-bed"></i>
                            <div>
                                <span class="block text-xl font-bold">{{ $listing->bedrooms }}</span>
                                <span class="text-xs text-gray-400 uppercase font-bold">Bedrooms</span>
                            </div>
                        </div>
                        <div class="stat-badge-v2">
                            <i class="fa-solid fa-bath"></i>
                            <div>
                                <span class="block text-xl font-bold">{{ $listing->bathrooms }}</span>
                                <span class="text-xs text-gray-400 uppercase font-bold">Bathrooms</span>
                            </div>
                        </div>
                        <div class="stat-badge-v2">
                            <i class="fa-solid fa-vector-square"></i>
                            <div>
                                <span class="block text-xl font-bold">{{ $listing->area_size ?? 'N/A' }}</span>
                                <span class="text-xs text-gray-400 uppercase font-bold">Area Size</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="premium-card-v2">
                        <h2 class="text-2xl font-extrabold text-primary mb-6">Confidential Overview</h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed font-medium">
                            {!! $listing->description !!}
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="premium-card-v2">
                        <h2 class="text-2xl font-extrabold text-primary mb-8 flex items-center gap-3">
                            <span class="w-2 h-8 bg-secondary rounded-full"></span>
                            Key Details
                        </h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-secondary">
                                    <i class="fa-solid fa-hashtag"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Reference</span>
                                    <span class="text-sm font-bold text-primary">{{ $listing->property_reference_number ?? 'CONF-'.$listing->id }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-secondary">
                                    <i class="fa-solid fa-house-chimney"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Type</span>
                                    <span class="text-sm font-bold text-primary">{{ $listing->propertyType->title ?? 'Apartment' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-secondary">
                                    <i class="fa-solid fa-bullseye"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Purpose</span>
                                    <span class="text-sm font-bold text-primary">{{ $listing->purpose }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-green-500">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Market Status</span>
                                    <span class="text-sm font-bold text-green-600">Off-Market Exclusive</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    @if($listing->features->count() > 0)
                        <div class="premium-card-v2">
                            <h2 class="text-2xl font-extrabold text-primary mb-6">Amenities & Features</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($listing->features as $feature)
                                    <div class="amenity-item-v2">
                                        <i class="fa-solid fa-check-double text-secondary"></i>
                                        <span>{{ $feature->title ?? $feature->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="w-full lg:w-1/3">
                    <div class="sidebar-v2">
                        <div class="agent-box-v2 shadow-2xl">
                            <h3 class="text-xl font-extrabold mb-6">Interested in this Deal?</h3>
                            <p class="text-white/70 text-sm mb-8 leading-relaxed">This property is part of our off-market portfolio. Contact us for the full prospectus and NDA.</p>
                            
                            <div class="space-y-4">
                                <a href="https://wa.me/{{ $listing->user->phone ?? '447000000000' }}?text=Interested%20in%20Confidential%20Deal%20{{ $listing->id }}"
                                    class="py-4 bg-[#25D366] text-white font-black rounded-xl flex items-center justify-center gap-3 text-sm tracking-wider uppercase shadow-xl">
                                    <i class="fab fa-whatsapp text-lg"></i> WhatsApp Agent
                                </a>
                                <a href="mailto:{{ $listing->user->email ?? 'info@findauk.com' }}"
                                    class="py-4 bg-white text-primary font-black rounded-xl flex items-center justify-center gap-3 text-sm tracking-wider uppercase shadow-md text-center">
                                    <i class="fa-solid fa-envelope text-lg"></i> Send Email
                                </a>
                            </div>

                            <hr class="my-8 border-white/10">

                            <form class="space-y-4" id="confidential-inquiry">
                                <input type="text" placeholder="Full Name" class="w-full bg-white/10 border border-white/10 rounded-xl p-4 text-sm text-white focus:ring-secondary outline-none">
                                <input type="email" placeholder="Email Address" class="w-full bg-white/10 border border-white/10 rounded-xl p-4 text-sm text-white focus:ring-secondary outline-none">
                                <textarea rows="3" placeholder="Explain your interest..." class="w-full bg-white/10 border border-white/10 rounded-xl p-4 text-sm text-white focus:ring-secondary outline-none"></textarea>
                                <button type="submit" class="w-full py-4 bg-secondary text-white font-black rounded-xl hover:bg-white hover:text-primary transition-all uppercase tracking-[0.2em] text-[10px] shadow-lg">Request Prospectus</button>
                            </form>
                        </div>

                        <!-- Similar Off Market Properties -->
                        @if($similarProperties->count() > 0)
                            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                                <h3 class="text-xl font-black text-primary mb-6">More Off-Market</h3>
                                <div class="space-y-6">
                                    @foreach($similarProperties as $s)
                                        <a href="{{ route('off-market-listing.show', $s->id) }}" class="flex gap-4 group">
                                            <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-gray-50 border border-gray-100">
                                                <img src="{{ $s->thumbnail ? asset('storage/' . $s->thumbnail) : asset('assets/img/all-images/hero/1.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-secondary">{{ $s->property_title }}</h4>
                                                <div class="text-secondary font-black">£{{ number_format($s->price) }}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Lightbox Modal -->
    <div id="galleryLightbox">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <div class="swiper lightbox-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide lightbox-slide">
                    <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : (isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg')) }}" alt="Main">
                </div>
                @foreach($gallery as $img)
                    <div class="swiper-slide lightbox-slide">
                        <img src="{{ asset('storage/' . $img) }}" alt="Gallery Image">
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination !text-white !bottom-10"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        let lightboxSwiper;

        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Slider
            if (document.querySelector('.property-mobile-slider')) {
                new Swiper(".property-mobile-slider", {
                    loop: true,
                    pagination: { el: ".swiper-pagination", clickable: true },
                    autoplay: { delay: 4000 }
                });
            }

            // Lightbox Swiper
            lightboxSwiper = new Swiper(".lightbox-swiper", {
                loop: true,
                spaceBetween: 50,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                    type: "fraction",
                }
            });
        });

        function openLightbox(index) {
            const modal = document.getElementById('galleryLightbox');
            if(!modal) return;
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            if (lightboxSwiper) {
                lightboxSwiper.update();
                lightboxSwiper.slideToLoop(index, 0);
            }
        }

        function closeLightbox() {
            document.getElementById('galleryLightbox').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === "Escape") closeLightbox();
        });

        // Form Submission
        document.getElementById('confidential-inquiry')?.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Your request for the prospectus has been sent. Our team will verify your credentials and contact you.');
            this.reset();
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
                        $(btn).removeClass('text-gray-300').addClass('text-red-500');
                        icon.removeClass('fa-regular').addClass('fa-solid');
                    } else {
                        $(btn).removeClass('text-red-500').addClass('text-gray-300');
                        icon.removeClass('fa-solid').addClass('fa-regular');
                    }
                }
            });
        }
    </script>
@endpush