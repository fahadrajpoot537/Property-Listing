@extends('layouts.modern')

@section('title', 'Map Search | Find properties by drawing')

@section('content')
    <div class="map-search-wrapper">
        <!-- Top Filter Bar -->
        <div class="map-filter-container">
            <div class="container-fluid px-4">
                <div class="filter-row">
                    <!-- Location Input -->
                    <div class="filter-group ml-0 location-group">
                        <div class="search-input-group">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" id="location-input" class="form-control"
                                placeholder="Search location e.g. 'London'">
                        </div>
                    </div>

                    <!-- Type Filters -->
                    <div class="filter-group options-group">
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="purpose" id="p-buy" value="Buy" checked>
                            <label class="btn btn-filter-toggle" for="p-buy">For Sale</label>

                            <input type="radio" class="btn-check" name="purpose" id="p-rent" value="Rent">
                            <label class="btn btn-filter-toggle" for="p-rent">To Rent</label>
                        </div>

                        <select class="form-select filter-select" id="price-filter">
                            <option value="">Min Price</option>
                            <option value="100000">£100,000</option>
                            <option value="200000">£200,000</option>
                            <option value="300000">£300,000</option>
                            <option value="400000">£400,000</option>
                            <option value="500000">£500,000</option>
                        </select>

                        <select class="form-select filter-select" id="beds-filter">
                            <option value="">Bedrooms</option>
                            <option value="1">1+ Beds</option>
                            <option value="2">2+ Beds</option>
                            <option value="3">3+ Beds</option>
                            <option value="4">4+ Beds</option>
                        </select>
                    </div>

                    <!-- Draw Action -->
                    <div class="filter-group ml-auto actions-group">
                        <button type="button" id="draw-btn" class="btn btn-draw shadow-sm">
                            <i class="fa-solid fa-pencil"></i> Draw Search
                        </button>
                        <button type="button" id="clear-draw" class="btn btn-light border d-none p-2 rounded">
                            Clear
                        </button>
                        <a href="{{ route('listings.index') }}" class="btn btn-outline-secondary btn-list-view">
                            <i class="fa-solid fa-list"></i> List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="map-canvas-container">
            <div id="map-canvas"></div>

            <!-- Start Message -->
            <div id="map-start-message" class="map-message-overlay">
                <div class="message-card">
                    <div class="icon-circle mb-3">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h3>Start your search</h3>
                    <p class="mb-4">Enter a location above or use the <strong>Draw Search</strong> tool to find properties.
                    </p>
                    <button type="button" class="btn btn-primary btn-lg w-100" onclick="enableDrawingMode()">
                        <i class="fa-solid fa-pencil"></i> Start Drawing
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="map-loading" class="map-loading-pill d-none">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span>Updating map...</span>
            </div>

            <!-- Draw Helper Toast -->
            <div id="draw-toast" class="draw-helper-toast d-none">
                <div class="toast-content">
                    <div class="icon-box">
                        <i class="fa-solid fa-pencil"></i>
                    </div>
                    <div>
                        <strong>Draw a shape</strong>
                        <div class="small text-muted">Click points on map to outline area</div>
                    </div>
                    <button type="button" class="btn-close ms-auto" id="close-toast-btn"></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Global Overrides */
        body {
            overflow: hidden;
        }

        .hero-inner-section-area-sidebar,
        footer {
            display: none !important;
        }

        .map-search-wrapper {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 80px);
            position: relative;
            background: #f4f5f7;
        }

        /* Filter Bar */
        .map-filter-container {
            position: relative;
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 18px 0;
            z-index: 50;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .filter-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ml-auto {
            margin-left: auto;
        }

        /* Inputs */
        .search-input-group {
            position: relative;
            width: 320px;
        }

        .search-input-group input {
            padding-left: 40px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            height: 44px;
            font-size: 15px;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .search-input-group input:focus {
            background: #fff;
            border-color: #008da6;
            box-shadow: 0 0 0 3px rgba(0, 141, 166, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 16px;
        }

        .btn-filter-toggle {
            padding: 8px 18px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            background: white;
            color: #475569;
            height: 44px;
            display: inline-flex;
            align-items: center;
        }

        .btn-check:checked+.btn-filter-toggle {
            background-color: #0f172a;
            /* Slate 900 */
            color: white;
            border-color: #0f172a;
        }

        .filter-select {
            height: 44px;
            font-size: 14px;
            min-width: 120px;
            border-color: #e2e8f0;
            cursor: pointer;
            border-radius: 6px;
            color: #475569;
        }

        /* Buttons */
        .btn-draw {
            border: 1px solid #008da6;
            color: #008da6;
            background: white;
            font-weight: 600;
            font-size: 14px;
            height: 44px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 20px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-draw:hover,
        .btn-draw.active {
            background: #008da6;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 141, 166, 0.2);
        }

        .btn-list-view {
            height: 44px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            padding: 0 16px;
            border-radius: 6px;
        }

        /* Map */
        .map-canvas-container {
            flex: 1;
            position: relative;
            background: #e5e3df;
            /* Google Maps bg color */
        }

        #map-canvas {
            width: 100%;
            height: 100%;
        }

        /* Overlays */
        .map-message-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            backdrop-filter: blur(5px);
        }

        .message-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 420px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            pointer-events: auto;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: #f0f9ff;
            color: #008da6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto;
        }

        .message-card h3 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .message-card p {
            color: #64748b;
            font-size: 15px;
        }

        /* Loading Pill */
        .map-loading-pill {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.9);
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
            color: white;
            z-index: 1000;
            pointer-events: none;
            backdrop-filter: blur(4px);
        }

        .map-loading-pill .spinner-border {
            width: 1rem;
            height: 1rem;
            border-width: 2px;
            border-color: white;
            border-right-color: transparent;
        }

        /* Draw Helper */
        .draw-helper-toast {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            z-index: 2000;
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            min-width: 300px;
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-box {
            width: 36px;
            height: 36px;
            background: #e0f2fe;
            color: #008da6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        @keyframes slideUp {
            from {
                transform: translate(-50%, 100%);
                opacity: 0;
            }

            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        /* Custom Markers (Speech Bubble Style) */
        .price-marker-label {
            background: #0f172a;
            /* Slate 900 */
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            position: absolute;
            transform: translate(-50%, -100%);
            /* Center bottom anchor */
            white-space: nowrap;
            font-family: 'Inter', sans-serif;
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: -10px;
            /* Lift up slightly */
        }

        /* Tail */
        .price-marker-label::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid #0f172a;
        }

        .price-marker-label:hover {
            background: #008da6;
            transform: translate(-50%, -115%) scale(1.1);
            /* Pop up effect */
            z-index: 9999 !important;
        }

        .price-marker-label:hover::after {
            border-top-color: #008da6;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .filter-row {
                gap: 10px;
            }

            .search-input-group {
                width: 100%;
                max-width: 240px;
            }

            .filter-select {
                flex: 1;
                min-width: 0;
            }

            .btn-draw {
                padding: 0 10px;
                font-size: 13px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let map;
        let drawingManager;
        let activePolygon = null;
        let markers = [];
        let isDrawingMode = false;
        let debounceTimer;

        // Helper to safely manipulate elements with brute-force inline styles
        function toggleEl(id, show) {
            const el = document.getElementById(id);
            if (!el) return;
            if (show) {
                el.classList.remove('d-none');
                el.style.display = '';
            } else {
                el.classList.add('d-none');
                el.style.display = 'none'; // Force hide to prevent CSS conflicts
            }
        }

        // Wait for Google Maps
        document.addEventListener('DOMContentLoaded', function () {
            const check = setInterval(function () {
                if (typeof google !== 'undefined' && google.maps && google.maps.drawing) {
                    clearInterval(check);
                    initPropertyMap();
                }
            }, 200);
        });

        function initPropertyMap() {
            console.log("Initializing Map...");
            const london = { lat: 51.5074, lng: -0.1278 };

            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: london,
                zoom: 11,
                mapTypeId: 'roadmap',
                disableDefaultUI: true, // Clean look
                zoomControl: true,
                zoomControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
                gestureHandling: 'greedy', // Better for full screen
                minZoom: 5,
                maxZoom: 20,
                styles: [
                    {
                        "featureType": "poi",
                        "elementType": "labels",
                        "stylers": [{ "visibility": "off" }]
                    }
                ]
            });

            // Setup Drawing Manager
            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: null,
                drawingControl: false,
                polygonOptions: {
                    fillColor: '#008da6',
                    fillOpacity: 0.15,
                    strokeWeight: 2,
                    strokeColor: '#008da6',
                    clickable: false,
                    editable: false,
                    zIndex: 1
                }
            });
            drawingManager.setMap(map);

            // Drawing Complete Listener
            google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
                if (event.type === 'polygon') {
                    if (activePolygon) activePolygon.setMap(null);
                    activePolygon = event.overlay;

                    disableDrawingMode();
                    toggleEl('clear-draw', true);
                    toggleEl('map-start-message', false); // Hide start message

                    searchInPolygon(activePolygon);
                }
            });

            // Setup Autocomplete
            const input = document.getElementById('location-input');
            if (input) {
                const autocomplete = new google.maps.places.Autocomplete(input, {
                    componentRestrictions: { country: 'uk' }
                });
                autocomplete.bindTo('bounds', map);
                autocomplete.addListener('place_changed', function () {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    toggleEl('map-start-message', false); // Hide start message on search

                    // Clear any drawn polygon on text search
                    if (activePolygon) {
                        activePolygon.setMap(null);
                        activePolygon = null;
                        toggleEl('clear-draw', false);
                    }

                    if (place.geometry.viewport) map.fitBounds(place.geometry.viewport);
                    else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(14);
                    }
                    searchInViewport();
                });
            }

            // Listener for idle (drag end, zoom end) -> Search in Viewport
            map.addListener('idle', function () {
                // Only trigger if start message is HIDDEN (active session)
                const msg = document.getElementById('map-start-message');
                // Check computed style to be sure
                const isHidden = msg && (msg.classList.contains('d-none') || msg.style.display === 'none');

                if (!isHidden) return;

                // And NOT in drawing mode, and NO active polygon (viewport search)
                if (!isDrawingMode && !activePolygon) {
                    searchInViewport();
                }
            });

            // NO initial search.
        }

        // --- Drawing UI ---

        window.enableDrawingMode = function () {
            console.log("Enabling Drawing Mode");
            if (!map) { alert('Map not loaded yet.'); return; }

            isDrawingMode = true;
            const btn = document.getElementById('draw-btn');
            if (btn) {
                btn.classList.add('active');
                btn.innerHTML = '<i class="fa-solid fa-xmark"></i> Cancel';
            }

            toggleEl('draw-toast', true);
            toggleEl('map-start-message', false); // HIDE MESSAGE SO MAP IS CLICKABLE

            // Lock Map Movement
            map.setOptions({
                draggable: false,
                clickableIcons: false,
                disableDoubleClickZoom: true,
            });
            map.getDiv().style.cursor = 'crosshair';

            // Start Tool
            drawingManager.setDrawingMode('polygon');
        };

        window.disableDrawingMode = function () {
            console.log("Disabling Drawing Mode");
            if (!map) return;

            isDrawingMode = false;
            const btn = document.getElementById('draw-btn');
            if (btn) {
                btn.classList.remove('active');
                btn.innerHTML = '<i class="fa-solid fa-pencil"></i> Draw Search';
            }

            toggleEl('draw-toast', false);

            // Show start message again if nothing was done
            if (!activePolygon && markers.length === 0) {
                toggleEl('map-start-message', true);
            }

            // Unlock Map
            map.setOptions({
                draggable: true,
                clickableIcons: true,
                disableDoubleClickZoom: false,
            });
            map.getDiv().style.cursor = '';

            // Stop Tool
            drawingManager.setDrawingMode(null);
        };

        const drawBtn = document.getElementById('draw-btn');
        if (drawBtn) {
            drawBtn.addEventListener('click', function () {
                if (isDrawingMode) disableDrawingMode();
                else enableDrawingMode();
            });
        }

        const closeToast = document.getElementById('close-toast-btn');
        if (closeToast) {
            closeToast.addEventListener('click', function () {
                disableDrawingMode();
            });
        }

        const clearBtn = document.getElementById('clear-draw');
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                if (activePolygon) {
                    activePolygon.setMap(null);
                    activePolygon = null;
                }
                this.classList.add('d-none');
                this.style.display = 'none';

                // Clear markers and show start message
                clearMarkers();
                toggleEl('map-start-message', true);
            });
        }

        // --- Search Logic ---

        function getPayload() {
            // Safe get value
            const getVal = (id) => { const el = document.getElementById(id); return el ? el.value : ''; };
            const purposeEl = document.querySelector('input[name="purpose"]:checked');

            return {
                purpose: purposeEl ? purposeEl.value : 'Buy',
                min_price: getVal('price-filter'),
                bedrooms: getVal('beds-filter'),
                property_type: null,
                _token: '{{ csrf_token() }}'
            };
        }

        function searchInPolygon(polygon) {
            if (debounceTimer) clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const bounds = new google.maps.LatLngBounds();
                polygon.getPath().forEach(p => bounds.extend(p));

                const payload = getPayload();
                // Match Backend keys: southwest/northeast
                const ne = bounds.getNorthEast();
                const sw = bounds.getSouthWest();
                payload.bounds = {
                    northeast: { lat: ne.lat(), lng: ne.lng() },
                    southwest: { lat: sw.lat(), lng: sw.lng() }
                };

                fetchProperties(payload, true, polygon);
            }, 200);
        }

        function searchInViewport() {
            if (!map) return;
            if (debounceTimer) clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const bounds = map.getBounds();
                if (!bounds) return;

                const payload = getPayload();
                const ne = bounds.getNorthEast();
                const sw = bounds.getSouthWest();
                payload.bounds = {
                    northeast: { lat: ne.lat(), lng: ne.lng() },
                    southwest: { lat: sw.lat(), lng: sw.lng() }
                };

                fetchProperties(payload, false);
            }, 500);
        }

        // Filter Listeners
        document.querySelectorAll('.filter-select, input[name="purpose"]').forEach(el => {
            el.addEventListener('change', () => {
                // Only update if search isn't waiting at start
                const msg = document.getElementById('map-start-message');
                // Check computed style to be sure (handling inline styles)
                const isHidden = msg && (msg.classList.contains('d-none') || msg.style.display === 'none');

                if (isHidden) {
                    if (activePolygon) searchInPolygon(activePolygon);
                    else searchInViewport();
                }
            });
        });

        // API Call
        function fetchProperties(payload, isPolygon, polygonObj = null) {
            toggleEl('map-loading', true);

            fetch("{{ route('map.getProperties') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": '{{ csrf_token() }}' },
                body: JSON.stringify(payload)
            })
                .then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    clearMarkers();
                    let properties = data.properties || [];

                    // Client-side polygon filter
                    if (isPolygon && polygonObj) {
                        properties = properties.filter(prop => {
                            const latLng = new google.maps.LatLng(prop.lat, prop.lng);
                            return google.maps.geometry.poly.containsLocation(latLng, polygonObj);
                        });
                    }

                    properties.forEach(createMarker);
                })
                .catch(err => console.error("Search Error:", err))
                .finally(() => {
                    toggleEl('map-loading', false);
                });
        }

        // --- Markers ---

        // Using CustomOverlay
        class PriceMarker extends google.maps.OverlayView {
            constructor(position, property) {
                super();
                this.position = position;
                this.property = property;
                this.div = null;
                this.setMap(map);
            }

            onAdd() {
                this.div = document.createElement('div');
                this.div.className = 'price-marker-label';
                this.div.innerHTML = '£' + formatPrice(this.property.price);

                this.div.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // Stop map click
                    window.open('/property/' + this.property.id, '_blank');
                });

                const panes = this.getPanes();
                panes.overlayMouseTarget.appendChild(this.div);
            }

            draw() {
                const overlayProjection = this.getProjection();
                const point = overlayProjection.fromLatLngToDivPixel(this.position);
                if (this.div) {
                    this.div.style.left = point.x + 'px';
                    this.div.style.top = point.y + 'px';
                }
            }

            onRemove() {
                if (this.div) {
                    this.div.parentNode.removeChild(this.div);
                    this.div = null;
                }
            }
        }

        function createMarker(prop) {
            const latLng = { lat: Number(prop.lat), lng: Number(prop.lng) };
            const m = new PriceMarker(latLng, prop);
            markers.push(m);
        }

        function clearMarkers() {
            markers.forEach(m => m.setMap(null));
            markers = [];
        }

        function formatPrice(price) {
            if (price >= 1000000) return (price / 1000000).toFixed(1) + 'm';
            if (price >= 1000) return Math.round(price / 1000) + 'k';
            return price;
        }

    </script>
@endpush