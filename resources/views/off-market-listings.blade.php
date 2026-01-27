@extends('layouts.master')

@section('title', 'Off Market Listings - FindaUk')

@section('content')
<!--===== HERO AREA STARTS =======-->
<div class="hero-area-slider">
  <div class="hero1-section-area">
    <img src="{{ asset('assets/img/all-images/hero/hero-img1.png') }}" alt="housebox" class="hero-img1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="hero-header-area text-center">
            <h5>Discover Exclusive Off-Market Properties</h5>
            <div class="space32"></div>
            <h1>Off-Market Properties</h1>
            <div class="space40"></div>
            <div class="btn-area1">
              <a href="{{ route('listing.show', 1) }}" class="theme-btn1">Find Your Dream Home Now <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                  </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                  </svg></span></a>
              <a href="{{ route('listings.index') }}" class="theme-btn2">View Listings<span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                  </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                  </svg></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== OTHERS AREA STARTS =======-->
<div class="others-section-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="theme-btn1 open-search-filter-form">
          <p class="open-text">Open Search Form
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
            </svg>
          </p>
          <p class="close-text">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M10.5859 12L2.79297 4.20706L4.20718 2.79285L12.0001 10.5857L19.793 2.79285L21.2072 4.20706L13.4143 12L21.2072 19.7928L19.793 21.2071L12.0001 13.4142L4.20718 21.2071L2.79297 19.7928L10.5859 12Z"></path>
            </svg>
            Close
          </p>
        </div>
        <div class="property-tab-section search-filter-form">
          <div class="tab-header">
            <button class="tab-btn active" data-tab="for-sale">For Sale</button>
            <button class="tab-btn" data-tab="for-rent">For Rent</button>
          </div>

          <div class="tab-content1" id="for-sale">
            <div class="filters">
              <div class="filter-group">
                <label>Purpose</label>
                <select id="purpose-sale">
                  <option value="">All Purpose</option>
                  <option value="Buy">For Sale</option>
                  <option value="Rent">For Rent</option>
                </select>
              </div>
              <div class="filter-group">
                <label>Location</label>
                <input type="text" id="location-sale" placeholder="Enter location" class="form-control" style="padding:12px !important">
              </div>
              <div class="filter-group">
                <label>Radius</label>
                <select id="radius-sale">
                  <option value="">Select Radius</option>
                  <option value="1">1 mile</option>
                  <option value="1.5">1.5 miles</option>
                  <option value="2">2 miles</option>
                  <option value="5">5 miles</option>
                  <option value="10">10 miles</option>
                  <option value="25">25 miles</option>
                  <option value="50">50 miles</option>
                </select>
              </div>
              <div class="filter-group">
                <label for="customize-sale">Customize</label>
                <button id="customize-sale" class="customize-sale show-form" onclick="toggleCustomizeFilter('sale')">
                  Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z"></path>
                    </svg></span>
                </button>
              </div>
              <!-- Customize Filter Form -->
              <div id="customize-form-sale" class="customize-form" style="display: none;">
                <div class="customize-filters">
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Property Type</label>
                      <select id="property-type-sale">
                        <option value="">All Property Types</option>
                        @foreach(\App\Models\PropertyType::all() as $type)
                          <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Unit Type</label>
                      <select id="unit-type-sale">
                        <option value="">All Unit Types</option>
                        @foreach(\App\Models\UnitType::all() as $type)
                          <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Min Price</label>
                      <input type="number" id="min-price-sale" placeholder="Min Price">
                    </div>
                    <div class="filter-group">
                      <label>Max Price</label>
                      <input type="number" id="max-price-sale" placeholder="Max Price">
                    </div>
                    <div class="filter-group">
                      <label>Min Size (sq ft)</label>
                      <input type="number" id="min-size-sale" placeholder="Min Size">
                    </div>
                    <div class="filter-group">
                      <label>Max Size (sq ft)</label>
                      <input type="number" id="max-size-sale" placeholder="Max Size">
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Min Bedrooms</label>
                      <select id="min-bedrooms-sale">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Min Bathrooms</label>
                      <select id="min-bathrooms-sale">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Ownership Status</label>
                      <select id="ownership-status-sale">
                        <option value="">All</option>
                        @foreach(\App\Models\OwnershipStatus::all() as $status)
                          <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="features-section full-width">
                      <label>Features</label>
                      <div class="features-checkboxes">
                        @foreach(\App\Models\Feature::all() as $feature)
                          <label class="feature-checkbox">
                            <input type="checkbox" name="features-sale[]" value="{{ $feature->id }}">
                            <span>{{ $feature->title }}</span>
                          </label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="search-button">
                <button id="search-sale" onclick="searchOffMarketProperties('sale')">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                  </svg></button>
              </div>
            </div>
          </div>

          <div class="tab-content1" id="for-rent" style="display: none;">
            <div class="filters">
              <div class="filter-group">
                <label>Purpose</label>
                <select id="purpose-rent">
                  <option value="">All Purpose</option>
                  <option value="Buy">For Sale</option>
                  <option value="Rent">For Rent</option>
                </select>
              </div>
              <div class="filter-group">
                <label>Location</label>
                <input type="text" id="location-rent" placeholder="Enter location" class="form-control">
              </div>
              <div class="filter-group">
                <label>Radius</label>
                <select id="radius-rent">
                  <option value="">Select Radius</option>
                  <option value="1">1 mile</option>
                  <option value="1.5">1.5 miles</option>
                  <option value="2">2 miles</option>
                  <option value="5">5 miles</option>
                  <option value="10">10 miles</option>
                  <option value="25">25 miles</option>
                  <option value="50">50 miles</option>
                </select>
              </div>
              <div class="filter-group">
                <label for="customize-rent">Customize</label>
                <button id="customize-rent" class="customize-sale show-form" onclick="toggleCustomizeFilter('rent')">
                  Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z"></path>
                    </svg></span>
                </button>
              </div>
              <!-- Customize Filter Form -->
              <div id="customize-form-rent" class="customize-form" style="display: none;">
                <div class="customize-filters">
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Property Type</label>
                      <select id="property-type-rent">
                        <option value="">All Property Types</option>
                        @foreach(\App\Models\PropertyType::all() as $type)
                          <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Unit Type</label>
                      <select id="unit-type-rent">
                        <option value="">All Unit Types</option>
                        @foreach(\App\Models\UnitType::all() as $type)
                          <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Min Price</label>
                      <input type="number" id="min-price-rent" placeholder="Min Price">
                    </div>
                    <div class="filter-group">
                      <label>Max Price</label>
                      <input type="number" id="max-price-rent" placeholder="Max Price">
                    </div>
                    <div class="filter-group">
                      <label>Min Size (sq ft)</label>
                      <input type="number" id="min-size-rent" placeholder="Min Size">
                    </div>
                    <div class="filter-group">
                      <label>Max Size (sq ft)</label>
                      <input type="number" id="max-size-rent" placeholder="Max Size">
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Min Bedrooms</label>
                      <select id="min-bedrooms-rent">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Min Bathrooms</label>
                      <select id="min-bathrooms-rent">
                        <option value="">Any</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Ownership Status</label>
                      <select id="ownership-status-rent">
                        <option value="">All</option>
                        @foreach(\App\Models\OwnershipStatus::all() as $status)
                          <option value="{{ $status->id }}">{{ $status->title }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="filter-group">
                      <label>Rent Frequency</label>
                      <select id="rent-frequency-rent">
                        <option value="">All</option>
                        @foreach(\App\Models\RentFrequency::all() as $frequency)
                          <option value="{{ $frequency->id }}">{{ $frequency->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="filter-group">
                      <label>Cheque Options</label>
                      <select id="cheque-options-rent">
                        <option value="">All</option>
                        @foreach(\App\Models\Cheque::all() as $cheque)
                          <option value="{{ $cheque->id }}">{{ $cheque->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="filter-row">
                    <div class="features-section full-width">
                      <label>Features</label>
                      <div class="features-checkboxes">
                        @foreach(\App\Models\Feature::all() as $feature)
                          <label class="feature-checkbox">
                            <input type="checkbox" name="features-rent[]" value="{{ $feature->id }}">
                            <span>{{ $feature->title }}</span>
                          </label>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="search-button">
                <button id="search-rent" onclick="searchOffMarketProperties('rent')">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                  </svg></button>
              </div>
            </div>
          </div>





            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== OTHERS AREA STARTS =======-->

<!--===== PROPERTIES AREA STARTS =======-->
<div class="properties-section-area sp2" style="background-image: url({{ asset('assets/img/all-images/bg/bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <div class="property-heading heading1 text-center space-margin60">
          <h5>Exclusive Off-Market Properties</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Our Off-Market Listings</h2>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="property-feature-slider">
          <div class="col-lg-12 m-auto">
            <div class="tabs-btn-area space-margin60" data-aos="fade-up" data-aos-duration="1000">
              <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M19 21H5C4.44772 21 4 20.5523 4 20V11L1 11L11.3273 1.6115C11.7087 1.26475 12.2913 1.26475 12.6727 1.6115L23 11L20 11V20C20 20.5523 19.5523 21 19 21ZM6 19H18V9.15745L12 3.7029L6 9.15745V19ZM8 15H16V17H8V15Z"></path>
                    </svg>
                    For Sale
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12.5812 2.68627C12.2335 2.43791 11.7664 2.43791 11.4187 2.68627L1.9187 9.47198L3.08118 11.0994L11.9999 4.7289L20.9187 11.0994L22.0812 9.47198L12.5812 2.68627ZM19.5812 12.6863L12.5812 7.68627C12.2335 7.43791 11.7664 7.43791 11.4187 7.68627L4.4187 12.6863C4.15591 12.874 3.99994 13.177 3.99994 13.5V20C3.99994 20.5523 4.44765 21 4.99994 21H18.9999C19.5522 21 19.9999 20.5523 19.9999 20V13.5C19.9999 13.177 19.844 12.874 19.5812 12.6863ZM5.99994 19V14.0146L11.9999 9.7289L17.9999 14.0146V19H5.99994Z"></path>
                    </svg>
                    Villas
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M21 19H23V21H1V19H3V4C3 3.44772 3.44772 3 4 3H14C14.5523 3 15 3.44772 15 4V19H19V11H17V9H20C20.5523 9 21 9.44772 21 10V19ZM5 5V19H13V5H5ZM7 11H11V13H7V11ZM7 7H11V9H7V7Z"></path>
                    </svg>
                    Apartments
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact1-tab" data-bs-toggle="pill" data-bs-target="#pills-contact1" type="button" role="tab" aria-controls="pills-contact1" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12.6727 1.61162 20.7999 9H17.8267L12 3.70302 6 9.15757V19.0001H11V21.0001H5C4.44772 21.0001 4 20.5524 4 20.0001V11.0001L1 11.0001 11.3273 1.61162C11.7087 1.26488 12.2913 1.26488 12.6727 1.61162ZM14 11H23V18H14V11ZM16 13V16H21V13H16ZM24 21H13V19H24V21Z"></path>
                    </svg>
                    Houses
                  </button>
                </li>

                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact2-tab" data-bs-toggle="pill" data-bs-target="#pills-contact2" type="button" role="tab" aria-controls="pills-contact2" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M22 21H2V19H3V4C3 3.44772 3.44772 3 4 3H18C18.5523 3 19 3.44772 19 4V9H21V19H22V21ZM17 19H19V11H13V19H15V13H17V19ZM17 9V5H5V19H11V9H17ZM7 11H9V13H7V11ZM7 15H9V17H7V15ZM7 7H9V9H7V7Z"></path>
                    </svg>
                    Condos
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-contact3-tab" data-bs-toggle="pill" data-bs-target="#pills-contact3" type="button" role="tab" aria-controls="pills-contact3" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M3 19V5.70046C3 5.27995 3.26307 4.90437 3.65826 4.76067L13.3291 1.24398C13.5886 1.14961 13.8755 1.28349 13.9699 1.54301C13.9898 1.59778 14 1.65561 14 1.71388V6.6667L20.3162 8.77211C20.7246 8.90822 21 9.29036 21 9.72079V19H23V21H1V19H3ZM5 19H12V3.85543L5 6.40089V19ZM19 19V10.4416L14 8.77488V19H19Z"></path>
                    </svg>
                    Retail
                  </button>
                </li>
              </ul>
            </div>

            <div class="tab-content" id="pills-tabContent" data-aos="fade-up" data-aos-duration="1000">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="row">
                  @if(isset($offMarketListings) && count($offMarketListings) > 0)
                    @foreach($offMarketListings as $listing)
                      <div class="col-lg-4 col-md-6">
                        <div class="property-boxarea">
                          <div class="img1 image-anime">
                            <div class="swiper swiper-fade">
                              <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                  @if($listing->gallery && count($listing->gallery) > 0)
                                    <img src="{{ asset('storage/' . $listing->gallery[0]) }}" alt="{{ $listing->property_title }}">
                                  @elseif($listing->thumbnail)
                                    <img src="{{ asset('storage/' . $listing->thumbnail) }}" alt="{{ $listing->property_title }}">
                                  @else
                                    <img src="{{ asset('assets/img/all-images/properties/property-img2.png') }}" alt="housebox">
                                  @endif
                                </div>
                                @if($listing->gallery && count($listing->gallery) > 1)
                                  @for($i = 1; $i < min(count($listing->gallery), 4); $i++)
                                    <div class="swiper-slide">
                                      <img src="{{ asset('storage/' . $listing->gallery[$i]) }}" alt="{{ $listing->property_title }}">
                                    </div>
                                  @endfor
                                @endif
                              </div>
                              <div class="swiper-pagination"></div>
                            </div>
                          </div>
                          <div class="category-list">
                            <ul>
                              <li><a href="{{ route('off-market-listing.show', $listing->id) }}">Exclusive</a></li>
                              <li><a href="{{ route('off-market-listing.show', $listing->id) }}">{{ $listing->purpose }}</a></li>
                            </ul>
                          </div>
                          <div class="content-area">
                            <a href="{{ route('off-market-listing.show', $listing->id) }}">{{ $listing->property_title }}</a>
                            <div class="space18"></div>
                            <p>{{ $listing->address ?? ($listing->location ?? $listing->city) }}, {{ $listing->state ?? 'UK' }}</p>
                            <div class="space24"></div>
                            <ul>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/bed1.svg') }}" alt="housebox">{{ $listing->bedrooms ?? 'N/A' }}</a></li>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/bath1.svg') }}" alt="housebox">{{ $listing->bathrooms ?? 'N/A' }}</a></li>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/sqare1.svg') }}" alt="housebox">{{ $listing->area_size ?? 'N/A' }} sq</a></li>
                            </ul>
                            
                            <!-- Property Features/Amenities -->
                            @if($listing->features->count() > 0)
                            <div class="property-features d-flex flex-wrap gap-1 mt-2">
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
                            
                            <div class="btn-area">
                              <a href="#" class="nm-btn price-element" data-original-price="{{ $listing->price }}">£{{ number_format($listing->price) }}</a>
                              <a href="javascript:void(0)" class="heart"><img src="{{ asset('assets/img/icons/heart1.svg') }}" alt="housebox" class="heart1"> <img src="{{ asset('assets/img/icons/heart2.svg') }}" alt="housebox" class="heart2"></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="col-12">
                      <p class="text-center">No off-market properties available at the moment.</p>
                    </div>
                  @endif
                </div>
              </div>
              
              <!-- Additional tab panes for other property types would go here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== PROPERTIES AREA ENDS =======-->

<style>
/* Custom styles for Google Places Autocomplete */
.pac-container {
    z-index: 1051 !important; /* Higher than Bootstrap modal's z-index */
}

/* Improve filter layout and spacing */
.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: end;
}

/* Features section styling */
.features-section {
    width: 100%;
}

.features-section label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #333;
}

