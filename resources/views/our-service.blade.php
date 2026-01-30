@extends('layouts.master')

@section('title', 'Our Services - FindaUk')

@section('content')
    <!--===== PAGE HERO AREA STARTS =======-->
    <!--===== PAGE HERO AREA STARTS =======-->
    <div class="common-hero-section-area sp1" style="background-color: #f4f5f7; position: relative;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto my-5">
                    <div class="common-hero-content text-center">
                        <h1 class="text-dark text-anime-style-3">Our Professional Services</h1>
                        <div class="space16"></div>
                        <ul class="page-list text-dark d-flex justify-content-center align-items-center"
                            style="list-style: none; padding: 0;">
                            <li class="px-1"><a href="{{ url('/') }}" class="text-dark"
                                    style="text-decoration: none;">Home</a></li>
                            <li class="px-1 text-dark">/</li>
                            <li class="px-1" style="color: #1CD494;">Services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== PAGE HERO AREA ENDS =======-->

    <!--===== SERVICES GRID AREA STARTS =======-->
    <div class="services-grid-section-area" style="padding-top: 40px; padding-bottom: 80px;">
        <div class="container">
            <div class="row">
                @forelse($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="service-boxarea text-center p-4 bg-white rounded shadow-sm hover-effect"
                            style="border: 1px solid #eee; transition: all 0.3s ease;">
                            <div class="service-img mb-4 position-relative mx-auto"
                                style="width: 100%; height: 200px; overflow: hidden; border-radius: 8px;">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid w-100 h-100"
                                        alt="{{ $service->title }}" style="object-fit: cover;">
                                @else
                                    <img src="{{ asset('theme/assets/images/services/default.jpg') }}" class="img-fluid w-100 h-100"
                                        alt="{{ $service->title }}" style="object-fit: cover; background: #f9f9f9;">
                                @endif
                                <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="background: rgba(0,0,0,0.5); opacity: 0; transition: all 0.3s ease;">
                                    <a href="#" class="theme-btn1 btn-sm">Learn More</a>
                                </div>
                            </div>

                            <h4 class="mb-3 font-weight-bold" style="color: #1a1a1a;">{{ $service->title }}</h4>
                            <p class="text-muted mb-4">{{ Str::limit($service->description, 120) }}</p>

                            <div class="service-icon mb-3">
                                <!-- You can add dynamic icons if available in DB, else static or remove -->
                                <i class="fa-solid fa-screwdriver-wrench text-warning fa-2x"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-concierge-bell fa-3x text-muted opacity-50"></i>
                            </div>
                            <h3 class="mb-3 text-muted">No Services Available</h3>
                            <p class="text-muted">We are preparing our premium services for you. Please check back soon!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!--===== SERVICES GRID AREA ENDS =======-->

    <style>
        .service-boxarea:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
            border-color: transparent !important;
        }

        .service-boxarea:hover .overlay {
            opacity: 1 !important;
        }

        .service-boxarea:hover h4 {
            color: #ff931e !important;
            transition: color 0.3s ease;
        }
    </style>
@endsection