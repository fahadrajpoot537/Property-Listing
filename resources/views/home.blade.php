@extends('layouts.master')

@section('title', 'Home - FindaUk')

@section('content')
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
<!--===== HERO AREA STARTS =======-->
<div class="hero-area-slider">
  <div class="hero1-section-area">
    <img src="{{ asset('assets/img/all-images/hero/hero-img1.png') }}" alt="housebox" class="hero-img1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="hero-header-area text-center">
            <h5>Discover Your Ideal Property Today!</h5>
            <div class="space32"></div>
            <h1>Find Your Perfect Home</h1>
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

  <div class="hero1-section-area">
    <img src="{{ asset('assets/img/all-images/hero/hero-img2.png') }}" alt="housebox" class="hero-img1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="hero-header-area text-center">
            <h5>Discover Your Ideal Property Today!</h5>
            <div class="space32"></div>
            <h1>Find Your Dream Home</h1>
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

  <div class="hero1-section-area">
    <img src="{{ asset('assets/img/all-images/hero/hero-img3.png') }}" alt="housebox" class="hero-img1">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="hero-header-area text-center">
            <h5>Discover Your Ideal Property Today!</h5>
            <div class="space32"></div>
            <h1>Find Your Luxury Home</h1>
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
<div class="testimonial-arrows">
  <div class="testimonial-prev-arrow">
    <button><i class="fa-solid fa-angle-left"></i></button>
  </div>
  <div class="testimonial-next-arrow">
    <button><i class="fa-solid fa-angle-right"></i></button>
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
                <button id="search-sale" onclick="searchProperties('sale')">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
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
                <button id="search-rent" onclick="searchProperties('rent')">Search <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
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

<!--===== ABOUT AREA STARTS =======-->
<div class="about1-section-area sp1">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="about-images-area">
          <div class="img2 image-anime reveal">
            <img src="{{ asset('assets/img/all-images/about/about-img2.png') }}" alt="housebox">
          </div>
          <div class="img1 image-anime reveal">
            <img src="{{ asset('assets/img/all-images/about/about-img1.png') }}" alt="housebox">
          </div>
          <div class="author-img aniamtion-key-1">
            <h3>Our Happy Customer</h3>
            <div class="space18"></div>
            <img src="{{ asset('assets/img/all-images/others/author-img1.png') }}" alt="housebox">
          </div>
        </div>
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-5">
        <div class="about-heading heading1">
          <h5 data-aos="fade-left" data-aos-duration="800">About housebox</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Embrace the Elegance Our Exclusive Property</h2>
          <div class="space18"></div>
          <p data-aos="fade-left" data-aos-duration="900">At HouseBox, we're redefining the way people find, sell, and invest in properties. Our mission is to simplify real estate by provide innovative solutions, expert guidance.</p>
          <div class="space32"></div>
          <div class="counter-boxes" data-aos="fade-left" data-aos-duration="1000">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-6">
                <div class="counter-boxarea text-center">
                  <h2><span class="counter">10</span>K</h2>
                  <div class="space12"></div>
                  <p>Homes Sold</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-6">
                <div class="counter-boxarea text-center">
                  <h2><span class="counter">9</span>K</h2>
                  <div class="space12"></div>
                  <p>Happy Client</p>
                </div>
              </div>

              <div class="col-lg-4 col-md-4 col-6">
                <div class="space20 d-md-none d-block"></div>
                <div class="counter-boxarea text-center">
                  <h2><span class="counter">98</span>%</h2>
                  <div class="space12"></div>
                  <p>Satisfaction Rate</p>
                </div>
              </div>
            </div>
          </div>
          <div class="space32"></div>
          <div class="btn-area1" data-aos="fade-left" data-aos-duration="1100">
            <a href="{{ route('listings.index') }}" class="theme-btn1">See All Properties <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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
<!--===== ABOUT AREA ENDS =======-->