/* Features checkboxes styling */
.features-checkboxes {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    max-height: 250px;
    overflow-y: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.feature-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 10px;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: all 0.2s;
}

.feature-checkbox:hover {
    background-color: #f0f0f0;
    border-color: #999;
}

.feature-checkbox input[type="checkbox"] {
    margin-right: 10px;
    transform: scale(1.2);
}

.feature-checkbox span {
    font-size: 14px;
    color: #333;
    font-weight: normal;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .features-checkboxes {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .features-checkboxes {
        grid-template-columns: 1fr;
    }
}

.filter-group {
    flex: 1;
    min-width: 150px;
}

.filter-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    font-size: 14px;
}

.filter-group select,
.filter-group input {
    width: 80%;
    min-width: 150px;
}

.search-button {
    margin-left: 10px;
    margin-bottom: 2px;
}

@media (max-width: 768px) {
    .filters {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        width: 100%;
    }
    
    .search-button {
        margin-left: 0;
        margin-top: 10px;
    }
}

/* Customize Filter Form Styles */
.customize-form {
    margin-top: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.customize-filters .filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 15px;
}

.customize-filters .filter-row:last-child {
    margin-bottom: 0;
}

.customize-filters .filter-group {
    flex: 1;
    min-width: 150px;
}

.customize-filters .filter-group label {
    font-size: 13px;
    font-weight: 600;
}

