@extends('layouts.master')

@section('title', 'Property Map - PropertyFinda')

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
                            </svg> Map View</a>
                        <div class="space24"></div>
                        <h1>Find Properties on Map</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===== HERO AREA ENDS =======-->

    <!--===== PROPERTIES MAP AREA STARTS =======-->
    <div class="property-inner-section-find sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="property-map-area">
                        <div class="heading1">
                            <h3>Properties ({{ $listings->total() }})</h3>
                        </div>
                        <div class="space32"></div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="sidebar1-area filter-options-form">
                                    <ul class="nav nav-pills" id="pills-tab-sidebar" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link sidebar-purpose-btn {{ request('purpose') != 'Buy' ? 'active' : '' }}"
                                                data-purpose="Rent" type="button">For Rent</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button
                                                class="nav-link sidebar-purpose-btn {{ request('purpose') == 'Buy' ? 'active' : '' }} m-0"
                                                data-purpose="Buy" type="button">For Sale</button>
                                        </li>
                                    </ul>
                                    <div class="space32"></div>
                                    <form id="sidebar-filter-form" action="{{ url('/property-map') }}" method="GET">
                                        <input type="hidden" name="purpose" id="sidebar-purpose"
                                            value="{{ request('purpose', 'Rent') }}">
                                        <input type="hidden" name="bounds" id="bounds-input" value="">
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

                                        <!-- AMENITIES SECTION -->
                                        <div
                                            style="background: white; padding: 20px; border: 2px solid #000; margin: 20px 0;">
                                            <h3
                                                style="color: #000 !important; font-size: 20px !important; margin-bottom: 20px !important; font-family: Arial, sans-serif !important;">
                                                AMENITIES / FEATURES
                                            </h3>

                                            <!-- FEATURES LIST -->
                                            @if(isset($features_all) && $features_all->count() > 0)
                                                <div
                                                    style="background: #d4edda; border: 2px solid #28a745; padding: 15px; margin-bottom: 20px;">
                                                    <p style="margin: 0; color: #000; font-size: 16px; font-weight: bold;">
                                                        ✓ FOUND {{ $features_all->count() }} FEATURES
                                                    </p>
                                                </div>

                                                <div class="row">
                                                    @foreach($features_all as $index => $feature)
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="amenity-item"
                                                                style="padding: 10px; margin-bottom: 8px; border: 1px solid #eee; border-radius: 5px; background-color: #f9f9f9;">
                                                                <label
                                                                    style="display: flex; align-items: center; margin: 0; cursor: pointer; font-family: Arial, sans-serif;">
                                                                    <input type="checkbox" name="feature_ids[]"
                                                                        value="{{ $feature->id }}" {{ in_array($feature->id, (array) request('feature_ids')) ? 'checked' : '' }}
                                                                        style="width: 18px; height: 18px; margin-right: 8px; flex-shrink: 0;">
                                                                    <span
                                                                        style="color: #000 !important; font-size: 14px !important; flex-grow: 1;">
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
                                    @foreach($latest_listings ?? [] as $latest)
                                        <div class="latest-proprty d-flex align-items-center mb-3">
                                            <div class="img1 mr-3" style="width: 80px; flex-shrink: 0;">
                                                <img src="{{ asset('storage/' . $latest->thumbnail) }}"
                                                    alt="{{ $latest->property_title }}"
                                                    style="width: 100%; border-radius: 8px;">
                                            </div>
                                            <div class="content">
                                                <a href="{{ url('/property/' . ($latest->slug ?? $latest->id)) }}"
                                                    class="font-weight-bold d-block mb-1">{{ $latest->property_title }}</a>
                                                <div class="list mb-1">
                                                    <ul class="d-flex p-0 m-0" style="list-style: none; font-size: 12px;">
                                                        @if($latest->bedrooms > 0)
                                                            <li class="mr-2"><img src="{{ asset('assets/img/icons/bed1.svg') }}"
                                                                    width="14" alt=""> x{{ $latest->bedrooms }}</li>

                                                        @if($latest->bathrooms > 0)
                                                            <li class="mr-2"><img src="{{ asset('assets/img/icons/bath1.svg') }}"
                                                                    width="14" alt=""> x{{ $latest->bathrooms }}</li>
                                                        @endif
                                                        <li><img src="{{ asset('assets/img/icons/sqare1.svg') }}" width="14"
                                                                alt=""> {{ $latest->area_size }} sq</li>
                                                    </ul>
                                                </div>
                                                <h5 class="m-0 text-primary">${{ number_format($latest->price) }}</h5>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="map-container" style="position: relative;">
                                    <div id="property-map"
                                        style="height: 700px; width: 100%; border-radius: 10px; border: 1px solid #ddd;">
                                        Loading map...
                                    </div>

                                    <div id="draw-controls"
                                        style="position: absolute; top: 20px; right: 20px; z-index: 1000; display: flex; flex-direction: column; gap: 10px;">
                                        <button id="enable-draw" class="btn btn-primary btn-sm" style="width: auto;">Enable
                                            Draw Tool</button>
                                        <button id="clear-draw" class="btn btn-secondary btn-sm" style="width: auto;">Clear
                                            Drawing</button>
                                    </div>

                                    <!-- Property Prices Popup -->
                                    <div id="property-prices-popup"
                                        style="position: absolute; bottom: 20px; left: 20px; z-index: 1000; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-height: 300px; overflow-y: auto; display: none;">
                                        <h5>Properties in Selected Area</h5>
                                        <div id="prices-list">
                                            <!-- Prices will be populated here -->
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
    <!--===== PROPERTIES MAP AREA ENDS =======-->

    @push('scripts')
        <script
            src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places,drawing"></script>
        <script>
            let map;
            let drawingManager;
            let markers = [];
            let currentBounds = null;

            $(document).ready(function () {
                // Initialize map
                initMap();

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
                        types: ['geocode']
                    });

                    autocomplete.addListener('place_changed', function () {
                        const place = autocomplete.getPlace();
                        if (place.geometry) {
                            $('#sidebar-lat').val(place.geometry.location.lat());
                            $('#sidebar-lng').val(place.geometry.location.lng());
                            console.log('Location selected:', place.formatted_address);
                            console.log('Coordinates:', place.geometry.location.lat(), place.geometry.location.lng());
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

                // Enable drawing functionality
                $('#enable-draw').click(function () {
                    if (!map) {
                        alert('Map not initialized yet');
                        return;
                    }

                    // Disable any existing drawing manager
                    if (drawingManager) {
                        drawingManager.setMap(null);
                    }

                    // Create new drawing manager
                    drawingManager = new google.maps.drawing.DrawingManager({
                        drawingControl: true,
                        drawingControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER,
                            drawingModes: ['rectangle', 'polygon', 'circle']
                        },
                        rectangleOptions: {
                            editable: true,
                            draggable: true
                        },
                        polygonOptions: {
                            editable: true,
                            draggable: true
                        },
                        circleOptions: {
                            editable: true,
                            draggable: true
                        }
                    });

                    drawingManager.setMap(map);

                    // Listen for overlay complete event
                    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
                        const newShape = event.overlay;
                        newShape.type = event.type;

                        // Get bounds of the drawn shape
                        let bounds;
                        if (event.type === google.maps.drawing.OverlayType.RECTANGLE) {
                            bounds = newShape.getBounds();
                        } else if (event.type === google.maps.drawing.OverlayType.CIRCLE) {
                            // For circle, we'll calculate a bounding box
                            const center = newShape.getCenter();
                            const radius = newShape.getRadius();
                            const northEast = new google.maps.LatLng(
                                center.lat() + (radius / 1000) * 0.008983,
                                center.lng() + (radius / 1000) * 0.010024
                            );
                            const southWest = new google.maps.LatLng(
                                center.lat() - (radius / 1000) * 0.008983,
                                center.lng() - (radius / 1000) * 0.010024
                            );
                            bounds = new google.maps.LatLngBounds(southWest, northEast);
                        } else if (event.type === google.maps.drawing.OverlayType.POLYGON) {
                            // For polygon, get the bounds of the polygon
                            bounds = new google.maps.LatLngBounds();
                            newShape.getPath().forEach(function (latlng) {
                                bounds.extend(latlng);
                            });
                        }

                        // Store bounds and trigger search
                        if (bounds) {
                            currentBounds = {
                                north: bounds.getNorthEast().lat(),
                                south: bounds.getSouthWest().lat(),
                                east: bounds.getNorthEast().lng(),
                                west: bounds.getSouthWest().lng()
                            };

                            // Update hidden form field with bounds
                            $('#bounds-input').val(JSON.stringify(currentBounds));

                            // Find properties within the drawn shape
                            const propertiesInShape = checkPropertiesInShape(newShape, [
                                @foreach($listings as $listing)
                                    @if($listing->latitude && $listing->longitude)
                                                                                                    {
                                            id: {{ $listing->id }},
                                            slug: '{{ $listing->slug ?? $listing->id }}',
                                            title: '{{ addslashes($listing->property_title) }}',
                                            price: {{ $listing->price }},
                                            lat: {{ $listing->latitude }},
                                            lng: {{ $listing->longitude }},
                                            address: '{{ addslashes($listing->address) }}',
                                            thumbnail: '{{ asset('storage/' . $listing->thumbnail) }}',
                                            bedrooms: {{ $listing->bedrooms ?? 0 }},
                                            bathrooms: {{ $listing->bathrooms ?? 0 }},
                                            property_type: '{{ optional($listing->propertyType)->title ?? 'Property' }}',
                                            area_size: '{{ $listing->area_size }}',
                                            purpose: '{{ $listing->purpose }}'
                                        },
                                    @endif
                                @endforeach
                                                            ]);

                            // Update the prices list with properties in the drawn area
                            updatePricesList(propertiesInShape);
                        }
                    });
                });

                $('#clear-draw').click(function () {
                    if (drawingManager) {
                        drawingManager.setMap(null);
                        drawingManager = null;
                    }

                    // Hide the prices popup and clear bounds input
                    $('#property-prices-popup').hide();
                    $('#bounds-input').val('');
                    $('#sidebar-filter-form').submit();
                });
            });

            function initMap() {
                if (typeof google === 'undefined' || !google.maps) {
                    console.error('Google Maps API not loaded');
                    return;
                }

                // Clear any existing map
                if (map) {
                    map = null;
                    markers = [];
                }

                // Get the map container
                const mapContainer = document.getElementById('property-map');
                if (!mapContainer) {
                    console.error('Map container not found');
                    return;
                }

                // Initialize the map
                map = new google.maps.Map(mapContainer, {
                    zoom: 10,
                    center: { lat: 51.5074, lng: -0.1278 }, // Default to London
                    mapTypeId: 'roadmap'
                });

                // Add property markers from the listings
                @if(isset($listings) && $listings->count() > 0)
                    @foreach($listings as $listing)
                        @if($listing->latitude && $listing->longitude)
                            addPropertyMarker({
                                id: {{ $listing->id }},
                                slug: '{{ $listing->slug ?? $listing->id }}',
                                title: '{{ addslashes($listing->property_title) }}',
                                price: {{ $listing->price }},
                                lat: {{ $listing->latitude }},
                                lng: {{ $listing->longitude }},
                                address: '{{ addslashes($listing->address) }}',
                                thumbnail: '{{ asset('storage/' . $listing->thumbnail) }}',
                                bedrooms: {{ $listing->bedrooms ?? 0 }},
                                bathrooms: {{ $listing->bathrooms ?? 0 }},
                                property_type: '{{ optional($listing->propertyType)->title ?? 'Property' }}',
                                area_size: '{{ $listing->area_size }}',
                                purpose: '{{ $listing->purpose }}'
                            });
                        @endif
                    @endforeach
                @endif

                    // If we have bounds from the request, fit the map to those bounds
                    @if(request('bounds'))
                        const boundsData = JSON.parse('{!! request('bounds') !!}');
                        if (boundsData && boundsData.north !== undefined) {
                            const bounds = new google.maps.LatLngBounds(
                                new google.maps.LatLng(boundsData.south, boundsData.west),
                                new google.maps.LatLng(boundsData.north, boundsData.east)
                            );
                            map.fitBounds(bounds);
                        }
                    @endif
                                            }

            function addPropertyMarker(property) {
                if (!map) return;

                // Create a marker
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
                    map: map,
                    title: property.title
                });

                // Create an info window with price as content
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                                                        <div style="min-width: 200px;">
                                                            <div style="font-weight: bold; font-size: 16px; color: #007bff;">£${property.price.toLocaleString()}</div>
                                                            <div style="font-weight: bold; margin-top: 5px;">${property.title}</div>
                                                            <div style="color: #666; font-size: 12px; margin-top: 3px;">${property.address}</div>
                                                            <div style="margin-top: 8px; display: flex; gap: 10px;">
                                                                ${property.bedrooms > 0 ? `<span style="font-size: 12px;"><i class="fa fa-bed"></i> ${property.bedrooms} beds</span>` : `<span style="font-size: 12px;"><i class="fa fa-building"></i> ${property.property_type}</span>`}
                                                                ${property.bathrooms > 0 ? `<span style="font-size: 12px;"><i class="fa fa-bath"></i> ${property.bathrooms} baths</span>` : ''}
                                                                <span style="font-size: 12px;"><i class="fa fa-ruler-combined"></i> ${property.area_size} sqft</span>
                                                            </div>
                                                        </div>
                                                    `
                });

                // Add click listener to open property details
                marker.addListener('click', function () {
                    infoWindow.open(map, marker);
                    // Scroll to the property listing
                    const propertyElement = $(`[href="/property/{{ $listing->slug ?? $listing->id ?? '' }}"]`).closest('.property-boxarea');
                    if (propertyElement.length) {
                        $('html, body').animate({
                            scrollTop: propertyElement.offset().top - 100
                        }, 1000);
                    }
                });

                // Store marker reference
                markers.push(marker);
            }

            function updatePricesList(properties) {
                const pricesList = $('#prices-list');
                pricesList.empty();

                if (properties.length === 0) {
                    pricesList.append('<p>No properties found in selected area</p>');
                    return;
                }

                properties.forEach(function (property) {
                    const priceElement = $(`
                                                        <div class="price-item" style="padding: 8px 0; border-bottom: 1px solid #eee;">
                                                            <div style="font-weight: bold; color: #007bff;">£${property.price.toLocaleString()}</div>
                                                            <div style="font-size: 12px; color: #333;">${property.title}</div>
                                                            <div style="font-size: 11px; color: #666;">
                                                                ${property.bedrooms > 0 ? property.bedrooms + ' bed' : property.property_type}
                                                                ${property.bedrooms > 0 && property.bathrooms > 0 ? ', ' : ''}
                                                                ${property.bathrooms > 0 ? property.bathrooms + ' bath' : ''}
                                                            </div>
                                                        </div>
                                                    `);

                    // Add click handler to pan to the property on the map
                    priceElement.click(function () {
                        map.panTo({ lat: parseFloat(property.lat), lng: parseFloat(property.lng) });
                        map.setZoom(15);

                        // Highlight the property marker temporarily
                        markers.forEach(function (m) {
                            if (parseFloat(m.position.lat()) === parseFloat(property.lat) &&
                                parseFloat(m.position.lng()) === parseFloat(property.lng)) {
                                // In a real implementation, we would highlight the marker
                                // For now, we'll just open the info window
                                const tempInfoWindow = new google.maps.InfoWindow({
                                    content: `
                                                                        <div style="min-width: 200px;">
                                                                            <div style="font-weight: bold; font-size: 16px; color: #007bff;">£${property.price.toLocaleString()}</div>
                                                                            <div style="font-weight: bold; margin-top: 5px;">${property.title}</div>
                                                                            <div style="color: #666; font-size: 12px; margin-top: 3px;">${property.address}</div>
                                                                            <div style="margin-top: 8px; display: flex; gap: 10px;">
                                                                                <span style="font-size: 12px;"><i class="fa fa-bed"></i> ${property.bedrooms} beds</span>
                                                                                <span style="font-size: 12px;"><i class="fa fa-bath"></i> ${property.bathrooms} baths</span>
                                                                                <span style="font-size: 12px;"><i class="fa fa-ruler-combined"></i> ${property.area_size} sqft</span>
                                                                            </div>
                                                                        </div>
                                                                    `
                                });
                                tempInfoWindow.open(map, m);
                            }
                        });
                    });

                    pricesList.append(priceElement);
                });

                // Show the popup
                $('#property-prices-popup').show();
            }

            // Function to check which properties are within a drawn shape
            function checkPropertiesInShape(shape, allProperties) {
                const propertiesInShape = [];

                allProperties.forEach(function (property) {
                    const propertyLatLng = new google.maps.LatLng(parseFloat(property.lat), parseFloat(property.lng));

                    if (shape.type === google.maps.drawing.OverlayType.RECTANGLE) {
                        const bounds = shape.getBounds();
                        if (bounds.contains(propertyLatLng)) {
                            propertiesInShape.push(property);
                        }
                    } else if (shape.type === google.maps.drawing.OverlayType.CIRCLE) {
                        const circleCenter = shape.getCenter();
                        const distance = google.maps.geometry.spherical.computeDistanceBetween(circleCenter, propertyLatLng);
                        if (distance <= shape.getRadius()) {
                            propertiesInShape.push(property);
                        }
                    } else if (shape.type === google.maps.drawing.OverlayType.POLYGON) {
                        if (google.maps.geometry.poly.containsLocation(propertyLatLng, shape)) {
                            propertiesInShape.push(property);
                        }
                    }
                });

                return propertiesInShape;
            }
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

            .checkbox-item input[type="checkbox"]:checked+.btn-checkbox {
                background-color: var(--ztc-bg-bg-3) !important;
                border-color: var(--ztc-bg-bg-3) !important;
            }

            .checkbox-item input[type="checkbox"]:checked+.btn-checkbox::after {
                content: '✓' !important;
                color: white !important;
                display: block !important;
                text-align: center !important;
                line-height: 14px !important;
            }
        </style>
    @endpush
@endsection