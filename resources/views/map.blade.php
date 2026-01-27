@extends('layouts.master')

@section('title', 'Interactive Property Map')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="row g-0">
        <!-- Sidebar for filters -->
        <div class="col-lg-3 col-md-4 col-sm-12 p-3 bg-white border-end" style="height: 100vh; overflow-y: auto; margin-top: 5%;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold">Filters</h5>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggle-sidebar">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            
            <form id="filter-form" class="mb-4">
                <div class="mb-3">
                    <label class="form-label small text-muted">Price Range (£)</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" class="form-control form-control-sm" id="price-min" placeholder="Min">
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control form-control-sm" id="price-max" placeholder="Max">
                        </div>
                    </div>
                </div>
                            
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small text-muted">Property Type</label>
                        <select class="form-control form-control-sm" id="property-type">
                            
                            <option value="">All Types</option>
                            @foreach($propertyTypes ?? [] as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                                
                    <div class="col-6">
                        <label class="form-label small text-muted">Bedrooms</label>
                        <select class="form-control form-control-sm" id="bedrooms">
                            <option value="">Any</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                        </select>
                    </div>
                </div>
                            
                <div class="mb-3">
                    <label class="form-label small text-muted">Purpose</label>
                    <select class="form-control form-control-sm" id="purpose">
                        <option value="">All</option>
                        <option value="sale">For Sale</option>
                        <option value="rent">For Rent</option>
                    </select>
                </div>
                            
                <div class="d-grid gap-2 mb-3">
                    <button type="button" class="btn btn-primary btn-sm py-2" id="search-btn">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                                
                    <button type="button" class="btn btn-outline-success btn-sm py-2" id="enable-draw">
                        <i class="fas fa-draw-polygon me-1"></i> Draw Area
                    </button>
                                
                    <div class="btn-group d-grid gap-2" role="group">
                        <button type="button" class="btn btn-outline-info btn-sm" id="draw-polygon" style="display:none;">
                            <i class="fas fa-shapes me-1"></i> Polygon
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" id="draw-rectangle" style="display:none;">
                            <i class="fas fa-vector-square me-1"></i> Rectangle
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" id="draw-circle" style="display:none;">
                            <i class="fas fa-circle me-1"></i> Circle
                        </button>
                    </div>
                                
                    <button type="button" class="btn btn-outline-secondary btn-sm py-2" id="clear-draw">
                        <i class="fas fa-eraser me-1"></i> Clear
                    </button>
                </div>
            </form>
            
            <div class="border-top pt-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-home me-2 text-success"></i>Properties</h6>
                    <span class="badge bg-primary rounded-pill px-3 py-2" id="property-count">0</span>
                </div>
                <div id="property-list" class="rounded-2 p-2" style="max-height: calc(100vh - 400px); overflow-y: auto; background-color: #f8f9fa;">
                    <div class="text-center py-4">
                        <i class="fas fa-hand-pointer text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0 small">Draw an area to see properties</p>
                    </div>
                </div>
                
                <!-- Property Detail Modal -->
                <div class="modal fade" id="propertyModal" tabindex="-1" aria-labelledby="propertyModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="propertyModalLabel">Property Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="propertyModalBody">
                                <div class="text-center py-4">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="#" class="btn btn-primary" id="viewDetailsBtn" target="_blank">View Full Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map container -->
        <div class="col-lg-9 col-md-8 col-sm-12">
            <div id="map" style="height: 100vh; width: 100%; background-color: #ffffff;">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-center">
                        <i class="fas fa-map-marked-alt text-muted" style="font-size: 3rem;"></i>
                        <p class="mt-3 text-muted">Draw an area to see {{ $listingType ?? 'regular' }} properties</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden input for bounds -->
<input type="hidden" id="bounds-input" value="">
@endsection

@push('scripts')
<script>
    // Global variables
    let map;
    let markers = [];
    let drawingManager;
    let currentBounds = null;
    let propertyClusterer;
    let debounceTimer = null;

    // Initialize the map
    function initMap() {
        console.log('Initializing map...');
            
        // Check if google.maps is available
        if (typeof google === 'undefined' || !google.maps) {
            console.error('Google Maps not loaded properly');
            return;
        }
            
        // Set default location to London, UK
        const defaultLocation = { lat: 51.5074, lng: -0.1278 };
    
        // Create the map with white background and administrative boundaries
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultLocation,
            zoom: 10,
            mapTypeId: 'roadmap',
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            streetViewControl: false,
            fullscreenControl: false,
            mapTypeControl: false,
            styles: [
                {
                    "featureType": "administrative",
                    "elementType": "labels",
                    "stylers": [{"visibility": "on"}]
                },
                {
                    "featureType": "administrative.locality",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#1a1a1a"}]
                },
                {
                    "featureType": "administrative.neighborhood",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#333333"}]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [{"color": "#f5f5f5"}]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [{"color": "#eeeeee"}]
                },
                {
                    "featureType": "road",
                    "elementType": "geometry",
                    "stylers": [{"color": "#ffffff"}]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [{"color": "#dadada"}]
                },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{"color": "#c9c9c9"}]
                }
            ]
        });
    
        console.log('Map created successfully');
            
        // Don't load properties by default - wait for drawing
        console.log('Map initialized. Properties will load after drawing.');
        
        // Show area names by enabling administrative boundaries
        // Remove problematic GeoJSON loading that causes CORS errors
    
        // Only load properties when drawing is completed
        // Idle event listener removed to prevent automatic loading
    }

    // Load properties based on current map bounds
    function loadProperties() {
        const bounds = map.getBounds();
        if (!bounds) return;

        // Format bounds for API request
        const boundsData = {
            southwest: {
                lat: bounds.getSouthWest().lat(),
                lng: bounds.getSouthWest().lng()
            },
            northeast: {
                lat: bounds.getNorthEast().lat(),
                lng: bounds.getNorthEast().lng()
            }
        };

        // Get current filters
        const filters = {
            price_min: document.getElementById('price-min').value || null,
            price_max: document.getElementById('price-max').value || null,
            property_type: document.getElementById('property-type').value || null,
            bedrooms: document.getElementById('bedrooms').value || null,
            purpose: document.getElementById('purpose').value || null
        };

        // Determine listing type based on current URL
        const isOffMarket = window.location.pathname.includes('off-market');
        
        // Make API request
        fetch('/map/api/properties', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                bounds: boundsData,
                zoom_level: map.getZoom(),
                listing_type: isOffMarket ? 'off_market' : 'regular',
                ...filters
            })
        })
        .then(response => response.json())
        .then(data => {
            updateMapWithProperties(data.properties);
            updatePropertyCount(data.total);
            updatePropertyList(data.properties);
        })
        .catch(error => {
            console.error('Error loading properties:', error);
        });
    }

    // Update map with properties
    function updateMapWithProperties(properties) {
        // Clear existing markers
        clearMarkers();

        // Create new markers
        properties.forEach(property => {
            addPropertyMarker(property);
        });
    }

    // Add a property marker to the map
    function addPropertyMarker(property) {
        if (!map) return;

        // Create an invisible marker at the property location
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 0, // Make it invisible
                fillColor: "transparent",
                fillOpacity: 0,
                strokeColor: "transparent",
                strokeWeight: 0
            },
            optimized: false
        });
        
        // Create an info window that displays the price in a centered dialog box
        const priceInfoWindow = new google.maps.InfoWindow({
            content: `<div style="background-color: #007bff; color: white; padding: 6px 12px; border-radius: 16px; font-weight: bold; font-size: 14px; text-align: center; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3); min-width: 80px; display: flex; align-items: center; justify-content: center; height: 30px;">£${property.price.toLocaleString()}</div>`,
            disableAutoPan: true,
            pixelOffset: new google.maps.Size(0, -35) // Position above the marker
        });
        
        // Show the price info window immediately
        setTimeout(() => {
            priceInfoWindow.open(map, marker);
        }, 100);
        


        // Create an info window with property details
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="min-width: 250px;">
                    <div style="font-weight: bold; font-size: 16px; color: #007bff;">£${property.price.toLocaleString()}</div>
                    <div style="font-weight: bold; margin-top: 5px;">${property.title}</div>
                    <div style="color: #666; font-size: 12px; margin-top: 3px;">${property.address}</div>
                    ${property.image ? `<img src="${property.image.startsWith('http') || property.image.startsWith('/') ? property.image : '/storage/gallery/' + property.image}" style="width: 100%; height: 120px; object-fit: cover; margin: 5px 0; border-radius: 4px;" />` : ''}
                    <div style="margin-top: 8px; display: flex; gap: 10px;">
                        <span style="font-size: 12px;"><i class="fa fa-bed"></i> ${property.bedrooms || 0} beds</span>
                        <span style="font-size: 12px;"><i class="fa fa-bath"></i> ${property.bathrooms || 0} baths</span>
                        <span style="font-size: 12px;"><i class="fa fa-ruler-combined"></i> ${property.area_size || 0} sqft</span>
                    </div>
                    <div style="margin-top: 8px;">
                        <a href="/property/${property.id}" class="btn btn-sm btn-primary" style="text-decoration: none; color: white; padding: 4px 8px; font-size: 12px;">View Details</a>
                    </div>
                </div>
            `
        });

        // Add click listener to open property details
        marker.addListener('click', function() {
            // Close the price info window and open the property modal
            priceInfoWindow.close();
            openPropertyModal(property.id);
        });

        // Store marker reference
        markers.push(marker);
    }

    // Clear all markers from the map
    function clearMarkers() {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }

    // Update property count display
    function updatePropertyCount(count) {
        document.getElementById('property-count').textContent = count;
    }

    // Update property list in sidebar
    function updatePropertyList(properties) {
        const propertyList = document.getElementById('property-list');
        propertyList.innerHTML = '';

        if (properties.length === 0) {
            propertyList.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-home text-muted mb-2" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0 small">No properties found in this area</p>
                </div>`;
            return;
        }

        properties.forEach(property => {
            const propertyElement = document.createElement('div');            
            propertyElement.className = 'border rounded p-3 mb-2 bg-light';
            propertyElement.style.cursor = 'pointer';
            propertyElement.style.transition = 'transform 0.2s';
            
            propertyElement.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div style="font-weight: bold; color: #007bff; font-size: 1.1em;">£${property.price.toLocaleString()}</div>
                        <div style="font-size: 14px; font-weight: 500; margin: 5px 0;">${property.title}</div>
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <small class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-bed"></i> ${property.bedrooms || 0} bed
                            </small>
                            <small class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-bath"></i> ${property.bathrooms || 0} bath
                            </small>
                            <small class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-ruler-combined"></i> ${property.area_size || 0} sqft
                            </small>
                        </div>
                        <small class="text-muted">${property.address}</small>
                    </div>
                    <div>
                        <i class="fas fa-arrow-right text-muted"></i>
                    </div>
                </div>
            `;
            
            propertyElement.addEventListener('click', function() {
                // Pan to property location
                map.panTo({ lat: parseFloat(property.lat), lng: parseFloat(property.lng) });
                map.setZoom(15);
                
                // Open modal with property details
                openPropertyModal(property.id);
            });
            
            propertyList.appendChild(propertyElement);
        });
    }

    // Enable drawing functionality
    function enableDrawing() {
        console.log('enableDrawing function called');
        
        if (!map) {
            alert('Map not initialized yet');
            return;
        }

        // Disable any existing drawing manager
        if (drawingManager) {
            drawingManager.setMap(null);
        }
        
        console.log('Creating new drawing manager');

        // Create new drawing manager
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: null, // Start with no active drawing mode
            drawingControl: false, // Disable the default drawing controls
            polygonOptions: {
                fillColor: '#0000ff',
                fillOpacity: 0.0,  // No fill (transparent)
                strokeWeight: 2,
                strokeColor: '#0000ff',  // Blue outline only
                clickable: false,
                editable: true,
                draggable: true
            },
            rectangleOptions: {
                fillColor: '#0000ff',
                fillOpacity: 0.0,  // No fill (transparent)
                strokeWeight: 2,
                strokeColor: '#0000ff',  // Blue outline only
                clickable: false,
                editable: true,
                draggable: true
            },
            circleOptions: {
                fillColor: '#0000ff',
                fillOpacity: 0.0,  // No fill (transparent)
                strokeWeight: 2,
                strokeColor: '#0000ff',  // Blue outline only
                clickable: false,
                editable: true,
                draggable: true
            },
        });

        drawingManager.setMap(map);
        
        console.log('Drawing manager set to map');
        console.log('Available drawing modes:', drawingManager.drawingControlOptions?.drawingModes);

        // Listen for overlay complete event
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
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
                newShape.getPath().forEach(function(latlng) {
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
                document.getElementById('bounds-input').value = JSON.stringify(currentBounds);

                // Fetch properties within drawn area
                fetchPropertiesByBounds(currentBounds);
            }
        });
    }

    // Fetch properties within specific bounds
    function fetchPropertiesByBounds(bounds) {
        // Get current filters
        const filters = {
            price_min: document.getElementById('price-min').value || null,
            price_max: document.getElementById('price-max').value || null,
            property_type: document.getElementById('property-type').value || null,
            bedrooms: document.getElementById('bedrooms').value || null,
            purpose: document.getElementById('purpose').value || null
        };

        // Determine listing type based on current URL
        const isOffMarket = window.location.pathname.includes('off-market');
        
        // Make API request
        fetch('/map/api/properties', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                bounds: {
                    southwest: { lat: bounds.south, lng: bounds.west },
                    northeast: { lat: bounds.north, lng: bounds.east }
                },
                zoom_level: map.getZoom(),
                listing_type: isOffMarket ? 'off_market' : 'regular',
                ...filters
            })
        })
        .then(response => response.json())
        .then(data => {
            updateMapWithProperties(data.properties);
            updatePropertyCount(data.total);
            updatePropertyList(data.properties);
        })
        .catch(error => {
            console.error('Error loading properties:', error);
        });
    }

    // Clear drawings and reset
    function clearDrawings() {
        if (drawingManager) {
            drawingManager.setMap(null);
            drawingManager = null;
        }

        // Reset drawing buttons
        document.getElementById('draw-polygon').style.display = 'none';
        document.getElementById('draw-rectangle').style.display = 'none';
        document.getElementById('draw-circle').style.display = 'none';
        document.getElementById('enable-draw').style.display = 'inline-block';

        // Clear bounds input and reset map
        document.getElementById('bounds-input').value = '';
        
        // Clear markers
        clearMarkers();
        
        // Reset property count
        updatePropertyCount(0);
        
        // Reset property list
        document.getElementById('property-list').innerHTML = `
            <div class="text-center py-4">
                <i class="fas fa-hand-pointer text-muted mb-2" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0 small">Draw an area to see properties</p>
            </div>
        `;
        
        // Close any open modal
        const modalElement = document.getElementById('propertyModal');
        if (modalElement) {
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
        
        // Trigger full page reload
        setTimeout(() => {
            window.location.reload();
        }, 300); // Small delay to allow UI updates before reload
    }

    // Event listeners for UI elements
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        initMap();

        // Search button event - only works after drawing
        document.getElementById('search-btn').addEventListener('click', function(e) {
            e.preventDefault();
            const boundsInput = document.getElementById('bounds-input').value;
            if (boundsInput) {
                const bounds = JSON.parse(boundsInput);
                fetchPropertiesByBounds(bounds);
            } else {
                alert('Please draw an area first');
            }
        });

        // Enable draw button event
        document.getElementById('enable-draw').addEventListener('click', function() {
            console.log('Draw button clicked');
            enableDrawing();
            
            // Show individual drawing buttons
            document.getElementById('draw-polygon').style.display = 'inline-block';
            document.getElementById('draw-rectangle').style.display = 'inline-block';
            document.getElementById('draw-circle').style.display = 'inline-block';
            this.style.display = 'none';
        });
        
        // Individual drawing mode buttons
        document.getElementById('draw-polygon').addEventListener('click', function() {
            console.log('Polygon button clicked');
            if (drawingManager) {
                drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
            }
        });
        
        document.getElementById('draw-rectangle').addEventListener('click', function() {
            console.log('Rectangle button clicked');
            if (drawingManager) {
                drawingManager.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);
            }
        });
        
        document.getElementById('draw-circle').addEventListener('click', function() {
            console.log('Circle button clicked');
            if (drawingManager) {
                drawingManager.setDrawingMode(google.maps.drawing.OverlayType.CIRCLE);
            }
        });

        // Clear draw button event
        document.getElementById('clear-draw').addEventListener('click', function(e) {
            e.preventDefault();
            clearDrawings();
        });

        // Toggle sidebar event
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('.col-lg-3');
            if (sidebar.style.display === 'none' || sidebar.style.display === '') {
                sidebar.style.display = 'block';
                this.innerHTML = '<i class="fas fa-chevron-left"></i>';
            } else {
                sidebar.style.display = 'none';
                this.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
        });

        // Filter change events - only work after drawing
        document.querySelectorAll('#filter-form input, #filter-form select').forEach(element => {
            element.addEventListener('change', function() {
                const boundsInput = document.getElementById('bounds-input').value;
                if (boundsInput) {
                    const bounds = JSON.parse(boundsInput);
                    fetchPropertiesByBounds(bounds);
                }
            });
        });
    });
</script>

<!-- Load Google Maps API with Drawing Library -->
<script>
    let mapScriptLoaded = false;
    
    function initializeMapAfterAPI() {
        if (typeof google !== 'undefined' && google.maps && google.maps.drawing) {
            initMap();
        } else {
            setTimeout(initializeMapAfterAPI, 100);
        }
    }
    
    function loadGoogleMapsAPI() {
        if (mapScriptLoaded) return;
        
        console.log('Loading Google Maps API...');
        
        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=geometry,drawing&callback=googleMapsInitialized';
        script.async = true;
        script.defer = true;
        script.onerror = function() {
            console.error('Failed to load Google Maps API');
        };
        document.head.appendChild(script);
        mapScriptLoaded = true;
    }
    
    function googleMapsInitialized() {
        console.log('Google Maps API initialized');
        // Google Maps API is loaded, now initialize the map
        initializeMapAfterAPI();
    }
    
    // Load the API after DOM is ready
    document.addEventListener('DOMContentLoaded', loadGoogleMapsAPI);
    
    // Open property detail modal
    function openPropertyModal(propertyId) {
        const modal = new bootstrap.Modal(document.getElementById('propertyModal'));
        const modalBody = document.getElementById('propertyModalBody');
        const viewDetailsBtn = document.getElementById('viewDetailsBtn');
        
        // Show loading state
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`;
        
        // Determine listing type based on current URL and set appropriate link
        const isOffMarket = window.location.pathname.includes('off-market');
        viewDetailsBtn.href = isOffMarket ? `/off-market-property/` + propertyId : `/property/` + propertyId;
        
        // Determine API endpoint based on current URL
        const apiEndpoint = isOffMarket ? `/api/off-market-listings/` : `/api/listings/`;
        
        // Fetch property details
        fetch(apiEndpoint + propertyId)
            .then(response => response.json())
            .then(property => {
                let images = [];
                if (property.gallery) {
                    try {
                        // Check if gallery is already an array or a JSON string
                        if (Array.isArray(property.gallery)) {
                            images = property.gallery;
                        } else if (typeof property.gallery === 'string') {
                            images = JSON.parse(property.gallery);
                        } else {
                            images = [];
                        }
                    } catch (e) {
                        console.error('Error parsing gallery:', e);
                        images = [];
                    }
                }
                const firstImage = images.length > 0 ? images[0] : '/assets/images/no-image.jpg';
                
                modalBody.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <img src="${firstImage}" class="img-fluid rounded" alt="Property Image" style="height: 250px; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-3">£${parseFloat(property.price).toLocaleString()}</h4>
                            <h5>${property.property_title}</h5>
                            <p class="text-muted mb-3">${property.address}</p>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Type:</strong> ${property.property_type_name || 'N/A'}
                                </div>
                                <div class="col-6">
                                    <strong>Bedrooms:</strong> ${property.bedrooms || 'N/A'}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <strong>Bathrooms:</strong> ${property.bathrooms || 'N/A'}
                                </div>
                                <div class="col-6">
                                    <strong>Area:</strong> ${property.area_size || 'N/A'} sqft
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Purpose:</strong> ${property.purpose || 'N/A'}
                            </div>
                            
                            <div class="mb-3">
                                <strong>Description:</strong>
                                <p>${property.description || 'No description available.'}</p>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error loading property details:', error);
                modalBody.innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        Error loading property details. Please try again.
                    </div>`;
            });
        
        modal.show();
    }
</script>
@endpush