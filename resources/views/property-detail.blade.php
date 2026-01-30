@extends('layouts.master')

@section('title', $listing->property_title . ' - FindaUk')

@section('content')
    <style>
        :root {
            --primary-color: #1CD494;
            --secondary-color: #073B3A;
            --accent-color: #FCC608;
            --text-dark: #2E2E2E;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --border-radius: 12px;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: #f7f9fc;
        }

        .premium-card {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .property-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .property-price {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .property-address {
            color: var(--text-muted);
            font-size: 16px;
            margin-top: 10px;
        }

        .feature-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(28, 212, 148, 0.1);
            padding: 10px 20px;
            border-radius: 50px;
            color: var(--secondary-color);
            font-weight: 600;
            margin-right: 15px;
            margin-bottom: 15px;
        }

        .feature-badge img,
        .feature-badge i {
            margin-right: 8px;
            width: 20px;
            font-size: 18px;
        }

        .property-description {
            line-height: 1.8;
            color: #4a4a4a;
            font-size: 16px;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .amenity-item i {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 18px;
        }

        .sidebar-sticky {
            position: sticky;
            top: 110px;
            /* Adjust based on header height */
        }

        .agent-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .agent-header {
            background: var(--secondary-color);
            padding: 20px;
            color: white;
            text-align: center;
        }

        .agent-body {
            padding: 25px;
        }

        .contact-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 10px;
            transition: all 0.3s;
            text-decoration: none !important;
        }

        .btn-whatsapp {
            background: #25D366;
            color: white;
        }

        .btn-whatsapp:hover {
            background: #20bd5a;
            color: white;
            transform: translateY(-2px);
        }

        .btn-email {
            background: var(--text-dark);
            color: white;
        }

        .btn-email:hover {
            background: black;
            color: white;
            transform: translateY(-2px);
        }

        .form-control-premium {
            background-color: var(--bg-light);
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            width: 100%;
            margin-bottom: 15px;
            transition: border-color 0.3s;
        }

        .form-control-premium:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .hero-gallery {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .hero-gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .similar-property-card {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            transition: all 0.3s;
        }

        .similar-property-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .similar-img {
            width: 90px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
        }

        .table-details tr td {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            color: var(--text-dark);
        }

        .table-details tr:last-child td {
            border-bottom: none;
        }

        .table-details strong {
            color: var(--secondary-color);
        }
    </style>

    <!--===== BREADCRUMB STARTS =======-->
    <div style="background-color: #f0f4f8; padding: 60px 0 30px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/property-halfmap-grid') }}">Properties</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ Str::limit($listing->property_title, 30) }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!--===== BREADCRUMB ENDS =======-->

    <!--===== PROPERTY DETAILS AREA STARTS =======-->
    <div class="property-inner-section-find sp1" style="padding-top: 30px;">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">

                    <!-- Gallery Section -->
                    <!-- Gallery Section -->
                    <div class="hero-gallery mb-4" style="position: relative;">
                        <!-- Main Slider -->
                        <div class="swiper property-gallery-slider">
                            <div class="swiper-wrapper">
                                <!-- Thumbnail -->
                                @if($listing->thumbnail)
                                    <div class="swiper-slide">
                                        <div class="gallery-image-wrapper" style="height: 500px; width: 100%;">
                                            <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                                alt="{{ $listing->property_title }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <div style="position: absolute; top: 20px; left: 20px; z-index: 10;">
                                                <span class="badge"
                                                    style="background: var(--secondary-color); color: white; padding: 8px 15px; border-radius: 6px; font-size: 14px;">
                                                    {{ $listing->purpose }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Gallery Images -->
                                @if($listing->gallery && is_array($listing->gallery))
                                    @foreach($listing->gallery as $image)
                                        <div class="swiper-slide">
                                            <div class="gallery-image-wrapper" style="height: 500px; width: 100%;">
                                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $listing->property_title }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- Navigation buttons -->
                            <div class="swiper-button-next" style="color: white; text-shadow: 0 0 3px rgba(0,0,0,0.5);">
                            </div>
                            <div class="swiper-button-prev" style="color: white; text-shadow: 0 0 3px rgba(0,0,0,0.5);">
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <!-- Video Section -->
                    @if($listing->video)
                        <div class="premium-card mb-4">
                            <h3 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Property Video</h3>
                            <div class="video-container" style="border-radius: 10px; overflow: hidden; background: #000;">
                                @if(Str::startsWith($listing->video, ['http://', 'https://']))
                                    <!-- Embed URL -->
                                    <iframe src="{{ $listing->video }}" width="100%" height="450" frameborder="0"
                                        allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                @else
                                    <!-- Local Video -->
                                    <video controls class="w-100"
                                        style="width: 100%; height: 100%; max-height: 500px; display: block;">
                                        <source src="{{ asset('storage/' . $listing->video) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Title & Header -->
                    <div class="premium-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap">
                            <div class="mb-3 mb-md-0">
                                <h1 class="property-title">{{ $listing->property_title }}</h1>
                                <p class="property-address">
                                    <i class="fa-solid fa-location-dot" style="color: var(--primary-color);"></i>
                                    {{ $listing->address }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="property-price">${{ number_format($listing->price) }}</div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap mt-4">
                            <div class="feature-badge">
                                <img src="{{ asset('assets/img/icons/bed1.svg') }}" alt="">
                                <span>{{ $listing->bedrooms }} Bedrooms</span>
                            </div>
                            <div class="feature-badge">
                                <img src="{{ asset('assets/img/icons/bath1.svg') }}" alt="">
                                <span>{{ $listing->bathrooms }} Bathrooms</span>
                            </div>
                            <div class="feature-badge">
                                <img src="{{ asset('assets/img/icons/sqare1.svg') }}" alt="">
                                <span>{{ $listing->area_size }} sq ft</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="premium-card">
                        <h3 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Description</h3>
                        <div class="property-description">
                            {!! $listing->description !!}
                        </div>
                    </div>

                    <!-- Property Details -->
                    <div class="premium-card">
                        <h3 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Property Details</h3>
                        <table class="table table-details w-100">
                            <tbody>
                                <tr>
                                    <td width="40%"><strong>Reference Number</strong></td>
                                    <td>{{ $listing->property_reference_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Property Type</strong></td>
                                    <td>{{ $listing->propertyType->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Unit Type</strong></td>
                                    <td>{{ $listing->unitType->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Area Size</strong></td>
                                    <td>{{ $listing->area_size }} sq ft</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Amenities -->
                    @if($listing->features->count() > 0)
                        <div class="premium-card">
                            <h3 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Features & Amenities</h3>
                            <div class="row">
                                @foreach($listing->features as $feature)
                                    <div class="col-md-6">
                                        <div class="amenity-item">
                                            <i class="fa-solid fa-check-circle"></i>
                                            <span>{{ $feature->title ?? $feature->name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Location Map -->
                    @if($listing->latitude && $listing->longitude)
                        <div class="premium-card">
                            <h3 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Location</h3>
                            <div id="property-map" style="height: 400px; width: 100%; border-radius: 10px; overflow: hidden;">
                            </div>
                        </div>
                    @endif

                <!-- Mortgage Calculator -->
                        @if($listing->purpose === 'Buy')
                            <div class="premium-card">
                                <h3 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Mortgage Calculator</h3>
                                <x-mortgage-calculator>{{ $listing->price }}</x-mortgage-calculator>
                            </div>
                        @endif

                    </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="sidebar-sticky">



                        <!-- Contact Agent Widget -->
                        <div class="agent-card mb-4">
                            <div class="agent-header">
                                <h4 class="m-0" style="color: white;">Interested?</h4>
                                <p class="m-0 text-white-50 small">Contact the agent today</p>
                            </div>
                            <div class="agent-body">
                                <div class="text-center mb-4">
                                    <h5 class="font-weight-bold mb-1">{{ $listing->user->name ?? 'Agent' }}</h5>
                                    <p class="text-muted small">Property Consultant</p>
                                </div>

                                <a href="whatsapp://send?text=Hi, I am interested in {{ urlencode($listing->property_title) }}. Please provide more details.&phone={{ $listing->user->phone ?? '447700900000' }}"
                                    class="contact-btn btn-whatsapp" target="_blank">
                                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                                </a>

                                <a href="mailto:{{ $listing->user->email ?? 'info@example.com' }}?subject=Interest in {{ urlencode($listing->property_title) }}"
                                    class="contact-btn btn-email">
                                    <i class="fas fa-envelope mr-2"></i> Email Inquiry
                                </a>

                                <div class="text-center my-3 text-muted small">- OR -</div>

                                <form>
                                    <input type="text" class="form-control-premium" placeholder="Your Name" required>
                                    <input type="email" class="form-control-premium" placeholder="Your Email" required>
                                    <input type="tel" class="form-control-premium" placeholder="Your Phone" required>
                                    <textarea class="form-control-premium" rows="3" placeholder="I'm interested in..."
                                        required></textarea>
                                    <button type="submit" class="theme-btn1 w-100 border-0"
                                        style="width: 100%; cursor: pointer;">Send Message</button>
                                </form>
                            </div>
                        </div>

                        <!-- Similar Properties -->
                        @if($similar_listings->count() > 0)
                            <div class="premium-card p-4">
                                <h5 class="mb-3 font-weight-bold">Similar Properties</h5>
                                @foreach($similar_listings as $similar)
                                    <a href="{{ url('/property/' . $similar->id) }}" class="text-decoration-none">
                                        <div class="similar-property-card">
                                            <img src="{{ asset('storage/' . $similar->thumbnail) }}" class="similar-img"
                                                alt="thumb">
                                            <div>
                                                <h6 class="text-dark mb-1" style="font-size: 14px; line-height: 1.4;">
                                                    {{ Str::limit($similar->property_title, 25) }}
                                                </h6>
                                                <div class="text-primary font-weight-bold" style="font-size: 14px;">
                                                    ${{ number_format($similar->price) }}</div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== PROPERTY DETAILS AREA ENDS =======-->

    @push('scripts')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
        <script>
            // Initialize Gallery Swiper
            document.addEventListener('DOMContentLoaded', function () {
                if (document.querySelector('.property-gallery-slider')) {
                    var gallerySwiper = new Swiper(".property-gallery-slider", {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        loop: true,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                    });
                }
            });
            @if($listing->latitude && $listing->longitude)
                // Initialize map
                function initMap() {
                    const location = { lat: {{ $listing->latitude }}, lng: {{ $listing->longitude }} };
                    const map = new google.maps.Map(document.getElementById("property-map"), {
                        zoom: 15,
                        center: location,
                        disableDefaultUI: false,
                        zoomControl: true,
                        styles: [
                            {
                                "featureType": "all",
                                "elementType": "geometry.fill",
                                "stylers": [{ "weight": "2.00" }]
                            },
                            {
                                "featureType": "all",
                                "elementType": "geometry.stroke",
                                "stylers": [{ "color": "#9c9c9c" }]
                            },
                            {
                                "featureType": "all",
                                "elementType": "labels.text",
                                "stylers": [{ "visibility": "on" }]
                            },
                            {
                                "featureType": "landscape",
                                "elementType": "all",
                                "stylers": [{ "color": "#f2f2f2" }]
                            }
                        ]
                    });

                    const marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        title: "{{ addslashes($listing->property_title) }}",
                        animation: google.maps.Animation.DROP
                    });
                }

                // Load map when page loads
                if (typeof google !== 'undefined' && google.maps) {
                    initMap();
                }
            @endif
        </script>
    @endpush
@endsection