.customize-filters .filter-group select[multiple] {
    height: 80px;
    overflow-y: auto;
}

.customize-filters .filter-group input,
.customize-filters .filter-group select {
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 14px;
}

.customize-filters .filter-group input:focus,
.customize-filters .filter-group select:focus {
    outline: none;
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

@media (max-width: 768px) {
    .customize-filters .filter-row {
        flex-direction: column;
    }
    
    .customize-filters .filter-group {
        width: 100%;
    }
}

.customize-filters .filter-group.full-width {
    flex: 100%;
    min-width: 100%;
}

.customize-filters .filter-group.full-width select[multiple] {
    height: 100px;
    min-height: 100px;
}

/* Style for multiple select dropdowns */
.customize-filters select[multiple] {
    height: 80px;
    min-height: 80px;
    padding: 5px;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 14px;
    width: 100%;
    overflow-y: auto;
}

.customize-filters select[multiple]:focus {
    outline: none;
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
</style>

<script>
// Load Google Maps API
function loadGoogleMapsAPI() {
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initLocationAutocomplete';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

// Variables to store coordinates
let selectedLatSale = null;
let selectedLngSale = null;
let selectedLatRent = null;
let selectedLngRent = null;

function initLocationAutocomplete() {
    // Initialize Google Places Autocomplete for sale tab
    const locationInputSale = document.getElementById('location-sale');
    if (locationInputSale) {
        const options = {
            componentRestrictions: { country: 'gb' },
            fields: ['geometry', 'formatted_address', 'name', 'place_id'],
            types: ['geocode', 'establishment']
        };
        const autocompleteSale = new google.maps.places.Autocomplete(locationInputSale, options);
        
        autocompleteSale.addListener('place_changed', function () {
            const place = autocompleteSale.getPlace();
            if (place.geometry) {
                // Store coordinates for radius search
                selectedLatSale = place.geometry.location.lat();
                selectedLngSale = place.geometry.location.lng();
                console.log('Location selected for sale:', place.formatted_address, 'Lat:', selectedLatSale, 'Lng:', selectedLngSale);
            }
        });
    }
    
    // Initialize Google Places Autocomplete for rent tab
    const locationInputRent = document.getElementById('location-rent');
    if (locationInputRent) {
        const options = {
            componentRestrictions: { country: 'gb' },
            fields: ['geometry', 'formatted_address', 'name', 'place_id'],
            types: ['geocode', 'establishment']
        };
        const autocompleteRent = new google.maps.places.Autocomplete(locationInputRent, options);
        
        autocompleteRent.addListener('place_changed', function () {
            const place = autocompleteRent.getPlace();
            if (place.geometry) {
                // Store coordinates for radius search
                selectedLatRent = place.geometry.location.lat();
                selectedLngRent = place.geometry.location.lng();
                console.log('Location selected for rent:', place.formatted_address, 'Lat:', selectedLatRent, 'Lng:', selectedLngRent);
            }
        });
    }
}

function searchOffMarketProperties(tab) {
    // Determine purpose based on the active tab, not the dropdown value
    let purpose;
    if (tab === 'sale') {
        purpose = 'Buy';  // For Sale tab should always use 'Buy' purpose
    } else if (tab === 'rent') {
        purpose = 'Rent';  // For Rent tab should always use 'Rent' purpose
    } else {
        purpose = document.getElementById(`purpose-${tab}`).value;
    }
    
    const location = document.getElementById(`location-${tab}`).value;
    const radius = document.getElementById(`radius-${tab}`).value;
    
    // Get customize filter values
    const propertyType = document.getElementById(`property-type-${tab}`)?.value;
    const unitType = document.getElementById(`unit-type-${tab}`)?.value;
    const minPrice = document.getElementById(`min-price-${tab}`)?.value;
    const maxPrice = document.getElementById(`max-price-${tab}`)?.value;
    const minSize = document.getElementById(`min-size-${tab}`)?.value;
    const maxSize = document.getElementById(`max-size-${tab}`)?.value;
    const minBedrooms = document.getElementById(`min-bedrooms-${tab}`)?.value;
    const minBathrooms = document.getElementById(`min-bathrooms-${tab}`)?.value;
    const ownershipStatus = document.getElementById(`ownership-status-${tab}`)?.value;
    const rentFrequency = document.getElementById(`rent-frequency-${tab}`)?.value;
    const chequeOptions = document.getElementById(`cheque-options-${tab}`)?.value;
    
    // Get selected features (checkboxes)
    const featureCheckboxes = document.querySelectorAll(`input[name="features-${tab}[]"]:checked`);
    let features = [];
    featureCheckboxes.forEach(checkbox => {
        features.push(checkbox.value);
    })
    
    // Build query parameters
    const params = new URLSearchParams();
    if (purpose) params.append('purpose', purpose);
    
    // Use coordinates if available, otherwise use location name
    if (tab === 'sale' && selectedLatSale && selectedLngSale) {
        params.append('lat', selectedLatSale);
        params.append('lng', selectedLngSale);
    } else if (tab === 'rent' && selectedLatRent && selectedLngRent) {
        params.append('lat', selectedLatRent);
        params.append('lng', selectedLngRent);
    } else if (location) {
        params.append('location', location);
    }
    
    if (radius) params.append('radius', radius);
    if (propertyType) params.append('property_type_id', propertyType);
    if (unitType) params.append('unit_type_id', unitType);
    if (minPrice) params.append('min_price', minPrice);
    if (maxPrice) params.append('max_price', maxPrice);
    if (minSize) params.append('min_size', minSize);
    if (maxSize) params.append('max_size', maxSize);
    if (minBedrooms) params.append('min_bedrooms', minBedrooms);
    if (minBathrooms) params.append('min_bathrooms', minBathrooms);
    if (ownershipStatus) params.append('ownership_status_id', ownershipStatus);
    if (rentFrequency) params.append('rent_frequency_id', rentFrequency);
    if (chequeOptions) params.append('cheque_id', chequeOptions);
    if (features.length > 0) params.append('features', features.join(','));
    
    // Redirect to off-market listings page with filters
    window.location.href = `{{ route('off-market-listings.index') }}?${params.toString()}`;
}

// Handle customize filter toggle
function toggleCustomizeFilter(tab) {
    const form = document.getElementById(`customize-form-${tab}`);
    const button = document.getElementById(`customize-${tab}`);
    
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        button.classList.add('active');
        button.innerHTML = 'Hide <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg></span>';
    } else {
        form.style.display = 'none';
        button.classList.remove('active');
        button.innerHTML = 'Advance <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M6.17071 18C6.58254 16.8348 7.69378 16 9 16C10.3062 16 11.4175 16.8348 11.8293 18H22V20H11.8293C11.4175 21.1652 10.3062 22 9 22C7.69378 22 6.58254 21.1652 6.17071 20H2V18H6.17071ZM12.1707 11C12.5825 9.83481 13.6938 9 15 9C16.3062 9 17.4175 9.83481 17.8293 11H22V13H17.8293C17.4175 14.1652 16.3062 15 15 15C13.6938 15 12.5825 14.1652 12.1707 13H2V11H12.1707ZM6.17071 4C6.58254 2.83481 7.69378 2 9 2C10.3062 2 11.4175 2.83481 11.8293 4H22V6H11.8293C11.4175 7.16519 10.3062 8 9 8C7.69378 8 6.58254 7.16519 6.17071 6H2V4H6.17071Z"/></svg></span>';
    }
}

// Tab switching functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content1');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.style.display = 'none');
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Show corresponding content
            document.getElementById(tabId).style.display = 'block';
            
            // Update purpose dropdown based on active tab
            if (tabId === 'for-sale') {
                document.getElementById('purpose-sale').value = 'Buy';
            } else if (tabId === 'for-rent') {
                document.getElementById('purpose-rent').value = 'Rent';
            }
        });
    });
});

// Load Google Maps API when DOM is ready
if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
    document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
} else {
    // Google Maps API is already loaded
    initLocationAutocomplete();
}

</script>
<script src="{{ asset('js/currency-converter.js') }}"></script>
<script>
// Initialize currency converter
document.addEventListener('DOMContentLoaded', function() {
    if (typeof initializeCurrencyConverter === 'function') {
        initializeCurrencyConverter();
    }
});
</script>

@endsection