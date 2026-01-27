@extends('layouts.master')

@section('title', 'Property Search Results - FindaUk')

@section('content')
    <!--===== HERO AREA STARTS =======-->
    <div class="hero-inner-section-area-sidebar">
        <img src="{{ asset('assets/img/all-images/hero/hero-img1.png') }}" alt="housebox" class="hero-img1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-header-area text-center">
                        <a href="{{ url('/') }}">Home <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg> Listings</a>
                        <div class="space24"></div>
                        <h1>Find Your Dream Property</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== HERO AREA ENDS =======-->

    <!--===== PROPERTIES AREA STARTS =======-->
    <div class="property-inner-section-find sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="property-mapgrid-area">
                        <div class="heading1">
                            <h3>Properties ({{ $listings->total() }})</h3>
                            <div class="tabs-btn">
                                <ul class="nav nav-pills d-none d-lg-block" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ request('view') == 'grid' ? 'active' : '' }}"
                                            id="grid-view-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                                            type="button" role="tab" aria-controls="pills-home" aria-selected="{{ request('view') == 'grid' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M22 12.999V20C22 20.5523 21.5523 21 21 21H13V12.999H22ZM11 12.999V21H3C2.44772 21 2 20.5523 2 20V12.999H11ZM11 3V10.999H2V4C2 3.44772 2.44772 3 3 3H11ZM21 3C21.5523 3 22 3.44772 22 4V10.999H13V3H21Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ request('view') == 'list' || !request('view') ? 'active' : '' }}"
                                            id="list-view-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                                            type="button" role="tab" aria-controls="pills-profile" aria-selected="{{ request('view') == 'list' || !request('view') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="{{ url('/map') }}" class="nav-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                            </svg>
                                            <span class="ms-2">Map View</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="d-flex">
                                    <div class="filter-group">
                                        <select id="sort-select" class="nice-select">
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort by
                                                (Newest)</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Sort by
                                                (Oldest)</option>
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="space32 d-none d-lg-block"></div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="theme-btn1 open-filter-form mb-4 d-lg-none">
                                    <p class="open-text m-0">Open filter Options
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            style="width: 20px;">
                                            <path
                                                d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z">
                                            </path>
                                        </svg>
                                    </p>
                                    <p class="close-text m-0" style="display: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            style="width: 20px;">
                                            <path
                                                d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z">
                                            </path>
                                        </svg>
                                        Close
                                    </p>
                                </div>

                                <div class="sidebar1-area filter-options-form">
                                    <ul class="nav nav-pills" id="pills-tab-sidebar" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link sidebar-purpose-btn {{ request('purpose') == 'Rent' ? 'active' : '' }}"
                                                data-purpose="Rent" type="button">For Rent</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link sidebar-purpose-btn {{ request('purpose') == 'Buy' ? 'active' : '' }} m-0"
                                                data-purpose="Buy" type="button">For Sale</button>
                                        </li>
                                    </ul>
                                    <div class="space32"></div>
                                    <form id="sidebar-filter-form" action="{{ url('/property-halfmap-grid') }}"
                                        method="GET">
                                        <input type="hidden" name="purpose" id="sidebar-purpose"
                                            value="{{ request('purpose', 'Buy') }}">
                                        <input type="hidden" name="view" id="sidebar-view"
                                            value="{{ request('view', 'grid') }}">
                                        <input type="hidden" name="sort" id="sidebar-sort"
                                            value="{{ request('sort', 'newest') }}">
                                        <input type="hidden" name="lat" id="sidebar-lat" value="{{ request('lat') }}">
                                        <input type="hidden" name="lng" id="sidebar-lng" value="{{ request('lng') }}">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-area mb-3">
                                                    <input type="text" name="location" id="sidebar-location"
                                                        class="form-control" placeholder="City, Address or Zip"
                                                        value="{{ request('location') }}">
                                                </div>

                                                <div class="input-area mb-3">
                                                    <select name="radius" id="sidebar-radius"
                                                        class="country-area nice-select">
                                                        <option value="">Search Radius</option>
                                                        <option value="5" {{ request('radius') == '5' ? 'selected' : '' }}>
                                                            Within 5 miles</option>
                                                        <option value="10" {{ request('radius') == '10' ? 'selected' : '' }}>
                                                            Within 10 miles</option>
                                                        <option value="25" {{ request('radius') == '25' ? 'selected' : '' }}>
                                                            Within 25 miles</option>
                                                        <option value="50" {{ request('radius') == '50' ? 'selected' : '' }}>
                                                            Within 50 miles</option>
                                                        <option value="100" {{ request('radius') == '100' ? 'selected' : '' }}>Within 100 miles</option>
                                                    </select>
                                                </div>

                                                <div class="input-area mb-3">
                                                    <select name="bedrooms" class="country-area nice-select">
                                                        <option value="">Any Bedrooms</option>
                                                        <option value="1" {{ request('bedrooms') == '1' ? 'selected' : '' }}>
                                                            1+ Bed</option>
                                                        <option value="2" {{ request('bedrooms') == '2' ? 'selected' : '' }}>
                                                            2+ Bed</option>
                                                        <option value="3" {{ request('bedrooms') == '3' ? 'selected' : '' }}>
                                                            3+ Bed</option>
                                                        <option value="4" {{ request('bedrooms') == '4' ? 'selected' : '' }}>
                                                            4+ Bed</option>
                                                        <option value="5" {{ request('bedrooms') == '5' ? 'selected' : '' }}>
                                                            5+ Bed</option>
                                                    </select>
                                                </div>

                                                <div class="input-area mb-3">
                                                    <select name="bathrooms" class="country-area nice-select">
                                                        <option value="">Any Bathrooms</option>
                                                        <option value="1" {{ request('bathrooms') == '1' ? 'selected' : '' }}>
                                                            1+ Bath</option>
                                                        <option value="2" {{ request('bathrooms') == '2' ? 'selected' : '' }}>
                                                            2+ Bath</option>
                                                        <option value="3" {{ request('bathrooms') == '3' ? 'selected' : '' }}>
                                                            3+ Bath</option>
                                                        <option value="4" {{ request('bathrooms') == '4' ? 'selected' : '' }}>
                                                            4+ Bath</option>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-area mb-3">
                                                            <input type="number" name="min_price" class="form-control"
                                                                placeholder="Min Price" value="{{ request('min_price') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="input-area mb-3">
                                                            <input type="number" name="max_price" class="form-control"
                                                                placeholder="Max Price" value="{{ request('max_price') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="input-area mb-3">
                                                            <input type="number" name="min_size" class="form-control"
                                                                placeholder="Min Size" value="{{ request('min_size') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="input-area mb-3">
                                                            <input type="number" name="max_size" class="form-control"
                                                                placeholder="Max Size" value="{{ request('max_size') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin: 30px 0; border: 1px solid #ddd;">
                                        
                                        <!-- AMENITIES SECTION - COMPLETELY REWRITTEN -->
                                        <div style="background: white; padding: 20px; border: 2px solid #000; margin: 20px 0;">
                                            <h3 style="color: #000 !important; font-size: 20px !important; margin-bottom: 20px !important; font-family: Arial, sans-serif !important;">
                                                AMENITIES / FEATURES
                                            </h3>
                                            
    
                                            
                                            <!-- FEATURES LIST -->
                                            @if(isset($features_all) && $features_all->count() > 0)
                                                <div style="background: #d4edda; border: 2px solid #28a745; padding: 15px; margin-bottom: 20px;">
                                                    <p style="margin: 0; color: #000; font-size: 16px; font-weight: bold;">
                                                        ✓ FOUND {{ $features_all->count() }} FEATURES
                                                    </p>
                                                </div>
                                                
                                                <div class="row">
                                                @foreach($features_all as $index => $feature)
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="amenity-item" style="padding: 10px; margin-bottom: 8px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9;">
                                                            <label style="display: flex; align-items: center; margin: 0; cursor: pointer; font-family: Arial, sans-serif;">
                                                                <input type="checkbox" 
                                                                       name="feature_ids[]" 
                                                                       value="{{ $feature->id }}" 
                                                                       {{ in_array($feature->id, (array) request('feature_ids')) ? 'checked' : '' }}
                                                                       style="width: 18px; height: 18px; margin-right: 8px; flex-shrink: 0;">
                                                                <span style="color: #000 !important; font-size: 14px !important; flex-grow: 1;">
                                                                    {{ $feature->title }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                            @else
                                                <div style="background: #f8d7da; border: 2px solid #dc3545; padding: 15px;">
                                                    <p style="margin: 0; color: #000; font-size: 16px; font-weight: bold;">
                                                        ✗ NO FEATURES FOUND IN DATABASE
                                                    </p>
                                                    <p style="margin: 10px 0 0 0; color: #000; font-size: 14px;">
                                                        Please add features in the admin panel first.
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <hr style="margin: 30px 0; border: 1px solid #ddd;">
                                        <div class="space32"></div>
                                        <div class="col-lg-12">
                                            <div class="btn-area1">
                                                <button type="submit" class="theme-btn1 w-100 border-0">Apply Filters <span
                                                        class="arrow1"><svg xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                                                            <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                                        </svg></span><span class="arrow2"><svg
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            width="24" height="24" fill="currentColor">
                                                            <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                                                        </svg></span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="space30"></div>
                                <div class="property-latest">
                                    <h3>Latest Properties</h3>
                                    <div class="space8"></div>
                                    @foreach($latest_listings as $latest)
                                        <div class="latest-proprty d-flex align-items-center mb-3">
                                            <div class="img1 mr-3" style="width: 80px; flex-shrink: 0;">
                                                @if($latest->thumbnail)
                                                    <img src="{{ asset('storage/' . $latest->thumbnail) }}"
                                                        alt="{{ $latest->property_title }}"
                                                        style="width: 100%; border-radius: 8px;">
                                                @else
                                                    <div class="no-image" style="width: 80px; height: 80px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #666; border-radius: 8px;">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="content">
                                                <a href="{{ route('listing.show', $latest->id) }}"
                                                    class="font-weight-bold d-block mb-1">{{ Str::limit($latest->property_title, 40) }}</a>
                                                <div class="list mb-1">
                                                    <ul class="d-flex p-0 m-0" style="list-style: none; font-size: 12px;">
                                                        <li class="mr-2"><img src="{{ asset('assets/img/icons/bed1.svg') }}"
                                                                width="14" alt=""> {{ $latest->bedrooms ?? 0 }} bed</li>
                                                        <li class="mr-2"><img src="{{ asset('assets/img/icons/bath1.svg') }}"
                                                                width="14" alt=""> {{ $latest->bathrooms ?? 0 }} bath</li>
                                                        <li><img src="{{ asset('assets/img/icons/sqare1.svg') }}" width="14"
                                                                alt=""> {{ $latest->area_size ?? 'N/A' }} sqft</li>
                                                    </ul>
                                                </div>
                                                <h5 class="m-0 text-primary">£{{ number_format($latest->price ?? 0) }}</h5>
                                                
                                                <!-- Latest Property Features/Amenities -->
                                                <div class="mt-1">
                                                    @if($latest->features->count() > 0)
                                                        <div class="property-features d-flex flex-wrap gap-1">
                                                            @foreach($latest->features->take(2) as $feature)
                                                                <span class="badge bg-light text-dark" style="font-size: 9px; padding: 3px 6px; border: 1px solid #ddd; border-radius: 12px;">
                                                                    {{ Str::limit($feature->title ?? $feature->name, 12) }}
                                                                </span>
                                                            @endforeach
                                                            @if($latest->features->count() > 2)
                                                                <span class="badge bg-light text-dark" style="font-size: 9px; padding: 3px 6px; border: 1px solid #ddd; border-radius: 12px;">
                                                                    +{{ $latest->features->count() - 2 }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- WhatsApp and Email Buttons for Latest Properties -->
                                                <div class="mt-2 d-flex gap-1">
                                                    <a href="whatsapp://send?text=Hi, I am interested in {{ urlencode(Str::limit($latest->property_title, 50)) }}. Please provide more details.&phone={{ $latest->user?->phone ?? '447700900000' }}" 
                                                        class="btn btn-sm" target="_blank" style="font-size: 9px; padding: 2px 5px; background-color: #1CD494; border: none; color: white; border-radius: 4px;">
                                                        <i class="fab fa-whatsapp"></i> W
                                                    </a>
                                                    <a href="mailto:{{ $latest->user?->email ?? 'info@example.com' }}?subject=Interest in {{ urlencode(Str::limit($latest->property_title, 30)) }}"
                                                        class="btn btn-info btn-sm" style="font-size: 9px; padding: 2px 5px; border-radius: 4px;">
                                                        <i class="fas fa-envelope"></i> E
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="tab-content" id="pills-tabContent">
                                    {{-- GRID VIEW --}}
                                    <div class="tab-pane fade {{ request('view') == 'grid' ? 'show active' : '' }}"
                                        id="pills-home" role="tabpanel" aria-labelledby="grid-view-tab" tabindex="0">
                                        <div class="row">
                                            @forelse($listings as $listing)
                                                <div class="col-lg-6 col-md-6 mb-4">
                                                    <div class="property-boxarea">
                                                        <div class="img1 image-anime">
                                                            @if($listing->thumbnail)
                                                                <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                                                    alt="{{ $listing->property_title }}">
                                                            @else
                                                                <div class="no-image" style="height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #666;">
                                                                    <i class="fas fa-lock fa-2x"></i>
                                                                    <span class="d-block mt-2">Confidential</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="category-list">
                                                            <ul>
                                                                <li><a href="#">{{ $listing->purpose }}</a></li>
                                                                <li><a href="#">Confidential</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="content-area">
                                                            <a
                                                                href="{{ route('listing.show', $listing->id) }}">{{ Str::limit($listing->property_title, 40) }}</a>
                                                            <div class="space8"></div>
                                                            <p><i class="fa-solid fa-location-dot"></i> {{ Str::limit($listing->address ?? 'Location disclosed to qualified buyers', 50) }}
                                                            </p>
                                                            <div class="space12"></div>
                                                            <ul>
                                                                <li><a href="#"><img
                                                                            src="{{ asset('assets/img/icons/bed1.svg') }}"
                                                                            alt="housebox">{{ $listing->bedrooms ?? 0 }} bed</a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ asset('assets/img/icons/bath1.svg') }}"
                                                                            alt="housebox">{{ $listing->bathrooms ?? 0 }} bath</a></li>
                                                                <li><a href="#"><img
                                                                            src="{{ asset('assets/img/icons/sqare1.svg') }}"
                                                                            alt="housebox">{{ $listing->area_size ?? 'N/A' }} sqft</a></li>
                                                            </ul>
                                                            <div
                                                                class="btn-area d-flex justify-content-between align-items-center mt-2">
                                                                <a href="#"
                                                                    class="nm-btn">£{{ number_format($listing->price ?? 0) }}@if($listing->purpose == 'Rent')<span>/{{ $listing->rentFrequency?->name ?? 'month' }}</span>@endif</a>
                                                                <a href="javascript:void(0)" class="heart"><img
                                                                        src="{{ asset('assets/img/icons/heart1.svg') }}"
                                                                        alt="housebox" class="heart1"> <img
                                                                        src="{{ asset('assets/img/icons/heart2.svg') }}"
                                                                        alt="housebox" class="heart2"></a>
                                                            </div>

                                                            <!-- Property Features/Amenities -->
                                                            <div class="mt-2">
                                                                @if($listing->features->count() > 0)
                                                                    <div class="property-features d-flex flex-wrap gap-1">
                                                                        @foreach($listing->features->take(3) as $feature)
                                                                            <span class="badge bg-light text-dark" style="font-size: 11px; padding: 5px 10px; border: 1px solid #ddd; border-radius: 20px;">
                                                                                {{ $feature->title ?? $feature->name }}
                                                                            </span>
                                                                        @endforeach
                                                                        @if($listing->features->count() > 3)
                                                                            <span class="badge bg-light text-dark" style="font-size: 11px; padding: 5px 10px; border: 1px solid #ddd; border-radius: 20px;">
                                                                                +{{ $listing->features->count() - 3 }} more
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <!-- WhatsApp and Email Buttons -->
                                                            <div class="mt-2 d-flex gap-2">
                                                                <a href="whatsapp://send?text=Hi, I am interested in {{ urlencode($listing->property_title) }}. Please provide more details.&phone={{ $listing->user?->phone ?? '447700900000' }}" 
                                                                    class="btn btn-sm" target="_blank" style="font-size: 11px; padding: 4px 8px; background-color: #1CD494; border: none; color: white;">
                                                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                                                </a>
                                                                <a href="mailto:{{ $listing->user?->email ?? 'info@example.com' }}?subject=Interest in {{ urlencode($listing->property_title) }}"
                                                                    class="btn btn-info btn-sm" style="font-size: 11px; padding: 4px 8px;">
                                                                    <i class="fas fa-envelope"></i> Email
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-lg-12 text-center py-5">
                                                    <h3>No properties found matching your criteria.</h3>
                                                    <a href="{{ url('/property-halfmap-grid') }}" class="theme-btn1 mt-3">Reset
                                                        Filters</a>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{-- LIST VIEW --}}
                                    <div class="tab-pane fade {{ request('view') == 'list' || !request('view') ? 'show active' : '' }}"
                                        id="pills-profile" role="tabpanel" aria-labelledby="list-view-tab" tabindex="0">
                                        <div class="row">
                                            @forelse($listings as $listing)
                                                <div class="col-lg-12 mb-4">
                                                    <div class="property-boxarea2">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="img1 image-anime">
                                                                    @if($listing->thumbnail)
                                                                        <img src="{{ asset('storage/' . $listing->thumbnail) }}"
                                                                            alt="{{ $listing->property_title }}">
                                                                    @else
                                                                        <div class="no-image" style="height: 250px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #666;">
                                                                            <i class="fas fa-lock fa-2x"></i>
                                                                            <span class="d-block mt-2">Confidential</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="category-list">
                                                                    <ul>
                                                                        <li><a href="#">{{ $listing->purpose }}</a></li>
                                                                        <li><a href="#">Confidential</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="content-area">
                                                                    <a
                                                                        href="{{ url('/off-market-property/' . $listing->id) }}">{{ Str::limit($listing->property_title, 50) }}</a>
                                                                    <div class="space8"></div>
                                                                    <p><svg xmlns="http://www.w3.org/2000/svg"
                                                                            viewBox="0 0 24 24" fill="currentColor">
                                                                            <path
                                                                                d="M18.364 17.364L12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364ZM12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7C9.79086 7 8 8.79086 8 11C8 13.2091 9.79086 15 12 15ZM12 13C10.8954 13 10 12.1046 10 11C10 9.89543 10.8954 9 12 9C13.1046 9 14 9.89543 14 11C14 12.1046 13.1046 13 12 13Z">
                                                                            </path>
                                                                        </svg> {{ Str::limit($listing->address ?? 'Location disclosed to qualified buyers', 60) }}</p>
                                                                    <div class="space12"></div>
                                                                    <ul>
                                                                        <li><a href="#"><img
                                                                                    src="{{ asset('assets/img/icons/bed1.svg') }}"
                                                                                    alt="housebox">{{ $listing->bedrooms ?? 0 }} bed</a>
                                                                        </li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ asset('assets/img/icons/bath1.svg') }}"
                                                                                    alt="housebox">{{ $listing->bathrooms ?? 0 }} bath</a>
                                                                        </li>
                                                                        <li><a href="#"><img
                                                                                    src="{{ asset('assets/img/icons/sqare1.svg') }}"
                                                                                    alt="housebox">{{ $listing->area_size ?? 'N/A' }}
                                                                                sqft</a></li>
                                                                    </ul>

                                                                    <!-- Property Features/Amenities in List View -->
                                                                    <div class="mt-2">
                                                                        @if($listing->features->count() > 0)
                                                                            <div class="property-features d-flex flex-wrap gap-1">
                                                                                @foreach($listing->features->take(4) as $feature)
                                                                                    <span class="badge bg-light text-dark" style="font-size: 11px; padding: 5px 10px; border: 1px solid #ddd; border-radius: 20px;">
                                                                                        {{ $feature->title ?? $feature->name }}
                                                                                    </span>
                                                                                @endforeach
                                                                                @if($listing->features->count() > 4)
                                                                                    <span class="badge bg-light text-dark" style="font-size: 11px; padding: 5px 10px; border: 1px solid #ddd; border-radius: 20px;">
                                                                                        +{{ $listing->features->count() - 4 }} more
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    <!-- WhatsApp and Email Buttons in List View -->
                                                                    <div class="mt-2 d-flex gap-2">
                                                                        <a href="whatsapp://send?text=Hi, I am interested in {{ urlencode($listing->property_title) }}. Please provide more details.&phone={{ $listing->user?->phone ?? '447700900000' }}" 
                                                                            class="btn btn-sm" target="_blank" style="font-size: 11px; padding: 4px 8px; background-color: #1CD494; border: none; color: white;">
                                                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                                                        </a>
                                                                        <a href="mailto:{{ $listing->user?->email ?? 'info@example.com' }}?subject=Interest in {{ urlencode($listing->property_title) }}"
                                                                            class="btn btn-info btn-sm" style="font-size: 11px; padding: 4px 8px;">
                                                                            <i class="fas fa-envelope"></i> Email
                                                                        </a>
                                                                    </div>

                                                                    <div
                                                                        class="btn-area d-flex justify-content-between align-items-center mt-3">
                                                                        <div class="name-area d-flex align-items-center">
                                                                            <div class="img mr-2" style="width: 40px;">
                                                                                <img src="{{ asset('assets/img/all-images/properties/property-img7.png') }}"
                                                                                    alt="housebox" class="rounded-circle w-100">
                                                                            </div>
                                                                            <div class="text">
                                                                                <a href="#"
                                                                                    class="small">{{ $listing->user?->name ?? 'Manager' }}</a>
                                                                            </div>
                                                                        </div>
                                                                        <a href="{{ route('listing.show', $listing->id) }}"
                                                                            class="nm-btn">£{{ number_format($listing->price ?? 0) }}@if($listing->purpose == 'Rent')<span>/{{ $listing->rentFrequency?->name ?? 'month' }}</span>@endif</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-lg-12 text-center py-5">
                                                    <h3>No properties found matching your criteria.</h3>
                                                    <a href="{{ url('/property-halfmap-grid') }}" class="theme-btn1 mt-3">Reset
                                                        Filters</a>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-4">
                                        <div class="pagination-area">
                                            {{ $listings->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== PROPERTIES AREA ENDS =======-->
    
    <script>
    // Reverse geocode coordinates to populate location field
    @if(request('lat') && request('lng'))
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ request('lat') }};
        const lng = {{ request('lng') }};
        const locationInput = document.getElementById('sidebar-location');
        
        if (lat && lng && locationInput && !locationInput.value) {
            // Reverse geocode the coordinates
            fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key={{ config('services.google.maps_api_key') }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results.length > 0) {
                        const address = data.results[0].formatted_address;
                        locationInput.value = address;
                        console.log('Reverse geocoded address:', address);
                    }
                })
                .catch(error => {
                    console.error('Reverse geocoding failed:', error);
                });
        }
    });
    @endif
    </script>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Re-initialize nice-select FIRST
                if ($.fn.niceSelect) {
                    $('select.nice-select').niceSelect();

                    // Update hidden form values when nice-select changes
                    $('select.nice-select').on('change', function () {
                        console.log('Select changed:', $(this).attr('name'), '=', $(this).val());
                    });
                }

                // Initialize Google Places Autocomplete
                const locationInput = document.getElementById('sidebar-location');
                if (locationInput && typeof google !== 'undefined') {
                    const autocomplete = new google.maps.places.Autocomplete(locationInput, {
                        types: ['geocode'],
                        componentRestrictions: { country: 'gb' }
                    });

                    autocomplete.addListener('place_changed', function () {
                        const place = autocomplete.getPlace();
                        if (place.geometry) {
                            $('#sidebar-lat').val(place.geometry.location.lat());
                            $('#sidebar-lng').val(place.geometry.location.lng());
                            
                            // If no radius is selected, set a default (e.g., 10 miles)
                            if (!$('#sidebar-radius').val()) {
                                $('#sidebar-radius').val('10');
                                // Update the nice-select display if it exists
                                if ($.fn.niceSelect) {
                                    $('#sidebar-radius').niceSelect('update');
                                }
                            }
                            
                            console.log('Location selected:', place.formatted_address);
                            console.log('Coordinates:', place.geometry.location.lat(), place.geometry.location.lng());
                            console.log('Radius set to:', $('#sidebar-radius').val());
                        }
                    });
                }

                // Purpose Switch
                $('.sidebar-purpose-btn').click(function () {
                    $('.sidebar-purpose-btn').removeClass('active');
                    $(this).addClass('active');
                    $('#sidebar-purpose').val($(this).data('purpose'));
                    console.log('Purpose changed to:', $(this).data('purpose'));
                });

                // Filter toggle for mobile
                $('.open-filter-form').click(function () {
                    $('.filter-options-form').slideToggle();
                    $('.open-text').toggle();
                    $('.close-text').toggle();
                });

                // View Switch Logic
                $('#grid-view-tab').click(function () {
                    $('#sidebar-view').val('grid');
                });
                $('#list-view-tab').click(function () {
                    $('#sidebar-view').val('list');
                });

                // Sort Change Logic
                $('#sort-select').on('change', function () {
                    $('#sidebar-sort').val($(this).val());
                    console.log('Submitting form with sort:', $(this).val());
                    $('#sidebar-filter-form').submit();
                });

                // Debug: Log form submission
                $('#sidebar-filter-form').on('submit', function (e) {
                    console.log('Form submitting with data:');
                    $(this).serializeArray().forEach(function (field) {
                        console.log(field.name + ':', field.value);
                    });
                });
            });
        </script>
        <style>
            .sidebar-purpose-btn.active {
                background-color: var(--ztc-bg-bg-3) !important;
                color: white !important;
            }

            .sidebar-purpose-btn {
                cursor: pointer;
                border: 1px solid #eee;
                margin-right: 10px;
            }

            .latest-proprty .img1 img {
                height: 60px;
                object-fit: cover;
            }

            .property-boxarea2 .img1 img {
                width: 100%;
                height: 250px;
                object-fit: cover;
                border-radius: 10px;
            }

            .mr-2 {
                margin-right: 0.5rem !important;
            }

            .mr-3 {
                margin-right: 1rem !important;
            }

            .mb-2 {
                margin-bottom: 0.5rem !important;
            }

            .mb-3 {
                margin-bottom: 1rem !important;
            }

            .w-100 {
                width: 100% !important;
            }

            .border-0 {
                border: 0 !important;
            }

            /* Amenities Checkbox Styling */
            .checkbox-item label {
                display: flex !important;
                align-items: center !important;
                margin-bottom: 0 !important;
            }

            .checkbox-item .text-4 {
                color: #333 !important;
                font-size: 14px !important;
                font-weight: 400 !important;
                display: inline-block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .checkbox-item .btn-checkbox {
                display: inline-block !important;
                width: 18px !important;
                height: 18px !important;
                border: 2px solid #ddd !important;
                border-radius: 3px !important;
                margin-right: 10px !important;
            }

            .checkbox-item input[type="checkbox"] {
                position: absolute !important;
                opacity: 0 !important;
            }

            .checkbox-item input[type="checkbox"]:checked + .btn-checkbox {
                background-color: var(--ztc-bg-bg-3) !important;
                border-color: var(--ztc-bg-bg-3) !important;
            }

            .checkbox-item input[type="checkbox"]:checked + .btn-checkbox::after {
                content: '✓' !important;
                color: white !important;
                display: block !important;
                text-align: center !important;
                line-height: 14px !important;
            }
            /* Professional Card Design and Font Sizing */
            .property-boxarea {
                border: 1px solid #e0e0e0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .property-boxarea:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            }
            
            .property-boxarea .img1 img {
                width: 100%;
                height: 220px;
                object-fit: cover;
            }
            
            .property-boxarea .content-area {
                padding: 16px;
            }
            
            .property-boxarea .content-area a {
                font-size: 16px !important;
                font-weight: 600;
                color: #2c3e50;
                text-decoration: none;
                display: block;
                margin-bottom: 8px;
                line-height: 1.4;
            }
            
            .property-boxarea .content-area p {
                font-size: 13px !important;
                color: #7f8c8d;
                margin: 0;
                display: flex;
                align-items: center;
            }
            
            .property-boxarea ul {
                display: flex;
                justify-content: space-between;
                padding: 0;
                margin: 12px 0;
            }
            
            .property-boxarea ul li {
                list-style: none;
                font-size: 12px !important;
                color: #34495e;
            }
            
            .property-boxarea ul li a {
                color: #34495e;
                text-decoration: none;
                display: flex;
                align-items: center;
            }
            
            .property-boxarea ul li img {
                width: 14px;
                height: 14px;
                margin-right: 4px;
            }
            
            .property-boxarea .nm-btn {
                font-size: 14px !important;
                font-weight: 700;
                color: #2c3e50;
                background: #ecf0f1;
                padding: 6px 12px;
                border-radius: 20px;
                text-decoration: none;
            }
            
            .property-boxarea .heart {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
            }
            
            .property-boxarea .heart img {
                width: 18px;
                height: 18px;
            }
            
            .btn-area {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            /* Latest Properties Styling */
            .property-latest h3 {
                font-size: 16px !important;
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 16px;
                border-bottom: 2px solid #3498db;
                padding-bottom: 8px;
            }
            
            .latest-proprty {
                background: #ffffff;
                border: 1px solid #e0e0e0;
                border-radius: 10px;
                padding: 12px;
                margin-bottom: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            
            .latest-proprty:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            
            .latest-proprty a {
                font-size: 13px !important;
                font-weight: 600;
                color: #2c3e50;
                text-decoration: none;
                display: block;
                margin-bottom: 8px;
                line-height: 1.3;
            }
            
            .latest-proprty ul {
                padding: 0;
                margin: 8px 0;
            }
            
            .latest-proprty ul li {
                font-size: 10px !important;
                list-style: none;
                display: inline-block;
                margin-right: 12px;
                color: #7f8c8d;
            }
            
            .latest-proprty ul li img {
                width: 12px;
                height: 12px;
                margin-right: 3px;
            }
            
            .latest-proprty h5 {
                font-size: 13px !important;
                font-weight: 700;
                color: #27ae60;
                margin: 8px 0 0 0;
            }
            
            .latest-proprty .img1 img {
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            /* Feature badges */
            .property-features .badge {
                font-size: 10px !important;
                padding: 4px 8px !important;
                border-radius: 12px !important;
            }
            
            /* Contact buttons */
            .contact-buttons {
                display: flex;
                gap: 4px;
            }
            
            .contact-buttons .btn {
                font-size: 10px !important;
                padding: 4px 8px !important;
                border-radius: 6px !important;
            }
            
            /* List view improvements */
            .property-boxarea2 {
                border: 1px solid #e0e0e0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            }
            
            .property-boxarea2 .content-area a {
                font-size: 18px !important;
                font-weight: 600;
            }
            
            .property-boxarea2 p {
                font-size: 14px !important;
            }
            
            .property-boxarea2 ul li {
                font-size: 13px !important;
            }
            
            .property-boxarea2 .nm-btn {
                font-size: 16px !important;
            }
            
            /* Amenity item styling */
            .amenity-item {
                padding: 8px !important;
                margin-bottom: 6px !important;
                border: 1px solid #eee !important;
                border-radius: 8px !important;
                background-color: #f9f9f9 !important;
            }
            
            .amenity-item label {
                display: flex !important;
                align-items: center !important;
                margin: 0 !important;
                cursor: pointer !important;
                font-family: Arial, sans-serif !important;
                font-size: 13px !important;
            }
            
            .amenity-item input[type="checkbox"] {
                width: 16px !important;
                height: 16px !important;
                margin-right: 6px !important;
                flex-shrink: 0 !important;
            }
            
            .amenity-item span {
                color: #000 !important;
                font-size: 13px !important;
                flex-grow: 1 !important;
            }
        </style>
        <script>
            function loadGoogleMapsAPI() {
                // Load Google Maps API with callback
                const script = document.createElement('script');
                script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initializeAutocomplete';
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            }
            
            function initializeAutocomplete() {
                // Initialize Google Places Autocomplete
                const locationInput = document.getElementById('sidebar-location');
                if (locationInput) {
                    const options = {
                        componentRestrictions: { country: 'gb' },
                        fields: ['geometry', 'formatted_address', 'name', 'place_id'],
                        types: ['geocode', 'establishment']
                    };
                    const autocomplete = new google.maps.places.Autocomplete(locationInput, options);

                    autocomplete.addListener('place_changed', function () {
                        const place = autocomplete.getPlace();
                        if (place.geometry) {
                            $('#sidebar-lat').val(place.geometry.location.lat());
                            $('#sidebar-lng').val(place.geometry.location.lng());
                            
                            // If no radius is selected, set a default (e.g., 10 miles)
                            if (!$('#sidebar-radius').val()) {
                                $('#sidebar-radius').val('10');
                                // Update the nice-select display if it exists
                                if ($.fn.niceSelect) {
                                    $('#sidebar-radius').niceSelect('update');
                                }
                            }
                            
                            console.log('Location selected:', place.formatted_address);
                            console.log('Coordinates:', place.geometry.location.lat(), place.geometry.location.lng());
                            console.log('Radius set to:', $('#sidebar-radius').val());
                        }
                    });
                }
            }
            
            $(document).ready(function () {
                // Initialize Google Maps API
                loadGoogleMapsAPI();
                
                // Set default radius if coordinates are present but no radius is selected
                var lat = $('#sidebar-lat').val();
                var lng = $('#sidebar-lng').val();
                var radius = $('#sidebar-radius').val();
                var locationField = $('#sidebar-location');
                
                if ((lat && lng) && !radius) {
                    $('#sidebar-radius').val('10');
                    if ($.fn.niceSelect) {
                        $('#sidebar-radius').niceSelect('update');
                    }
                    console.log('Default radius set to 10 miles for coordinates:', lat, lng);
                }
                
                // Populate location field based on coordinates if coordinates are present but location field is empty
                if ((lat && lng) && !locationField.val()) {
                    // Check if Google Maps API is available
                    if (typeof google !== 'undefined' && google.maps && google.maps.Geocoder) {
                        var geocoder = new google.maps.Geocoder();
                        var latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
                        
                        geocoder.geocode({'location': latLng}, function(results, status) {
                            if (status === 'OK' && results[0]) {
                                // Extract a concise address from the result
                                var address = results[0].formatted_address;
                                // For simplicity, just use the formatted address or extract key parts
                                locationField.val(address);
                                console.log('Populated location field with reverse geocoded address:', address);
                            } else {
                                console.log('Reverse geocoding failed: ' + status);
                            }
                        });
                    } else {
                        console.log('Google Maps API not loaded yet for reverse geocoding');
                    }
                }
                
                // Re-initialize nice-select
                if ($.fn.niceSelect) {
                    $('select.nice-select').niceSelect();

                    // Update hidden form values when nice-select changes
                    $('select.nice-select').on('change', function () {
                        console.log('Select changed:', $(this).attr('name'), '=', $(this).val());
                    });
                }

                // Purpose Switch
                $('.sidebar-purpose-btn').click(function () {
                    $('.sidebar-purpose-btn').removeClass('active');
                    $(this).addClass('active');
                    $('#sidebar-purpose').val($(this).data('purpose'));
                    console.log('Purpose changed to:', $(this).data('purpose'));
                });

                // Filter toggle for mobile
                $('.open-filter-form').click(function () {
                    $('.filter-options-form').slideToggle();
                    $('.open-text').toggle();
                    $('.close-text').toggle();
                });

                // View Switch Logic
                $('#grid-view-tab').click(function () {
                    $('#sidebar-view').val('grid');
                });
                $('#list-view-tab').click(function () {
                    $('#sidebar-view').val('list');
                });

                // Sort Change Logic
                $('#sort-select').on('change', function () {
                    $('#sidebar-sort').val($(this).val());
                    console.log('Submitting form with sort:', $(this).val());
                    $('#sidebar-filter-form').submit();
                });

                // Debug: Log form submission
                $('#sidebar-filter-form').on('submit', function (e) {
                    console.log('Form submitting with data:');
                    $(this).serializeArray().forEach(function (field) {
                        console.log(field.name + ':', field.value);
                    });
                });
            });
        </script>
    @endpush
@endsection