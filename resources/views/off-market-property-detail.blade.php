@extends('layouts.master')

@section('title', $listing->property_title . ' - Confidential Deal')

@section('content')
    <!--===== BREADCRUMB AREA STARTS =======-->
    <div class="breadcrumb-section-area breadcrumb-bg1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2>Confidential Deal Details</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('off-market-listings.index') }}">Confidential Deals</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $listing->property_title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== BREADCRUMB AREA ENDS =======-->

    <!--===== PROPERTY DETAILS AREA STARTS =======-->
    <div class="property-details-section-area sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="property-details-left-content">
                        <!-- Property Gallery -->
                        <div class="property-gallery mb-4">
                            @if($listing->gallery && count($listing->gallery) > 0)
                                <div class="main-image mb-3">
                                    <img src="{{ asset('storage/' . $listing->gallery[0]) }}" alt="{{ $listing->property_title }}" class="img-fluid rounded">
                                </div>
                                <div class="thumbnail-images">
                                    @foreach($listing->gallery as $index => $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $listing->property_title }}" class="img-thumbnail mr-2 mb-2" style="width: 100px; height: 80px; object-fit: cover;">
                                    @endforeach
                                </div>
                            @elseif($listing->thumbnail)
                                <div class="main-image">
                                    <img src="{{ asset('storage/' . $listing->thumbnail) }}" alt="{{ $listing->property_title }}" class="img-fluid rounded">
                                </div>
                            @else
                                <div class="no-image-placeholder text-center p-5 bg-light rounded">
                                    <i class="fas fa-home fa-4x text-muted mb-3"></i>
                                    <p class="text-muted">No images available for this confidential deal</p>
                                </div>
                            @endif
                        </div>

                        <!-- Property Header -->
                        <div class="property-header mb-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h1 class="property-title">{{ $listing->property_title }}</h1>
                                    <p class="property-address text-muted">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        {{ $listing->address ?? 'Location disclosed to qualified buyers only' }}
                                    </p>
                                </div>
                                <div class="property-price">
                                    <h2 class="text-primary">£{{ number_format($listing->price) }}</h2>
                                    @if($listing->purpose == 'Rent')
                                        <p class="text-muted">Per {{ $listing->rentFrequency?->name ?? 'month' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Property Meta -->
                        <div class="property-meta mb-4">
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="meta-item text-center">
                                        <i class="fas fa-bed fa-2x text-primary mb-2"></i>
                                        <h5>{{ $listing->bedrooms }}</h5>
                                        <p class="text-muted mb-0">Bedrooms</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="meta-item text-center">
                                        <i class="fas fa-bath fa-2x text-primary mb-2"></i>
                                        <h5>{{ $listing->bathrooms }}</h5>
                                        <p class="text-muted mb-0">Bathrooms</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="meta-item text-center">
                                        <i class="fas fa-home fa-2x text-primary mb-2"></i>
                                        <h5>{{ $listing->propertyType?->title ?? 'Property' }}</h5>
                                        <p class="text-muted mb-0">Type</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="meta-item text-center">
                                        <i class="fas fa-ruler-combined fa-2x text-primary mb-2"></i>
                                        <h5>{{ $listing->area_size }}</h5>
                                        <p class="text-muted mb-0">Area</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Property Description -->
                        <div class="property-description mb-4">
                            <h3>Description</h3>
                            <div class="description-content">
                                {!! $listing->description !!}
                            </div>
                        </div>

                        <!-- Features -->
                        @if($listing->features->count() > 0)
                            <div class="property-features mb-4">
                                <h3>Features & Amenities</h3>
                                <div class="row">
                                    @foreach($listing->features as $feature)
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <i class="fas fa-check-circle text-success mr-2"></i>
                                            {{ $feature->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Contact Agent -->
                        <div class="sidebar-widget mb-4 p-4" style="background: #f8f9fa; border-radius: 10px;">
                            <h4 class="mb-3">Contact Agent</h4>
                            
                            <!-- WhatsApp and Email Buttons -->
                            <div class="mb-3">
                                <a href="whatsapp://send?text=Hi, I am interested in {{ urlencode($listing->property_title) }}. Please provide more details.&phone={{ $listing->user->phone ?? '447700900000' }}" 
                                    class="btn w-100 mb-2" target="_blank" style="background-color: #1CD494; border: none; color: white;">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <a href="mailto:{{ $listing->user->email ?? 'info@findauk.com' }}?subject=Interest in {{ urlencode($listing->property_title) }}"
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
                                    <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="property-sidebar">
                        <!-- Property Status -->
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <h4 class="text-success"><i class="fas fa-lock"></i> Confidential Deal</h4>
                                <p class="text-muted">This property is exclusively available to qualified buyers</p>
                            </div>
                        </div>

                        <!-- Property Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Property Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><strong>Purpose:</strong> {{ $listing->purpose }}</li>
                                    <li class="mb-2"><strong>Property Type:</strong> {{ $listing->propertyType?->title ?? 'N/A' }}</li>
                                    <li class="mb-2"><strong>Category:</strong> {{ $listing->unitType?->title ?? 'N/A' }}</li>
                                    @if($listing->ownershipStatus)
                                        <li class="mb-2"><strong>Ownership:</strong> {{ $listing->ownershipStatus->name }}</li>
                                    @endif
                                    @if($listing->cheque)
                                        <li class="mb-2"><strong>Cheque:</strong> {{ $listing->cheque->name }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Request More Information</h5>
                            </div>
                            <div class="card-body">
                                <form id="inquiry-form">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message</label>
                                        <textarea class="form-control" id="message" rows="3" placeholder="I'm interested in this confidential deal..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Send Inquiry</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Properties -->
            @if($similarProperties->count() > 0)
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="similar-properties">
                            <h3>Similar Confidential Deals</h3>
                            <div class="row">
                                @foreach($similarProperties as $similar)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="property-card">
                                            <div class="property-image">
                                                @if($similar->thumbnail)
                                                    <img src="{{ asset('storage/' . $similar->thumbnail) }}" alt="{{ $similar->property_title }}">
                                                @else
                                                    <div class="no-image-placeholder">
                                                        <i class="fas fa-lock"></i>
                                                        <span>Confidential</span>
                                                    </div>
                                                @endif
                                                <div class="property-price">
                                                    <span class="price-element" data-original-price="{{ $similar->price }}">£{{ number_format($similar->price) }}</span>
                                                </div>
                                            </div>
                                            <div class="property-content">
                                                <h5>
                                                    <a href="{{ route('off-market-listing.show', $similar->id) }}">
                                                        {{ Str::limit($similar->property_title, 40) }}
                                                    </a>
                                                </h5>
                                                <p class="property-address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ Str::limit($similar->address ?? 'Location confidential', 50) }}
                                                </p>
                                                <div class="property-meta">
                                                    <span><i class="fas fa-bed"></i> {{ $similar->bedrooms }} bed</span>
                                                    <span><i class="fas fa-bath"></i> {{ $similar->bathrooms }} bath</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!--===== PROPERTY DETAILS AREA ENDS =======-->

    @push('styles')
        <style>
            .property-title {
                color: #333;
                font-weight: 700;
                margin-bottom: 10px;
            }
            
            .property-price h2 {
                margin: 0;
            }
            
            .meta-item h5 {
                margin: 0;
                font-weight: 700;
            }
            
            .description-content {
                line-height: 1.6;
                color: #555;
            }
            
            .property-card {
                background: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 3px 10px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
                border: 1px solid #eee;
            }
            
            .property-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.15);
            }
            
            .property-image {
                position: relative;
                height: 200px;
                overflow: hidden;
            }
            
            .property-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .no-image-placeholder {
                width: 100%;
                height: 100%;
                background: #f8f9fa;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: #6c757d;
            }
            
            .property-price {
                position: absolute;
                top: 15px;
                right: 15px;
                background: #02b8f2;
                color: white;
                padding: 8px 15px;
                border-radius: 20px;
                font-weight: bold;
                font-size: 14px;
                box-shadow: 0 2px 10px rgba(2, 184, 242, 0.3);
            }
            
            .property-content {
                padding: 15px;
            }
            
            .property-content h5 {
                margin: 0 0 10px 0;
                font-size: 16px;
                font-weight: 600;
            }
            
            .property-content h5 a {
                color: #333;
                text-decoration: none;
            }
            
            .property-content h5 a:hover {
                color: #02b8f2;
            }
            
            .property-address {
                color: #666;
                margin: 0 0 10px 0;
                font-size: 13px;
            }
            
            .property-meta {
                display: flex;
                gap: 15px;
                font-size: 12px;
                color: #555;
            }
            
            .property-meta span {
                display: flex;
                align-items: center;
                gap: 5px;
            }
            
            .card {
                border: 1px solid #eee;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }
            
            .card-header {
                background: #f8f9fa;
                border-bottom: 1px solid #eee;
                font-weight: 600;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('js/currency-converter.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Initialize currency converter
                initializeCurrencyConverter();
                $('#inquiry-form').on('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        message: $('#message').val(),
                        property_id: {{ $listing->id }},
                        property_title: '{{ $listing->property_title }}'
                    };
                    
                    // Show loading
                    const submitBtn = $(this).find('button[type="submit"]');
                    const originalText = submitBtn.text();
                    submitBtn.prop('disabled', true).text('Sending...');
                    
                    // Simulate form submission (replace with actual AJAX call)
                    setTimeout(function() {
                        submitBtn.prop('disabled', false).text(originalText);
                        alert('Thank you for your inquiry. Our team will contact you shortly.');
                        $('#inquiry-form')[0].reset();
                    }, 1500);
                });
            });
        </script>
    @endpush
@endsection