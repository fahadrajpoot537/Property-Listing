@extends('layouts.master')

@section('title', 'Our Services - FindaUk')

@section('extra_styles')
<link rel="stylesheet" href="{{ asset('css/custom-blog-service.css') }}">
@endsection

@section('content')
<!--===== SERVICES HEADER AREA STARTS =======-->
<div class="page-banner-area" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ asset('theme/assets/images/services/service-header.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-banner-content text-center">
                    <h1 class="text-white">Our Professional Services</h1>
                    <p class="text-white-50 mt-3">Comprehensive real estate solutions tailored to your needs</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== SERVICES HEADER AREA ENDS =======-->

<!--===== SERVICES GRID AREA STARTS =======-->
<div class="services-grid-section-area sp2">
    <div class="container">
        <div class="row">
            @forelse($services as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="service-card h-100 shadow-sm border-0">
                    <div class="service-image position-relative overflow-hidden rounded-top">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid w-100" alt="{{ $service->title }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="{{ asset('theme/assets/images/services/default.jpg') }}" class="img-fluid w-100" alt="{{ $service->title }}" style="height: 250px; object-fit: cover; background-color: #e8f5e8;">
                        @endif
                        <div class="service-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center opacity-0 bg-primary bg-opacity-75 transition-all duration-300">
                            <a href="#" class="btn btn-light btn-lg rounded-pill px-4">Learn More</a>
                        </div>
                    </div>
                    <div class="service-content bg-white p-4 border border-top-0 rounded-bottom">
                        <h4 class="service-title mb-3 text-primary">{{ $service->title }}</h4>
                        <p class="service-description text-muted mb-4">{{ Str::limit($service->description, 150) }}</p>
                        <div class="service-actions d-flex justify-content-between align-items-center">
                            <button class="btn btn-outline-primary btn-sm">View Details</button>
                            <div class="service-rating">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <span class="text-muted ms-1">(5.0)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-concierge-bell fa-3x text-muted"></i>
                    </div>
                    <h3 class="mb-3">No Services Available</h3>
                    <p class="text-muted">We're preparing our premium services for you. Please check back soon!</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!--===== SERVICES GRID AREA ENDS =======-->
@endsection