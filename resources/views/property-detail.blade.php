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
        }
    </style>
@endpush

@section('content')
    <div class="bg-gray-50 pt-32 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-8">
                    <div class="flex-1">
                        <nav class="flex mb-4 text-xs font-bold text-gray-400 gap-2">
                            <a href="{{ route('home') }}" class="hover:text-secondary">Home</a>
                            <span>/</span>
                            <a href="{{ route('listings.index') }}" class="hover:text-secondary">Properties</a>
                            <span>/</span>
                            <span class="text-gray-900">{{ $listing->property_reference_number }}</span>
                        </nav>

                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-secondary text-white px-4 py-1 rounded-full text-xs font-bold">FOR
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

                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            @if($listing->old_price && $listing->old_price > $listing->price)
                                <span
                                    class="text-sm text-gray-400 line-through block mb-1">£{{ number_format($listing->old_price) }}</span>
                            @endif
                            <span class="text-4xl font-black text-primary">£{{ number_format($listing->price) }}</span>
                        </div>

                        @if(auth()->check())
                            <a href="{{ route('listing.brochure', $listing->id) }}"
                                class="w-14 h-14 rounded-2xl border-2 border-secondary bg-secondary/10 flex items-center justify-center hover:bg-secondary hover:text-white text-secondary transition-all group"
                                title="Download Brochure">
                                <i class="fa-solid fa-download text-xl group-hover:scale-110 transition-transform"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-secondary text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-secondary-dark transition-all shadow-lg shadow-secondary/20">
                                Login for Download Brochure
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
                @php $gallery = is_array($listing->gallery) ? $listing->gallery : json_decode($listing->gallery, true) ?? []; @endphp

                <div class="property-gallery-grid">
                    <!-- Main Thumbnail (Left - Big) -->
                    <div class="gallery-item row-span-2" onclick="openLightbox({{ $listing->video ? 1 : 0 }})">
                        <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : asset('assets/img/all-images/hero/1.jpg') }}"
                            alt="Main Property Image">
                    </div>

                    @if($listing->video)
                        <!-- Video Slot (Right Top) -->
                        <div class="gallery-item overflow-hidden bg-black" onclick="openLightbox(0)">
                            @if(Str::startsWith($listing->video, ['http', 'https']))
                                <iframe src="{{ $listing->video }}" class="w-full h-full pointer-events-none" frameborder="0"></iframe>
                            @else
                                <video class="w-full h-full object-cover">
                                    <source src="{{ asset('storage/' . $listing->video) }}" type="video/mp4">
                                </video>
                            @endif
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/30 group">
                                <i class="fa-solid fa-circle-play text-5xl text-white opacity-90 group-hover:scale-110 transition-transform"></i>
                                <span class="text-white font-bold mt-2 text-sm">Video Tour</span>
                            </div>
                        </div>

                        <!-- Gallery 1 (Right Bottom) -->
                        <div class="gallery-item" onclick="openLightbox(2)">
                            <img src="{{ isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg') }}"
                                alt="Gallery Image 1">
                            @if(count($gallery) > 1)
                                <div class="gallery-overlay">
                                    <div class="gallery-overlay-text">
                                        <i class="fa-solid fa-images"></i>
                                        <p>+{{ count($gallery) - 1 }} More Photos</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Gallery 1 (Right Top) -->
                        <div class="gallery-item" onclick="openLightbox(1)">
                            <img src="{{ isset($gallery[0]) ? asset('storage/' . $gallery[0]) : asset('assets/img/all-images/hero/1.jpg') }}"
                                alt="Gallery Image 1">
                        </div>

                        <!-- Gallery 2 (Right Bottom) -->
                        <div class="gallery-item" onclick="openLightbox(2)">
                            <img src="{{ isset($gallery[1]) ? asset('storage/' . $gallery[1]) : asset('assets/img/all-images/hero/1.jpg') }}"
                                alt="Gallery Image 2">
                            @if(count($gallery) > 2)
                                <div class="gallery-overlay">
                                    <div class="gallery-overlay-text">
                                        <i class="fa-solid fa-images"></i>
                                        <p>+{{ count($gallery) - 2 }} More Photos</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mobile-gallery-slider rounded-3xl overflow-hidden shadow-lg">
                    <div class="swiper mobile-swiper h-full">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                    class="w-full h-full object-cover"></div>
                            @if($listing->video)
                                <div class="swiper-slide">
                                    <div class="w-full h-full bg-black flex items-center justify-center">
                                        @if(Str::startsWith($listing->video, ['http', 'https']))
                                            <iframe src="{{ $listing->video }}" class="w-full h-full" frameborder="0"
                                                allowfullscreen></iframe>
                                        @else
                                            <video controls class="w-full h-full">
                                                <source src="{{ asset('storage/' . $listing->video) }}" type="video/mp4">
                                            </video>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @foreach($gallery as $img)
                                <div class="swiper-slide"><img src="{{ asset('storage/' . $img) }}"
                                        class="w-full h-full object-cover"></div>
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
                                <i class="fa-solid fa-bed text-2xl text-secondary mb-2"></i>
                                <p class="text-2xl font-black text-primary">{{ $listing->bedrooms }}</p>
                                <p class="text-xs text-gray-500 font-medium">Bedrooms</p>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-gray-100 text-center">
                                <i class="fa-solid fa-bath text-2xl text-secondary mb-2"></i>
                                <p class="text-2xl font-black text-primary">{{ $listing->bathrooms }}</p>
                                <p class="text-xs text-gray-500 font-medium">Bathrooms</p>
                            </div>
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
                        <div class="bg-white p-8 rounded-3xl border border-gray-100">
                            <h2 class="text-2xl font-black text-primary mb-6">Property Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-white p-8 rounded-3xl border border-gray-100" x-data="{ expanded: false }">
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

                        <!-- Legal & Environmental Information -->
                        @if($listing->flood_risk || $listing->listed_property || $listing->no_onward_chain || $listing->private_rights_of_way || $listing->public_rights_of_way || $listing->restrictions || $listing->flood_history || $listing->flood_defenses)
                            <div class="bg-white p-8 rounded-3xl border border-gray-100">
                                <h2 class="text-2xl font-black text-primary mb-6">Legal & Environmental Information</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($listing->listed_property)
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600 font-medium">Listed Building</span>
                                            <span class="px-3 py-1 bg-amber-500 text-white rounded-lg text-sm font-bold">{{ $listing->listed_property }}</span>
                                        </div>
                                    @endif

                                    @if($listing->no_onward_chain)
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600 font-medium">Chain Status</span>
                                            <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-sm font-bold">No Onward Chain</span>
                                        </div>
                                    @endif

                                    @if($listing->flood_risk)
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600 font-medium">Flood Risk</span>
                                            @if($listing->flood_risk === 'Very Low' || $listing->flood_risk === 'Low')
                                                <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-sm font-bold">{{ $listing->flood_risk }}</span>
                                            @elseif($listing->flood_risk === 'Medium')
                                                <span class="px-3 py-1 bg-amber-500 text-white rounded-lg text-sm font-bold">{{ $listing->flood_risk }}</span>
                                            @else
                                                <span class="px-3 py-1 bg-red-500 text-white rounded-lg text-sm font-bold">{{ $listing->flood_risk }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    @if($listing->flood_history)
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600 font-medium">Flood History</span>
                                            <span class="font-bold text-primary">{{ ucfirst($listing->flood_history) }}</span>
                                        </div>
                                    @endif

                                    @if($listing->flood_defenses)
                                        <div class="flex justify-between py-3 border-b border-gray-100">
                                            <span class="text-gray-600 font-medium">Flood Defenses</span>
                                            <span class="font-bold text-primary">{{ ucfirst($listing->flood_defenses) }}</span>
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
                                        <div class="col-span-2 py-3 border-b border-gray-100">
                                            <span class="text-gray-600 font-medium block mb-2">Restrictions</span>
                                            <span class="font-bold text-primary">{{ $listing->restrictions }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($listing->flood_risk && in_array($listing->flood_risk, ['High', 'Medium']))
                                    <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                                        <div class="flex items-start gap-3">
                                            <i class="fa-solid fa-exclamation-triangle text-red-500 text-xl mt-1"></i>
                                            <div>
                                                <h4 class="font-bold text-red-800 mb-1">Flood Risk Warning</h4>
                                                <p class="text-sm text-red-700">This property is in a {{ $listing->flood_risk }} flood risk area. Please review flood defenses and insurance requirements carefully.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Video & Map -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                            

                            @if($listing->latitude && $listing->longitude)
                                <div class="bg-white p-6 rounded-3xl border border-gray-100">
                                    <h3 class="text-lg font-black text-primary mb-4">Location</h3>
                                    <div id="property-map" class="aspect-video rounded-2xl overflow-hidden bg-gray-100"></div>
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

                                <form action="{{ route('listing.inquiry', $listing->id) }}" method="POST" class="space-y-4">
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
                                            <a href="{{ url('/property/' . $s->id) }}" class="flex gap-4 group">
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
                    @if($listing->video)
                        <div class="swiper-slide flex items-center justify-center p-4">
                            <div class="w-full max-w-4xl aspect-video bg-black rounded-2xl overflow-hidden shadow-2xl">
                                @if(Str::startsWith($listing->video, ['http', 'https']))
                                    <iframe src="{{ $listing->video }}" class="w-full h-full" frameborder="0"
                                        allowfullscreen></iframe>
                                @else
                                    <video controls class="w-full h-full">
                                        <source src="{{ asset('storage/' . $listing->video) }}" type="video/mp4">
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="swiper-slide flex items-center justify-center p-4 md:p-12">
                        <img src="{{ $listing->thumbnail ? asset('storage/' . $listing->thumbnail) : asset('assets/img/all-images/hero/1.jpg') }}"
                            class="max-h-full max-w-full object-contain rounded-2xl mx-auto block shadow-2xl">
                    </div>
                    @foreach($gallery as $img)
                        <div class="swiper-slide flex items-center justify-center p-4 md:p-12">
                            <img src="{{ asset('storage/' . $img) }}" 
                                 class="max-h-full max-w-full object-contain rounded-2xl mx-auto block shadow-2xl">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next !text-white"></div>
                <div class="swiper-button-prev !text-white"></div>
                <div class="swiper-pagination !text-white"></div>
            </div>
        </div>
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
    </script>
@endpush