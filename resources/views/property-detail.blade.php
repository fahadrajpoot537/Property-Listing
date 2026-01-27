@extends('layouts.master')

@section('title', $listing->property_title . ' - FindaUk')

@section('content')
<style>
.description-content {
    line-height: 1.6;
    color: #333;
}
.description-content p {
    margin-bottom: 1rem;
}
.description-content ul, .description-content ol {
    margin: 1rem 0;
    padding-left: 2rem;
}
.description-content li {
    margin-bottom: 0.5rem;
}
.description-content strong {
    font-weight: 600;
}
.description-content em {
    font-style: italic;
}
</style>
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
                            </svg></a>
                        <a href="{{ url('/property-halfmap-grid') }}">Listings <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z">
                                </path>
                            </svg></a>
                        <div class="space24"></div>
                        <h1>{{ $listing->property_title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== HERO AREA ENDS =======-->

    <!--===== PROPERTY DETAILS AREA STARTS =======-->
    <div class="property-inner-section-find sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="property-detail-main">
                        <!-- Property Image -->
                        <div class="property-image mb-4">
                            <img src="{{ asset('storage/' . $listing->thumbnail) }}" alt="{{ $listing->property_title }}"
                                style="width: 100%; border-radius: 10px;">
                        </div>

                        <!-- Property Header -->
                        <div class="property-header mb-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h1 class="property-title">{{ $listing->property_title }}</h1>
                                    <p class="property-address text-muted mb-3">
                                        <i class="fa-solid fa-location-dot"></i> {{ $listing->address }}
                                    </p>
                                    <span class="badge badge-primary"
                                        style="font-size: 16px; padding: 10px 20px;">{{ $listing->purpose }}</span>
                                </div>
                                <div class="property-price">
                                    <h2 class="text-primary">${{ number_format($listing->price) }}</h2>
                                </div>
                            </div>
                        </div>

                            <div class="property-features d-flex gap-4 mb-4">
                                <div class="feature-item">
                                    <img src="{{ asset('assets/img/icons/bed1.svg') }}" width="20" alt="">
                                    <span class="ml-2">{{ $listing->bedrooms }} Bedrooms</span>
                                </div>
                                <div class="feature-item">
                                    <img src="{{ asset('assets/img/icons/bath1.svg') }}" width="20" alt="">
                                    <span class="ml-2">{{ $listing->bathrooms }} Bathrooms</span>
                                </div>
                                <div class="feature-item">
                                    <img src="{{ asset('assets/img/icons/sqare1.svg') }}" width="20" alt="">
                                    <span class="ml-2">{{ $listing->area_size }} sq ft</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="property-description mb-4">
                            <h3>Description</h3>
                            <div class="space16"></div>
                            <div class="description-content">{!! $listing->description !!}</div>
                        </div>

                        <!-- Amenities -->
                        @if($listing->features->count() > 0)
                            <div class="property-amenities mb-4">
                                <h3>Amenities</h3>
                                <div class="space16"></div>
                                <div class="row">
                                    @foreach($listing->features as $feature)
                                        <div class="col-md-6 mb-2 d-flex align-items-center">
                                            <i class="fa-solid fa-check text-success me-2"></i> 
                                            <span>{{ $feature->title ?? $feature->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Location Map -->
                        @if($listing->latitude && $listing->longitude)
                        <div class="property-location mb-4">
                            <h3>Location</h3>
                            <div class="space16"></div>
                            <div id="property-map" style="height: 300px; width: 100%; border-radius: 10px; border: 1px solid #ddd;"></div>
                        </div>
                        @endif

                        <!-- Property Details -->
                        <div class="property-details-table mb-4">
                            <h3>Property Details</h3>
                            <div class="space16"></div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Property Type:</strong></td>
                                        <td>{{ $listing->propertyType->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Unit Type:</strong></td>
                                        <td>{{ $listing->unitType->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Reference Number:</strong></td>
                                        <td>{{ $listing->property_reference_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Area Size:</strong></td>
                                        <td>{{ $listing->area_size }} sq ft</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="property-sidebar">
                        <!-- Contact Options -->
                        <div class="sidebar-widget mb-4 p-4" style="background: #f8f9fa; border-radius: 10px;">
                            <h4 class="mb-3">Contact Agent</h4>
                            
                            <!-- WhatsApp and Email Buttons -->
                            <div class="mb-3">
                                <a href="whatsapp://send?text=Hi, I am interested in {{ urlencode($listing->property_title) }}. Please provide more details.&phone={{ $listing->user->phone ?? '447700900000' }}" 
                                    class="btn w-100 mb-2" target="_blank" style="background-color: #1CD494; border: none; color: white;">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <a href="mailto:{{ $listing->user->email ?? 'info@example.com' }}?subject=Interest in {{ urlencode($listing->property_title) }}"
                                    class="btn btn-info w-100" style="margin-bottom: 15px;">
                                    <i class="fas fa-envelope"></i> Email
                                </a>
                            </div>
                            
                            <h5 class="mb-3">Or Send Message</h5>
                            <form>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" placeholder="Your Name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" placeholder="Your Email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="tel" class="form-control" placeholder="Your Phone" required>
                                </div>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                                </div>
                                <button type="submit" class="theme-btn1 w-100 border-0">Send Message</button>
                            </form>
                        </div>

                        <!-- Similar Properties -->
                        @if($similar_listings->count() > 0)
                            <div class="sidebar-widget">
                                <h4 class="mb-3">Similar Properties</h4>
                                @foreach($similar_listings as $similar)
                                    <div class="similar-property-item mb-3 p-3"
                                        style="border: 1px solid #eee; border-radius: 10px; transition: transform 0.2s, box-shadow 0.2s;">
                                        <a href="{{ url('/property/' . $similar->id) }}" class="text-decoration-none">
                                            <div class="d-flex">
                                                <div class="img mr-3" style="width: 80px; flex-shrink: 0;">
                                                    <img src="{{ asset('storage/' . $similar->thumbnail) }}"
                                                        alt="{{ $similar->property_title }}"
                                                        style="width: 100%; border-radius: 8px; height: 60px; object-fit: cover;">
                                                </div>
                                                <div class="content flex-grow-1">
                                                    <h6 class="mb-1 text-dark" style="font-size: 14px; font-weight: 600;">{{ strlen($similar->property_title) > 30 ? substr($similar->property_title, 0, 30) . '...' : $similar->property_title }}</h6>
                                                    <p class="m-0 text-primary" style="font-size: 14px; font-weight: 600;">${{ number_format($similar->price) }}</p>
                                                    <div class="d-flex mt-1" style="font-size: 12px; color: #666;">
                                                        <span class="mr-2">
                                                            <img src="{{ asset('assets/img/icons/bed1.svg') }}" width="12" alt="beds"> x{{ $similar->bedrooms }}
                                                        </span>
                                                        <span class="mr-2">
                                                            <img src="{{ asset('assets/img/icons/bath1.svg') }}" width="12" alt="baths"> x{{ $similar->bathrooms }}
                                                        </span>
                                                        <span>
                                                            <img src="{{ asset('assets/img/icons/sqare1.svg') }}" width="12" alt="area"> {{ $similar->area_size }} sq
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== PROPERTY DETAILS AREA ENDS =======-->

    <style>
        .property-features .feature-item {
            display: flex;
            align-items: center;
        }

        .ml-2 {
            margin-left: 0.5rem;
        }

        .gap-4 {
            gap: 2rem;
        }

        .badge-primary {
            background-color: var(--ztc-bg-bg-3);
            color: white;
        }
    </style>
    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
        <script>
            @if($listing->latitude && $listing->longitude)
            // Initialize map
            function initMap() {
                const location = { lat: {{ $listing->latitude }}, lng: {{ $listing->longitude }} };
                const map = new google.maps.Map(document.getElementById("property-map"), {
                    zoom: 15,
                    center: location,
                });
                
                const marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: "{{ addslashes($listing->property_title) }}",
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