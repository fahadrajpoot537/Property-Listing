@extends('layouts.modern')

@section('title', $listing->property_title . ' - PropertyFinda')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .property-gallery-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: repeat(2, 350px);
            gap: 15px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(19, 27, 49, 0.6) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(128, 70, 241, 0.85) 0%, rgba(19, 27, 49, 0.85) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .gallery-overlay-text {
            text-align: center;
            color: white;
        }

        .gallery-overlay i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .gallery-overlay p {
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        @media (max-width: 1024px) {
            .property-gallery-grid {
                display: none;
            }

            .mobile-gallery-slider {
                display: block !important;
            }
        }

        .mobile-gallery-slider {
            display: none;
            height: 450px;
        }

        .sidebar-sticky {
            position: sticky;
            top: 120px;
        }

        #lightbox-viewer {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
        }

        .lightbox-swiper .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Force full viewport height for swiper slide */
            width: 100vw;
        }

        @media (max-width: 640px) {
            .bg-gray-50.pt-32 {
                padding-top: 5rem;
            }
            .p-8 {
                padding: 1.25rem !important;
            }
            .text-3xl {
                font-size: 1.75rem !important;
                line-height: 2.25rem !important;
            }
            .text-5xl {
                font-size: 2rem !important;
                line-height: 2.5rem !important;
            }
            .text-4xl {
                font-size: 1.5rem !important;
            }
            .mb-12 {
                margin-bottom: 2rem !important;
            }
            .mobile-gallery-slider {
                height: 300px;
            }
            /* Header responsiveness */
            .header-flex-wrapper {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .header-actions {
                width: 100% !important;
                justify-content: flex-start !important;
                margin-top: 1.5rem;
            }
            .price-display {
                text-align: left !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="bg-gray-50 pt-32 pb-24 mt-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-8 header-flex-wrapper">
                    <div class="flex-1">
                        <nav class="flex mb-4 text-xs font-bold text-gray-400 gap-2">
                            <a href="{{ route('home') }}" class="hover:text-secondary">Home</a>
                            <span>/</span>
                            <a href="{{ route('listings.index') }}" class="hover:text-secondary">Properties</a>
                            <span>/</span>
                            <span class="text-gray-900">{{ $listing->property_reference_number }}</span>
                        </nav>

                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-secondary text-white px-4 py-1 rounded-full text-xs font-bold">
                                {{ $listing->purpose }}</span>
                            <span
                                class="bg-gray-100 text-gray-600 px-4 py-1 rounded-full text-xs font-bold">{{ $listing->propertyType->title ?? 'Property' }}</span>
                        </div>

                        <h1 class="text-3xl md:text-5xl font-black text-primary mb-4">
                            {{ $listing->property_title }}
                        </h1>

                        <div class="flex items-center gap-2 text-gray-500 font-medium">
                            <i class="fa-solid fa-location-dot text-secondary"></i>
                            <span>{{ $listing->address }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 header-actions">
                        <div class="text-right price-display">
                            @if($listing->old_price && $listing->old_price > $listing->price)
                                <div class="flex items-center justify-end gap-2 mb-1">
                                    <span class="text-sm text-gray-400" style="text-decoration: line-through;">£{{ number_format($listing->old_price) }}</span>
                                    @php
                                        $percentage = round((($listing->old_price - $listing->price) / $listing->old_price) * 100);
                                    @endphp
                                    <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-md font-black">-{{ $percentage }}% OFF</span>
                                </div>
                            @endif
                            <span class="text-4xl font-black text-primary">£{{ number_format($listing->price) }}</span>
                        </div>

                        @if(auth()->check())
                            <a href="{{ route('listing.brochure', $listing->slug ?? $listing->id) }}"
                                class="w-14 h-14 rounded-2xl border-2 border-secondary bg-secondary/10 flex items-center justify-center hover:bg-secondary hover:text-white text-secondary transition-all group"
                                title="Download Brochure">
                                <i class="fa-solid fa-download text-xl group-hover:scale-110 transition-transform"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-secondary text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-secondary-dark transition-all shadow-lg shadow-secondary/20">
                                Login for Brochure
                            </a>
                        @endif

                        <button onclick="toggleFavorite({{ $listing->id }}, null, this)"
                            class="w-14 h-14 rounded-2xl border-2 border-gray-200 flex items-center justify-center hover:border-secondary transition-all {{ in_array($listing->id, $user_favorite_ids ?? []) ? 'text-rose-500' : 'text-gray-300' }}">
                            <i
                                class="{{ in_array($listing->id, $user_favorite_ids ?? []) ? 'fa-solid' : 'fa-regular' }} fa-heart text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            <div class="mb-12">
                @php 
                    $gallery = is_array($listing->gallery) ? $listing->gallery : json_decode($listing->gallery, true) ?? [];
                    $floorPlans = is_array($listing->floor_plans) ? $listing->floor_plans : json_decode($listing->floor_plans, true) ?? [];
                    
                    $allMedia = [];
                    if($listing->video) $allMedia[] = ['type' => 'video', 'src' => $listing->video];
                    if($listing->thumbnail) $allMedia[] = ['type' => 'image', 'src' => asset('storage/' . $listing->thumbnail)];
                    foreach($gallery as $img) $allMedia[] = ['type' => 'image', 'src' => asset('storage/' . $img)];
                    foreach($floorPlans as $img) $allMedia[] = ['type' => 'image', 'src' => asset('storage/' . $img)];
                @endphp

                <div class="property-gallery-grid">
                    @if(isset($allMedia[0]))
                        <div class="gallery-item row-span-2" style="grid-row: span 2;" onclick="openLightbox(0)">
                            @if($allMedia[0]['type'] === 'video')
                                <div class="w-full h-full bg-black relative">
                                    @if(Str::startsWith($allMedia[0]['src'], ['http', 'https']))
                                        <iframe src="{{ $allMedia[0]['src'] }}" class="w-full h-full pointer-events-none" frameborder="0"></iframe>
                                    @else
                                        <video class="w-full h-full object-cover">
                                            <source src="{{ asset('storage/' . $allMedia[0]['src']) }}" type="video/mp4">
                                        </video>
                                    @endif
                                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/30">
                                        <i class="fa-solid fa-circle-play text-5xl text-white opacity-90"></i>
                                        <span class="text-white font-bold mt-2 text-sm">Video Tour</span>
                                    </div>
                                </div>
                            @else
                                <img src="{{ $allMedia[0]['src'] }}" alt="Property Media">
                            @endif
                        </div>
                    @endif

                    @if(isset($allMedia[1]))
                        <div class="gallery-item" onclick="openLightbox(1)">
                            @if($allMedia[1]['type'] === 'video')
                                <div class="w-full h-full bg-black relative">
                                    <i class="fa-solid fa-circle-play text-3xl text-white opacity-90 absolute inset-0 m-auto"></i>
                                </div>
                            @else
                                <img src="{{ $allMedia[1]['src'] }}" alt="Property Media">
                            @endif
                        </div>
                    @endif

                    @if(isset($allMedia[2]))
                        <div class="gallery-item" onclick="openLightbox(2)">
                            @if($allMedia[2]['type'] === 'video')
                                <div class="w-full h-full bg-black relative">
                                    <i class="fa-solid fa-circle-play text-3xl text-white opacity-90 absolute inset-0 m-auto"></i>
                                </div>
                            @else
                                <img src="{{ $allMedia[2]['src'] }}" alt="Property Media">
                            @endif
                            @if(count($allMedia) > 3)
                                <div class="gallery-overlay">
                                    <div class="gallery-overlay-text">
                                        <i class="fa-solid fa-images"></i>
                                        <p>+{{ count($allMedia) - 3 }} More</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mobile-gallery-slider rounded-3xl overflow-hidden shadow-lg">
                    <div class="swiper mobile-swiper h-full">
                        <div class="swiper-wrapper">
                            @foreach($allMedia as $media)
                                <div class="swiper-slide">
                                    @if($media['type'] === 'video')
                                        <div class="w-full h-full bg-black flex items-center justify-center">
                                            @if(Str::startsWith($media['src'], ['http', 'https']))
                                                <iframe src="{{ $media['src'] }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                                            @else
                                                <video controls class="w-full h-full">
                                                    <source src="{{ asset('storage/' . $media['src']) }}" type="video/mp4">
                                                </video>
                                            @endif
                                        </div>
                                    @else
                                        <img src="{{ $media['src'] }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Main Content -->
                    <div class="w-full lg:w-2/3 space-y-8">

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                                @if($listing->bedrooms > 0)
                                    <i class="fa-solid fa-bed text-2xl text-secondary mb-2"></i>
                                    <p class="text-2xl font-black text-primary">{{ $listing->bedrooms }}</p>
                                    <p class="text-xs text-gray-500 font-medium">Bedrooms</p>
                                @else
                                    <i class="fa-solid fa-house-user text-2xl text-secondary mb-2"></i>
                                    <p class="text-2xl font-black text-primary">{{ $listing->unitType->title ?? 'Property' }}</p>
                                    <p class="text-xs text-gray-500 font-medium">Type</p>
                                @endif
                            </div>
                            @if($listing->bathrooms > 0)
                                <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                                    <i class="fa-solid fa-bath text-2xl text-secondary mb-2"></i>
                                    <p class="text-2xl font-black text-primary">{{ $listing->bathrooms }}</p>
                                    <p class="text-xs text-gray-500 font-medium">Bathrooms</p>
                                </div>
                            @endif
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                                <i class="fa-solid fa-vector-square text-2xl text-secondary mb-2"></i>
                                <p class="text-2xl font-black text-primary">{{ $listing->area_size ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 font-medium">Sq Ft</p>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                                <i class="fa-solid fa-stairs text-2xl text-secondary mb-2"></i>
                                <p class="text-2xl font-black text-primary">{{ $listing->floors_count ?? '1' }}</p>
                                <p class="text-xs text-gray-500 font-medium">Floors</p>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                            <h2 class="text-2xl font-black text-primary mb-6">Property Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2">
                                <div class="flex justify-between py-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Property ID</span>
                                    <span class="font-bold text-primary">{{ $listing->property_reference_number }}</span>
                                </div>
                                <div class="flex justify-between py-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium">Ownership</span>
                                    <span class="font-bold text-primary">{{ $listing->ownershipStatus->title ?? 'Freehold' }}</span>
                                </div>
                                @if($listing->epc_rating)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">EPC Rating</span>
                                        <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-sm font-bold">{{ $listing->epc_rating }}</span>
                                    </div>
                                @endif
                                @if($listing->council_tax_band)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Council Tax</span>
                                        <span class="font-bold text-primary">Band {{ $listing->council_tax_band }}</span>
                                    </div>
                                @endif
                                @if($listing->listed_property)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Listed Building</span>
                                        <span class="font-bold text-primary">{{ $listing->listed_property }}</span>
                                    </div>
                                @endif
                                @if($listing->no_onward_chain)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Clean Status</span>
                                        <span class="font-bold text-primary">No Onward Chain</span>
                                    </div>
                                @endif
                                @if($listing->flood_risk)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Flood Risk</span>
                                        <span class="font-bold text-primary">{{ $listing->flood_risk }}</span>
                                    </div>
                                @endif
                                @if($listing->private_rights_of_way)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Private Rights of Way</span>
                                        <span class="font-bold text-primary">{{ $listing->private_rights_of_way }}</span>
                                    </div>
                                @endif
                                @if($listing->public_rights_of_way)
                                    <div class="flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Public Rights of Way</span>
                                        <span class="font-bold text-primary">{{ $listing->public_rights_of_way }}</span>
                                    </div>
                                @endif
                                @if($listing->restrictions)
                                    <div class="col-span-1 md:col-span-2 flex justify-between py-3 border-b border-gray-100">
                                        <span class="text-gray-600 font-medium">Restrictions</span>
                                        <span class="font-bold text-primary text-right pl-4">{{ $listing->restrictions }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sold Price History Dropdown -->
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ isOpen: false, loaded: false }">
                            <button @click="isOpen = !isOpen; if(isOpen && !loaded) { fetchSoldPrices(); loaded = true; }" 
                                    class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none group hover:bg-gray-50/50 transition-colors">
                                <h2 class="text-2xl font-black text-primary">Sold Price History</h2>
                                <i class="fa-solid fa-chevron-down transition-transform duration-300 text-secondary text-xl" :class="{ 'rotate-180': isOpen }"></i>
                            </button>
                            
                            <div x-show="isOpen" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 max-h-0"
                                 x-transition:enter-end="opacity-100 max-h-[1000px]"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 max-h-[1000px]"
                                 x-transition:leave-end="opacity-0 max-h-0"
                                 class="px-6 md:px-8 pb-8" x-cloak>
                                <div id="sold-price-history">
                                    <div class="flex items-center justify-center py-8">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-secondary"></div>
                                        <span class="ml-3 text-gray-500 font-medium">Fetching historical data...</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-white p-6 md:p-8 rounded-3xl border border-gray-100" x-data="{ expanded: false }">
                            <h2 class="text-2xl font-black text-primary mb-6">Description</h2>
                            <div class="prose prose-slate max-w-none text-gray-600">
                                <div x-show="!expanded">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($listing->description), 200) }}
                                </div>
                                <div x-show="expanded" x-cloak>
                                    {!! $listing->description !!}
                                </div>
                                
                                @if(strlen(strip_tags($listing->description)) > 200)
                                    <button @click="expanded = !expanded" class="text-secondary font-bold hover:underline mt-4">
                                        <span x-text="expanded ? 'See Less' : 'See More'"></span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Features -->
                        @if($listing->features->count() > 0)
                            <div class="bg-white p-8 rounded-3xl border border-gray-100">
                                <h2 class="text-2xl font-black text-primary mb-6">Key Features</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($listing->features as $feature)
                                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                            <i class="fa-solid fa-check-circle text-secondary"></i>
                                            <span class="text-sm font-medium text-gray-700">{{ $feature->title }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif



                        <!-- Video & Map -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            

                            @if($listing->latitude && $listing->longitude)
                                <div class="bg-white p-8 rounded-3xl border border-gray-100">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-xl font-black text-primary">Location</h3>
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $listing->latitude }},{{ $listing->longitude }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-2 bg-secondary/10 text-secondary px-4 py-2 rounded-xl text-sm font-bold hover:bg-secondary hover:text-white transition-all">
                                            <i class="fa-solid fa-diamond-turn-right"></i>
                                            Get Directions
                                        </a>
                                    </div>
                                    <div id="property-map" class="aspect-video rounded-2xl overflow-hidden bg-gray-100 shadow-inner"></div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="w-full lg:w-1/3">
                        <div class="sidebar-sticky space-y-6">

                            <!-- Contact Agent -->
                            <div class="bg-primary p-8 rounded-3xl text-white">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-16 h-16 rounded-2xl bg-secondary flex items-center justify-center text-2xl font-black">
                                        {{ substr($listing->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black">{{ $listing->user->name ?? 'Agent' }}</h3>
                                        <p class="text-sm text-gray-300">Property Consultant</p>
                                    </div>
                                </div>

                                <form action="{{ route('listing.inquiry', $listing->slug ?? $listing->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="text" name="name" placeholder="Your Name" required 
                                        value="{{ auth()->check() ? auth()->user()->name : '' }}"
                                        class="w-full bg-white/10 border border-white/20 rounded-xl p-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-secondary outline-none">
                                    <input type="text" name="phone" placeholder="Phone Number" required 
                                        value="{{ auth()->check() ? auth()->user()->phone_number : '' }}"
                                        class="w-full bg-white/10 border border-white/20 rounded-xl p-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-secondary outline-none">
                                    <input type="email" name="email" placeholder="Email Address" required 
                                        value="{{ auth()->check() ? auth()->user()->email : '' }}"
                                        class="w-full bg-white/10 border border-white/20 rounded-xl p-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-secondary outline-none">
                                    <textarea name="message" rows="3" class="w-full bg-white/10 border border-white/20 rounded-xl p-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-secondary outline-none resize-none">I'm interested in {{ $listing->property_reference_number }}</textarea>

                                    <button type="submit" class="w-full py-4 bg-secondary hover:bg-secondary/90 text-white font-bold rounded-xl transition-all">
                                        Send Inquiry
                                    </button>
                                </form>

                                <div class="mt-6 grid grid-cols-2 gap-3">
                                    <a href="https://wa.me/{{ $listing->user->phone_number ?? '' }}" target="_blank" class="py-3 bg-emerald-500 rounded-xl flex items-center justify-center gap-2 text-sm font-bold hover:bg-emerald-600 transition-all">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                    <a href="tel:{{ $listing->user->phone_number ?? '' }}" class="py-3 bg-white/10 rounded-xl flex items-center justify-center gap-2 text-sm font-bold border border-white/20 hover:bg-white/20 transition-all">
                                        <i class="fa-solid fa-phone"></i> Call
                                    </a>
                                </div>
                            </div>

                            <!-- Similar Properties -->
                            @if($similar_listings->count() > 0)
                                <div class="bg-white p-6 rounded-3xl border border-gray-100">
                                    <h3 class="text-lg font-black text-primary mb-4">Similar Properties</h3>
                                    <div class="space-y-4">
                                        @foreach($similar_listings as $s)
                                            <a href="{{ url('/property/' . ($s->slug ?? $s->id)) }}" class="flex gap-4 group">
                                                <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
                                                    <img src="{{ $s->thumbnail ? asset('storage/' . $s->thumbnail) : asset('assets/img/all-images/hero/1.jpg') }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-bold text-primary line-clamp-2 group-hover:text-secondary transition-colors">{{ $s->property_title }}</p>
                                                    <p class="text-lg font-black text-secondary mt-1">£{{ number_format($s->price) }}</p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Mortgage Calculator -->
                            @if($listing->purpose === 'Buy')
                                <div class="bg-white p-6 rounded-3xl border border-gray-100">
                                    <h3 class="text-lg font-black text-primary mb-4">Mortgage Calculator</h3>
                                    <div class="bg-gray-50 p-4 rounded-2xl">
                                        <x-mortgage-calculator>{{ $listing->price }}</x-mortgage-calculator>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox -->
        <div id="lightbox-viewer">
            <button class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white z-50" onclick="closeLightbox()">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            <div class="swiper lightbox-swiper h-full">
                <div class="swiper-wrapper">
                    @foreach($allMedia as $media)
                        <div class="swiper-slide h-full flex items-center justify-center p-4">
                            @if($media['type'] === 'video')
                                <div class="w-full max-w-4xl aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl mx-auto">
                                    @if(Str::startsWith($media['src'], ['http', 'https']))
                                        <iframe src="{{ $media['src'] }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                                    @else
                                        <video controls class="w-full h-full">
                                            <source src="{{ asset('storage/' . $media['src']) }}" type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                            @else
                                <img src="{{ $media['src'] }}" class="max-h-full max-w-full object-contain rounded-2xl mx-auto block shadow-2xl">
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next !text-white"></div>
                <div class="swiper-button-prev !text-white"></div>
                <div class="swiper-pagination !text-white"></div>
            </div>
        </div>

@push('modals')
    <!-- External Property Detail Modal -->
    <div x-data="{ open: false, property: {} }" 
         @open-external-detail.window="open = true; property = $event.detail"
         x-show="open" 
         class="fixed inset-0 z-[100000] flex items-center justify-center p-4" 
         style="display: none; z-index: 100000 !important;"
         x-cloak>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-primary/80 backdrop-blur-[2px]" @click="open = false"></div>
        
        <!-- Modal Content -->
        <div class="bg-white w-full max-w-5xl rounded-[2rem] shadow-2xl overflow-hidden relative z-10 flex flex-col md:flex-row max-h-[90vh]">
            <button @click="open = false" class="absolute top-4 right-4 w-10 h-10 bg-white shadow-lg rounded-full flex items-center justify-center text-primary z-50 hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
            
            <!-- Left: Image Section -->
            <div class="md:w-1/2 bg-gray-100 relative min-h-[300px]">
                <template x-if="property.images && property.images.length > 0">
                    <img :src="property.images[0].url" class="absolute inset-0 w-full h-full object-cover">
                </template>
                <template x-if="!property.images || property.images.length === 0">
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 gap-4">
                        <i class="fa-solid fa-image text-6xl"></i>
                        <span class="text-xs font-bold uppercase tracking-widest">No Images Available</span>
                    </div>
                </template>
            </div>
            
            <!-- Right: Content -->
            <div class="md:w-1/2 p-8 md:p-12 overflow-y-auto">
                <div class="flex items-center gap-2 mb-6">
                    <span class="bg-secondary text-white px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider" x-text="property.type"></span>
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider" x-text="property.date"></span>
                </div>
                
                <h2 class="text-3xl font-black text-primary mb-2" x-text="property.name"></h2>
                <p class="text-gray-500 font-bold mb-8 flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-secondary"></i> <span x-text="property.location"></span>
                </p>
                
                <!-- Property Grid Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Price Paid</p>
                        <p class="text-xl font-black text-secondary">£<span x-text="new Intl.NumberFormat('en-GB').format(property.price)"></span></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tenure</p>
                        <p class="text-xl font-black text-primary" x-text="property.tenure"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bedrooms</p>
                        <p class="text-xl font-black text-primary" x-text="property.bedrooms"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bathrooms</p>
                        <p class="text-xl font-black text-primary" x-text="property.bathrooms"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Floor Area</p>
                        <p class="text-xl font-black text-primary" x-text="property.floor_area"></p>
                    </div>
                    <template x-if="property.council_tax && property.council_tax !== 'N/A'">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Council Tax</p>
                            <p class="text-xl font-black text-primary" x-text="property.council_tax"></p>
                        </div>
                    </template>
                    <template x-if="property.epc && property.epc !== 'N/A'">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">EPC Rating</p>
                            <p class="text-xl font-black text-primary" x-text="property.epc"></p>
                        </div>
                    </template>
                    <template x-if="property.flood_risk && property.flood_risk !== 'N/A'">
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Flood Risk</p>
                            <p class="text-xl font-black text-primary" x-text="property.flood_risk"></p>
                        </div>
                    </template>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-sm font-black text-primary uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Description</h3>
                    <div class="text-gray-600 leading-relaxed text-sm whitespace-pre-line" x-text="property.description"></div>
                </div>
                
                <div class="flex flex-col gap-3">
                    <a :href="`{{ route('property.external-details') }}?postcode=${encodeURIComponent(property.location)}&address=${encodeURIComponent(property.name)}&search_postcode=${encodeURIComponent(property.search_postcode)}`" class="w-full py-4 bg-primary text-white font-bold rounded-2xl flex items-center justify-center gap-3 hover:bg-primary/90 transition-all shadow-xl shadow-primary/20">
                        <span>View Full Property Details</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <p class="text-[10px] text-gray-400 text-center font-medium italic">Data fetched in real-time from PaTMa Property Prospector</p>
                </div>
            </div>
        </div>
    </div>
@endpush
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initMap" async defer></script>
    <script>
        let lightboxSwiper;

        function initMap() {
            const mapEl = document.getElementById("property-map");
            if (!mapEl) return;

            const lat = parseFloat("{{ $listing->latitude }}");
            const lng = parseFloat("{{ $listing->longitude }}");

            if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                mapEl.innerHTML = '<div class="h-full flex items-center justify-center text-gray-400"><i class="fa-solid fa-map-marked-alt text-4xl"></i></div>';
                return;
            }

            const position = { lat, lng };
            const map = new google.maps.Map(mapEl, {
                zoom: 15,
                center: position,
                disableDefaultUI: true,
                zoomControl: true
            });

            new google.maps.Marker({
                position: position,
                map: map,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 10,
                    fillColor: "#8046F1",
                    fillOpacity: 1,
                    strokeWeight: 4,
                    strokeColor: "white"
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            new Swiper(".mobile-swiper", {
                loop: true,
                pagination: { el: ".swiper-pagination", clickable: true }
            });

            lightboxSwiper = new Swiper(".lightbox-swiper", {
                loop: true,
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                pagination: { el: ".swiper-pagination", type: "fraction" }
            });
        });

        function openLightbox(index) {
            document.getElementById('lightbox-viewer').style.display = 'block';
            document.body.style.overflow = 'hidden';
            if (lightboxSwiper) {
                lightboxSwiper.update();
                lightboxSwiper.slideToLoop(index, 0);
            }
        }

        function closeLightbox() {
            document.getElementById('lightbox-viewer').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        async function toggleFavorite(listingId, offMarketId, btn) {
            @if(!auth()->check())
                window.location.href = "{{ route('login') }}";
                return;
            @endif

            try {
                const response = await fetch('{{ route('favorites.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        listing_id: listingId,
                        off_market_listing_id: offMarketId
                    })
                });

                const data = await response.json();
                const icon = btn.querySelector('i');

                if (data.status === 'added') {
                    btn.classList.add('text-rose-500');
                    btn.classList.remove('text-gray-300');
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                } else {
                    btn.classList.remove('text-rose-500');
                    btn.classList.add('text-gray-300');
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function fetchSoldPrices() {
            const container = document.getElementById('sold-price-history');
            if (!container) return;

            try {
                const response = await fetch('{{ route('listing.sold-prices', $listing->slug ?? $listing->id) }}');
                const data = await response.json();

                if (data.error) {
                    container.innerHTML = `<div class="p-4 bg-red-50 text-red-600 rounded-xl text-sm font-medium"><i class="fas fa-exclamation-circle mr-2"></i> ${data.error}</div>`;
                    return;
                }

                const prices = data.prices || data.data || (Array.isArray(data) ? data : null);

                if (!prices || prices.length === 0) {
                    container.innerHTML = '<div class="p-4 bg-gray-50 text-gray-500 rounded-xl text-sm font-medium text-center">No sold price history found for this postcode.</div>';
                    return;
                }

                window.soldPriceData = prices;

                let html = `
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[600px]">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="py-3 text-xs font-black text-gray-400 uppercase tracking-wider">Property</th>
                                    <th class="py-3 text-xs font-black text-gray-400 uppercase tracking-wider">Location</th>
                                    <th class="py-3 text-xs font-black text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="py-3 text-xs font-black text-gray-400 uppercase tracking-wider">Price</th>
                                    <th class="py-3 text-xs font-black text-gray-400 uppercase tracking-wider">Type</th>
                                    <th class="py-3 text-xs font-black text-gray-400 uppercase tracking-wider whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                `;

                prices.forEach((item, index) => {
                    const date = item.date || 'N/A';
                    const price = item.price || 0;
                    const type = item.type || 'Residential';
                    const name = item.name || 'N/A';
                    const location = item.location || 'N/A';

                    html += `
                        <tr>
                            <td class="py-4 text-sm font-bold text-primary">${name}</td>
                            <td class="py-4 text-sm text-gray-600">${location}</td>
                            <td class="py-4 text-sm font-bold text-primary">${date}</td>
                            <td class="py-4 text-sm font-black text-secondary">£${new Intl.NumberFormat('en-GB').format(price)}</td>
                            <td class="py-4 text-sm font-medium text-gray-600">${type}</td>
                            <td class="py-4 text-sm">
                                <button onclick="window.dispatchEvent(new CustomEvent('open-external-detail', { detail: window.soldPriceData[${index}] }))" class="inline-flex items-center gap-1 text-secondary font-bold hover:underline whitespace-nowrap">
                                    Details <i class="fa-solid fa-eye text-[10px]"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                html += '</tbody></table></div>';
                container.innerHTML = html;

            } catch (error) {
                console.error('Error fetching sold prices:', error);
                container.innerHTML = '<div class="p-4 bg-red-50 text-red-600 rounded-xl text-sm font-medium"><i class="fas fa-exclamation-circle mr-2"></i> Failed to connect to property data service.</div>';
            }
        }

        // Removed automatic DOMContentLoaded fetch to trigger on dropdown click
    </script>
@endpush