<!--===== PROPERTIES AREA STARTS =======-->
<div class="properties-section-area sp2" style="background-image: url({{ asset('assets/img/all-images/bg/bg1.png') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <div class="property-heading heading1 text-center space-margin60">
          <h5>Featured Properties</h5>
          <div class="space20"></div>
          <h2 class="text-anime-style-3">Our Featured Properties</h2>
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
                  <button class="nav-link" id="pills-rent-tab" data-bs-toggle="pill" data-bs-target="#pills-rent" type="button" role="tab" aria-controls="pills-rent" aria-selected="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M12.5812 2.68627C12.2335 2.43791 11.7664 2.43791 11.4187 2.68627L1.9187 9.47198L3.08118 11.0994L11.9999 4.7289L20.9187 11.0994L22.0812 9.47198L12.5812 2.68627ZM19.5812 12.6863L12.5812 7.68627C12.2335 7.43791 11.7664 7.43791 11.4187 7.68627L4.4187 12.6863C4.15591 12.874 3.99994 13.177 3.99994 13.5V20C3.99994 20.5523 4.44765 21 4.99994 21H18.9999C19.5522 21 19.9999 20.5523 19.9999 20V13.5C19.9999 13.177 19.844 12.874 19.5812 12.6863ZM5.99994 19V14.0146L11.9999 9.7289L17.9999 14.0146V19H5.99994Z"></path>
                    </svg>
                    For Rent
                  </button>
                </li>
              </ul>
            </div>

            <div class="tab-content" id="pills-tabContent" data-aos="fade-up" data-aos-duration="1000">
              <!-- For Sale Tab -->
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="row">
                  @php
                    $saleListings = \App\Models\Listing::with('features', 'user')
                      ->where('status', 'approved')
                      ->where('purpose', 'Buy')
                      ->latest()->take(6)->get();
                    
                    // Process listings to add images array like in getFeaturedListings
                    $processedSaleListings = $saleListings->map(function ($listing) {
                        $images = [];
                        
                        // Handle gallery field (could be JSON string or array)
                        if ($listing->gallery) {
                            if (is_string($listing->gallery)) {
                                $gallery = json_decode($listing->gallery, true);
                            } else {
                                $gallery = $listing->gallery;
                            }
                            
                            if (is_array($gallery) && !empty($gallery)) {
                                $images = $gallery;
                            }
                        }
                        
                        // Add thumbnail if available and not already in images
                        if ($listing->thumbnail && !in_array($listing->thumbnail, $images)) {
                            array_unshift($images, $listing->thumbnail); // Add to beginning
                        }
                        
                        // Add images array to the listing
                        $listing->images = $images;
                        return $listing;
                    });
                  @endphp
                  @if(isset($processedSaleListings) && count($processedSaleListings) > 0)
                    @foreach($processedSaleListings as $listing)
                      <div class="col-lg-4 col-md-6">
                        <div class="property-boxarea">
                          <div class="img1 image-anime">
                            <div class="swiper swiper-fade">
                              <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                  @if($listing->images && count($listing->images) > 0)
                                    <img src="{{ Storage::url($listing->images[0]) }}" alt="{{ $listing->property_title ?? $listing->title }}">
                                  @else
                                    <img src="{{ asset('assets/img/all-images/properties/property-img2.png') }}" alt="housebox">
                                  @endif
                                </div>
                                @if($listing->images && count($listing->images) > 1)
                                  @for($i = 1; $i < min(count($listing->images), 4); $i++)
                                    <div class="swiper-slide">
                                      <img src="{{ Storage::url($listing->images[$i]) }}" alt="{{ $listing->property_title ?? $listing->title }}">
                                    </div>
                                  @endfor
                                @endif
                              </div>
                              <div class="swiper-pagination"></div>
                            </div>
                          </div>
                          <div class="category-list">
                            <ul>
                              <li><a href="{{ route('listing.show', $listing->id) }}">Featured</a></li>
                              <li><a href="{{ route('listing.show', $listing->id) }}">{{ $listing->purpose }}</a></li>
                            </ul>
                          </div>
                          <div class="content-area">
                            <a href="{{ route('listing.show', $listing->id) }}">{{ $listing->property_title ?? $listing->title }}</a>
                            <div class="space18"></div>
                            <p>{{ $listing->address ?? $listing->location ?? $listing->city }}, {{ $listing->state ?? 'UK' }}</p>
                            <div class="space24"></div>
                            <ul>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/bed1.svg') }}" alt="housebox">{{ $listing->bedrooms ?? 'N/A' }}</a></li>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/bath1.svg') }}" alt="housebox">{{ $listing->bathrooms ?? 'N/A' }}</a></li>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/sqare1.svg') }}" alt="housebox">{{ $listing->area_size ?? 'N/A' }} sq</a></li>
                            </ul>
                            <div class="btn-area">
                              <a href="#" class="nm-btn">£{{ number_format($listing->price) }}</a>
                              <a href="javascript:void(0)" class="heart"><img src="{{ asset('assets/img/icons/heart1.svg') }}" alt="housebox" class="heart1"> <img src="{{ asset('assets/img/icons/heart2.svg') }}" alt="housebox" class="heart2"></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="col-12">
                      <p class="text-center">No properties for sale available at the moment.</p>
                    </div>
                  @endif
                </div>
              </div>
              
              <!-- For Rent Tab -->
              <div class="tab-pane fade" id="pills-rent" role="tabpanel" aria-labelledby="pills-rent-tab" tabindex="0">
                <div class="row">
                  @php
                    $rentListings = \App\Models\Listing::with('features', 'user')
                      ->where('status', 'approved')
                      ->where('purpose', 'Rent')
                      ->latest()->take(6)->get();
                    
                    // Process listings to add images array like in getFeaturedListings
                    $processedRentListings = $rentListings->map(function ($listing) {
                        $images = [];
                        
                        // Handle gallery field (could be JSON string or array)
                        if ($listing->gallery) {
                            if (is_string($listing->gallery)) {
                                $gallery = json_decode($listing->gallery, true);
                            } else {
                                $gallery = $listing->gallery;
                            }
                            
                            if (is_array($gallery) && !empty($gallery)) {
                                $images = $gallery;
                            }
                        }
                        
                        // Add thumbnail if available and not already in images
                        if ($listing->thumbnail && !in_array($listing->thumbnail, $images)) {
                            array_unshift($images, $listing->thumbnail); // Add to beginning
                        }
                        
                        // Add images array to the listing
                        $listing->images = $images;
                        return $listing;
                    });
                  @endphp
                  @if(isset($processedRentListings) && count($processedRentListings) > 0)
                    @foreach($processedRentListings as $listing)
                      <div class="col-lg-4 col-md-6">
                        <div class="property-boxarea">
                          <div class="img1 image-anime">
                            <div class="swiper swiper-fade">
                              <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                  @if($listing->images && count($listing->images) > 0)
                                    <img src="{{ Storage::url($listing->images[0]) }}" alt="{{ $listing->property_title ?? $listing->title }}">
                                  @else
                                    <img src="{{ asset('assets/img/all-images/properties/property-img2.png') }}" alt="housebox">
                                  @endif
                                </div>
                                @if($listing->images && count($listing->images) > 1)
                                  @for($i = 1; $i < min(count($listing->images), 4); $i++)
                                    <div class="swiper-slide">
                                      <img src="{{ Storage::url($listing->images[$i]) }}" alt="{{ $listing->property_title ?? $listing->title }}">
                                    </div>
                                  @endfor
                                @endif
                              </div>
                              <div class="swiper-pagination"></div>
                            </div>
                          </div>
                          <div class="category-list">
                            <ul>
                              <li><a href="{{ route('listing.show', $listing->id) }}">Featured</a></li>
                              <li><a href="{{ route('listing.show', $listing->id) }}">{{ $listing->purpose }}</a></li>
                            </ul>
                          </div>
                          <div class="content-area">
                            <a href="{{ route('listing.show', $listing->id) }}">{{ $listing->property_title ?? $listing->title }}</a>
                            <div class="space18"></div>
                            <p>{{ $listing->address ?? $listing->location ?? $listing->city }}, {{ $listing->state ?? 'UK' }}</p>
                            <div class="space24"></div>
                            <ul>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/bed1.svg') }}" alt="housebox">{{ $listing->bedrooms ?? 'N/A' }}</a></li>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/bath1.svg') }}" alt="housebox">{{ $listing->bathrooms ?? 'N/A' }}</a></li>
                              <li><a href="#"><img src="{{ asset('assets/img/icons/sqare1.svg') }}" alt="housebox">{{ $listing->area_size ?? 'N/A' }} sq</a></li>
                            </ul>
                            <div class="btn-area">
                              <a href="#" class="nm-btn">£{{ number_format($listing->price) }}</a>
                              <a href="javascript:void(0)" class="heart"><img src="{{ asset('assets/img/icons/heart1.svg') }}" alt="housebox" class="heart1"> <img src="{{ asset('assets/img/icons/heart2.svg') }}" alt="housebox" class="heart2"></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="col-12">
                      <p class="text-center">No properties for rent available at the moment.</p>
                    </div>
                  @endif
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
<div class="project1-section-area sp2">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="project-heading heading1 space-margin60 text-center">
            <h5>3 step to buy sell property</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">See How Realton Can Help</h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="800">
          <div class="project-featured-box">
            <div class="img1">
              <img src="assets/img/all-images/project/project-img1.png" alt="housebox">
            </div>
            <div class="space40"></div>
            <div class="btn-area">
              <a href="sidebar-grid">Buy A Property</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="1000">
          <div class="project-featured-box">
            <div class="img1">
              <img src="assets/img/all-images/project/project-img2.png" alt="housebox">
            </div>
            <div class="space40"></div>
            <div class="btn-area">
              <a href="sidebar-grid">Sell A Property</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="1200">
          <div class="project-featured-box">
            <div class="img1">
              <img src="assets/img/all-images/project/project-img3.png" alt="housebox">
            </div>
            <div class="space40"></div>
            <div class="btn-area">
              <a href="sidebar-grid">Rent A Property</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="items-section-area sp1" style="background-image: url(assets/img/all-images/bg/bg2.png); background-position: center; background-repeat: no-repeat; background-size: cover; background-attachment: fixed;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-4">
          <div class="item-header heading1">
            <h5 data-aos="fade-left" data-aos-duration="800">our best featured item</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Our Featured Items</h2>
            <div class="space16"></div>
            <p data-aos="fade-left" data-aos-duration="900">At HouseBox, we’re redefining the way peoples find, sell, and invest the properties, our mission.</p>
            <div class="space28"></div>
            <div class="btn-area1" data-aos="fade-left" data-aos-duration="1000">
              <a href="sidebar-grid" class="theme-btn1">See All Properties <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                  </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                    <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                  </svg></span></a>
            </div>
          </div>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-4">
          <div class="box-slider">
            <div class="item-featured-boxarea">
              <h5><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11.5L16 8L12.5 17.0021L11 13L7 11.5Z"></path>
                  </svg></span> 60002 Just Mead East Alfonso</h5>
              <div class="space20"></div>
              <h2>Moon Light Villa</h2>
              <div class="space28"></div>
              <h3><s>$1.900,000</s>$1.800,000</h3>
              <div class="space28"></div>
              <div class="btn-area1">
                <a href="sidebar-grid" class="theme-btn1">Schedule Visit <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                      <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                      <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span></a>
              </div>
            </div>

            <div class="item-featured-boxarea">
              <h5><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11.5L16 8L12.5 17.0021L11 13L7 11.5Z"></path>
                  </svg></span> 60002 Just Mead East Alfonso</h5>
              <div class="space20"></div>
              <h2>Moon Light Villa</h2>
              <div class="space28"></div>
              <h3><s>$1.900,000</s>$1.800,000</h3>
              <div class="space28"></div>
              <div class="btn-area1">
                <a href="sidebar-grid" class="theme-btn1">Schedule Visit <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                      <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                      <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span></a>
              </div>
            </div>

            <div class="item-featured-boxarea">
              <h5><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM7 11.5L16 8L12.5 17.0021L11 13L7 11.5Z"></path>
                  </svg></span> 60002 Just Mead East Alfonso</h5>
              <div class="space20"></div>
              <h2>Moon Light Villa</h2>
              <div class="space28"></div>
              <h3><s>$1.900,000</s>$1.800,000</h3>
              <div class="space28"></div>
              <div class="btn-area1">
                <a href="sidebar-grid" class="theme-btn1">Schedule Visit <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                      <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span><span class="arrow2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                      <path d="M12 13H4V11H12V4L20 12L12 20V13Z"></path>
                    </svg></span></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-1">
          <div class="testimonial-arrows">
            <div class="prev-arrow">
              <button><i class="fa-solid fa-angle-up"></i></button>
            </div>
            <div class="next-arrow">
              <button><i class="fa-solid fa-angle-down"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--===== ITEMS AREA ENDS =======-->

  <!--===== PROPERTY-LOCATION AREA STARTS =======-->
  <div class="property-location-section-area sp1">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 m-auto">
          <div class="property-headeing heading1 space-margin60 text-center">
            <h5>property location</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">Explore Our Property Location</h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12" data-aos="fade-up" data-aos-duration="1000">
          <div class="property-single-slider owl-carousel">
            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img1.png" alt="housebox">
              </div>
              <h3>32</h3>
              <a href="property-details-v1">San Francisco</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img2.png" alt="housebox">
              </div>
              <h3>12</h3>
              <a href="property-details-v1">Los Angeles</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img3.png" alt="housebox">
              </div>
              <h3>15</h3>
              <a href="property-details-v1">New York</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img4.png" alt="housebox">
              </div>
              <h3>40</h3>
              <a href="property-details-v1">San Diego</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img5.png" alt="housebox">
              </div>
              <h3>19</h3>
              <a href="property-details-v1">Dallas Texas</a>
            </div>
            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img1.png" alt="housebox">
              </div>
              <h3>32</h3>
              <a href="property-details-v1">San Francisco</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img2.png" alt="housebox">
              </div>
              <h3>12</h3>
              <a href="property-details-v1">Los Angeles</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img3.png" alt="housebox">
              </div>
              <h3>15</h3>
              <a href="property-details-v1">New York</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img4.png" alt="housebox">
              </div>
              <h3>40</h3>
              <a href="property-details-v1">San Diego</a>
            </div>

            <div class="propety-single-boxarea">
              <div class="img1 image-anime">
                <img src="assets/img/all-images/property_location/property-img5.png" alt="housebox">
              </div>
              <h3>19</h3>
              <a href="property-details-v1">Dallas Texas</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="testimonial1-section-area sp1" style="background-image: url(assets/img/all-images/bg/bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="testimonial-header space-margin60 heading1">
            <h5 data-aos="fade-left" data-aos-duration="800">feedback/testimonial</h5>
            <div class="space20"></div>
            <h2 class="text-anime-style-3">A Legacy Of Happy Clients</h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="testimonialmain-slider">
            <div class="row align-items-center">
              <div class="col-lg-5">
                <div class="images-area2 slider2">
                  <div class="img1 image-anime">
                    <img src="assets/img/all-images/testimonial/testimonial-img1.png" alt="housebox">
                  </div>
                  <div class="img1 image-anime">
                    <img src="assets/img/all-images/testimonial/testimonial-img1-1.png" alt="housebox">
                  </div>
                  <div class="img1 image-anime">
                    <img src="assets/img/all-images/testimonial/testimonial-img1-2.png" alt="housebox">
                  </div>
                  <div class="img1 image-anime">
                    <img src="assets/img/all-images/testimonial/testimonial-img1-3.png" alt="housebox">
                  </div>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="testimonial-slider-area slider1">
                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon1.svg" alt="housebox">
                    <div class="space16"></div>
                    <p>"When I decided to sell my home, I was overwhelmed with where to start. HouseBox stepped in with a clear plan, professional marketing, constant communicate. Within two weeks, my house was sold above asking.”</p>
                    <div class="space32"></div>
                    <div class="test-images">
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-img2.png" alt="housebox">
                        </div>
                        <div class="text">
                          <a href="#">Shakib Mahmud</a>
                          <div class="space10"></div>
                          <p>Happy Client</p>
                        </div>
                      </div>
                      <img src="assets/img/elements/brand1.png" alt="housebox" class="brand1">
                    </div>
                  </div>
                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon1.svg" alt="housebox">
                    <div class="space16"></div>
                    <p>"Selling our home felt like a huge challenge until we found. Their team guided us every step of the way, from staging the property to negotiating offers. Within days, our home was sold for more than we expected."</p>
                    <div class="space32"></div>
                    <div class="test-images">
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-img3.png" alt="housebox">
                        </div>
                        <div class="text">
                          <a href="#">Xavi Alonso</a>
                          <div class="space10"></div>
                          <p>Happy Client</p>
                        </div>
                      </div>
                      <img src="assets/img/elements/brand1.png" alt="housebox" class="brand1">
                    </div>
                  </div>

                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon1.svg" alt="housebox">
                    <div class="space16"></div>
                    <p>"We were first-time buyers, and the process seemed daunting. made everything so simple and stress-free. They listened to our needs, showed us perfect options"</p>
                    <div class="space32"></div>
                    <div class="test-images">
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-img4.png" alt="housebox">
                        </div>
                        <div class="text">
                          <a href="#">Granit Xhaka</a>
                          <div class="space10"></div>
                          <p>Happy Client</p>
                        </div>
                      </div>
                      <img src="assets/img/elements/brand1.png" alt="housebox" class="brand1">
                    </div>
                  </div>

                  <div class="testimonial-box">
                    <img src="assets/img/icons/quoto-icon1.svg" alt="housebox">
                    <div class="space16"></div>
                    <p>"I relocated for work and needed to sell my house quickly. [Your Real Estate Agency] delivered! They handled everything smoothly, and I could focus on my move without worry. I highly recommend their services."</p>
                    <div class="space32"></div>
                    <div class="test-images">
                      <div class="auhtor-area">
                        <div class="img1">
                          <img src="assets/img/all-images/testimonial/testimonial-img5.png" alt="housebox">
                        </div>
                        <div class="text">
                          <a href="#">Alex Garcia</a>
                          <div class="space10"></div>
                          <p>Happy Client</p>
                        </div>
                      </div>
                      <img src="assets/img/elements/brand1.png" alt="housebox" class="brand1">
                    </div>
                  </div>
                </div>
                <div class="testimonial-arrows">
                  <div class="prev-arrow">
                    <button><i class="fa-solid fa-angle-left"></i></button>
                  </div>
                  <div class="next-arrow">
                    <button><i class="fa-solid fa-angle-right"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <div class="cta1-section-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="cta-bg-area" style="background-image: url(assets/img/all-images/bg/cta-bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
            <div class="row align-items-center">
              <div class="col-lg-5">
                <div class="cta-header">
                  <h2 class="text-anime-style-3">Step Into Your Dream Home with HouseBox</h2>
                  <div class="space16"></div>
                  <p data-aos="fade-left" data-aos-duration="1000">At HouseBox, we believe your next home is more than just a place – it’s where your future begins you’re buy.</p>
                </div>
              </div>
              <div class="col-lg-2"></div>
              <div class="col-lg-5" data-aos="zoom-in" data-aos-duration="1000">
                <div class="btn-area1 text-center">
                  <a href="sidebar-grid" class="theme-btn1">Find Your Dream Home <span class="arrow1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
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
  </div>

  
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
        
        autocompleteSale.addListener('place_changed', function() {
            const place = autocompleteSale.getPlace();
            if (place.geometry) {
                // Store coordinates for radius search
                selectedLatSale = place.geometry.location.lat();
                selectedLngSale = place.geometry.location.lng();
                console.log('Location selected for sale:', place.formatted_address, 'Lat:', selectedLatSale, 'Lng:', selectedLngSale);
                
                // Show warning if the selected location doesn't contain E14
                if (place.formatted_address && !place.formatted_address.includes('E14')) {
                    console.warn('Warning: Selected location may not be E14. Address:', place.formatted_address);
                    // Optionally show user a warning
                    alert('Warning: The selected location "' + place.formatted_address + '" may not be in the E14 area. Please verify the location.');
                }
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
        
        autocompleteRent.addListener('place_changed', function() {
            const place = autocompleteRent.getPlace();
            if (place.geometry) {
                // Store coordinates for radius search
                selectedLatRent = place.geometry.location.lat();
                selectedLngRent = place.geometry.location.lng();
                console.log('Location selected for rent:', place.formatted_address, 'Lat:', selectedLatRent, 'Lng:', selectedLngRent);
                
                // Show warning if the selected location doesn't contain E14
                if (place.formatted_address && !place.formatted_address.includes('E14')) {
                    console.warn('Warning: Selected location may not be E14. Address:', place.formatted_address);
                    // Optionally show user a warning
                    alert('Warning: The selected location "' + place.formatted_address + '" may not be in the E14 area. Please verify the location.');
                }
            }
        });
    }
}

function searchProperties(tab) {
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
    
    // Get selected features (multiple select)
    const featuresSelect = document.getElementById(`features-${tab}`);
    let features = [];
    if (featuresSelect) {
        for (let i = 0; i < featuresSelect.selectedOptions.length; i++) {
            features.push(featuresSelect.selectedOptions[i].value);
        }
    }
    
    // Build query parameters
    const params = new URLSearchParams();
    if (purpose) params.append('purpose', purpose);
    
    // Use coordinates if available, otherwise use location name
    console.log('DEBUG: Tab=' + tab + ', selectedLatSale=' + selectedLatSale + ', selectedLngSale=' + selectedLngSale);
    console.log('DEBUG: Tab=' + tab + ', selectedLatRent=' + selectedLatRent + ', selectedLngRent=' + selectedLngRent);
    console.log('DEBUG: Location=' + location + ', Radius=' + radius);
    
    if (tab === 'sale' && selectedLatSale && selectedLngSale) {
        console.log('Using SALE coordinates: lat=' + selectedLatSale + ', lng=' + selectedLngSale);
        params.append('lat', selectedLatSale);
        params.append('lng', selectedLngSale);
    } else if (tab === 'rent' && selectedLatRent && selectedLngRent) {
        console.log('Using RENT coordinates: lat=' + selectedLatRent + ', lng=' + selectedLngRent);
        params.append('lat', selectedLatRent);
        params.append('lng', selectedLngRent);
    } else if (location) {
        console.log('Using location name: ' + location);
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
    
    // Redirect to property listing page with filters
    window.location.href = `{{ route('listings.index') }}?${params.toString()}`;
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
                // Load 'Buy' properties
                loadFeaturedListings('Buy');
                
                // Update URL to reflect the selected purpose
                const url = new URL(window.location);
                url.searchParams.set('purpose', 'Buy');
                window.history.replaceState({}, '', url);
            } else if (tabId === 'for-rent') {
                document.getElementById('purpose-rent').value = 'Rent';
                // Load 'Rent' properties
                loadFeaturedListings('Rent');
                
                // Update URL to reflect the selected purpose
                const url = new URL(window.location);
                url.searchParams.set('purpose', 'Rent');
                window.history.replaceState({}, '', url);
            }
            
            // Update property type tabs to reflect the selected purpose
            updatePropertyTypeTabs(getActivePurpose());
        });
    });
});

// Function to get active purpose based on selected tab
function getActivePurpose() {
    const saleTab = document.querySelector('[data-tab="for-sale"]');
    const rentTab = document.querySelector('[data-tab="for-rent"]');
    
    if (saleTab && saleTab.classList.contains('active')) {
        return 'Buy';
    } else if (rentTab && rentTab.classList.contains('active')) {
        return 'Rent';
    }
    
    // Default to 'Buy' if no tab is explicitly active
    return 'Buy';
}

// Function to update property type tabs
function updatePropertyTypeTabs(activePurpose) {
    // Update the URL parameter to reflect the active purpose
    const url = new URL(window.location);
    url.searchParams.set('purpose', activePurpose);
    window.history.replaceState({}, '', url);
    
    // Update all property type tabs via AJAX
    updateTabContent('villas', activePurpose);
    updateTabContent('apartments', activePurpose);
    updateTabContent('houses', activePurpose);
    updateTabContent('condos', activePurpose);
    updateTabContent('retail', activePurpose);
}

// Function to update specific tab content via AJAX
function updateTabContent(tabType, purpose) {
    // Show loading indicator
    let containerId;
    switch(tabType) {
        case 'villas':
            containerId = '#pills-profile';
            break;
        case 'apartments':
            containerId = '#pills-contact';
            break;
        case 'houses':
            containerId = '#pills-contact1';
            break;
        case 'condos':
            containerId = '#pills-contact2';
            break;
        case 'retail':
            containerId = '#pills-contact3';
            break;
    }
    
    if (!containerId) return;
    
    const $container = $(containerId + ' .row');
    if ($container.length) {
        $container.html('<div class="col-12 text-center py-4"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        // Fetch updated content
        $.ajax({
            url: '/api/home/property-type',
            method: 'GET',
            data: {
                type: tabType,
                purpose: purpose
            },
            success: function(response) {
                $container.html(response.html);
            },
            error: function() {
                $container.html('<div class="col-12 text-center py-4"><p class="text-danger">Error loading properties. Please refresh the page.</p></div>');
            }
        });
    }
}

// Function to load featured listings based on purpose
function loadFeaturedListings(purpose) {
    // Show loading indicator
    const propertyGrid = document.querySelector('.property-feature-slider .row');
    if (propertyGrid) {
        propertyGrid.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    }
    
    // Fetch listings from API
    fetch(`/api/home/featured-listings?purpose=${purpose}`)
        .then(response => response.json())
        .then(data => {
            updatePropertyListings(data.listings);
        })
        .catch(error => {
            console.error('Error loading featured listings:', error);
            // Show error message
            const propertyGrid = document.querySelector('.property-feature-slider .row');
            if (propertyGrid) {
                propertyGrid.innerHTML = '<div class="col-12 text-center py-4"><p class="text-danger">Error loading properties. Please try again.</p></div>';
            }
        });
}

// Function to update property listings in the UI
function updatePropertyListings(listings) {
    const propertyGrid = document.querySelector('.property-feature-slider .row');
    if (!propertyGrid) return;
    
    if (listings.length === 0) {
        propertyGrid.innerHTML = '<div class="col-12 text-center py-4"><p>No featured properties available at the moment.</p></div>';
        return;
    }
    
    let html = '';
    listings.forEach(listing => {
        // Format the price
        const formattedPrice = new Intl.NumberFormat('en-GB', {
            style: 'currency',
            currency: 'GBP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(listing.price);
        
        // Get first image
        let firstImage = '{{ asset("assets/img/all-images/properties/property-img2.png") }}';
        if (listing.images && listing.images.length > 0) {
            // Use the first image from the images array
            firstImage = `/storage/${listing.images[0]}`;
        } else if (listing.gallery) {
            try {
                const galleryArray = typeof listing.gallery === 'string' ? JSON.parse(listing.gallery) : listing.gallery;
                if (Array.isArray(galleryArray) && galleryArray.length > 0) {
                    firstImage = `/storage/${galleryArray[0]}`;
                }
            } catch (e) {
                console.error('Error parsing gallery:', e);
            }
        }
        
        // Build property HTML
        html += `
            <div class="col-lg-4 col-md-6">
                <div class="property-boxarea">
                    <div class="img1 image-anime">
                        <img src="\${firstImage}" alt="\${listing.property_title || listing.title}" onerror="this.src='{{ asset('assets/img/all-images/properties/property-img2.png') }}';">
                    </div>
                    <div class="category-list">
                        <ul>
                            <li><a href="/property/${listing.id}">Featured</a></li>
                            <li><a href="/property/${listing.id}">${listing.purpose}</a></li>
                        </ul>
                    </div>
                    <div class="content-area">
                        <a href="/property/${listing.id}">${listing.property_title || listing.title}</a>
                        <div class="space18"></div>
                        <p>\${listing.address || listing.location || listing.city}, \${listing.state || 'UK'}</p>
                        <div class="space24"></div>
                        <ul>
                            <li><a href="#"><img src="{{ asset('assets/img/icons/bed1.svg') }}" alt="housebox">\${listing.bedrooms || 'N/A'}</a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icons/bath1.svg') }}" alt="housebox">\${listing.bathrooms || 'N/A'}</a></li>
                            <li><a href="#"><img src="{{ asset('assets/img/icons/sqare1.svg') }}" alt="housebox">\${listing.area_size || 'N/A'} sq</a></li>
                        </ul>
                        <div class="btn-area">
                            <a href="#" class="nm-btn">\${formattedPrice}</a>
                            <a href="javascript:void(0)" class="heart">
                                <img src="{{ asset('assets/img/icons/heart1.svg') }}" alt="housebox" class="heart1"> 
                                <img src="{{ asset('assets/img/icons/heart2.svg') }}" alt="housebox" class="heart2">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    propertyGrid.innerHTML = html;
}

// Load Google Maps API when DOM is ready
if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
    document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
} else {
    // Google Maps API is already loaded
    initLocationAutocomplete();
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
        });
    });
});
</script>
@endsection