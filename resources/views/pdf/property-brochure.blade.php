<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #1a202c;
            font-size: 11px;
            line-height: 1.5;
            background: #f8f9fa;
        }

        .text-dark {
            color: #000000 !important;
        }

        /* COVER PAGE - Ultra Modern */
        .cover {
            position: relative;
            background: #131B31;
            color: white;
            padding: 0;
            height: 1050px;
            overflow: hidden;
        }

        .cover-gradient {
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: linear-gradient(135deg, transparent 0%, #8046F1 100%);
            opacity: 0.3;
        }

        .cover-content {
            position: relative;
            padding: 80px 50px;
            z-index: 2;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #FFD700;
            margin-bottom: 120px;
            letter-spacing: 3px;
        }

        .ref-badge {
            display: inline-block;
            background: rgba(255, 215, 0, 0.2);
            border: 2px solid #FFD700;
            color: #FFD700;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .title {
            font-size: 38px;
            font-weight: bold;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .address {
            font-size: 13px;
            margin-bottom: 50px;
            opacity: 0.8;
        }

        .price-section {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 40px;
            display: inline-block;
        }

        .price-label {
            font-size: 11px;
            opacity: 0.7;
            margin-bottom: 8px;
        }

        .price {
            font-size: 44px;
            font-weight: bold;
            color: #FFD700;
        }

        .cover-badges {
            margin-top: 60px;
        }

        .badge {
            display: inline-block;
            background: rgba(128, 70, 241, 0.3);
            border: 2px solid #8046F1;
            padding: 10px 22px;
            margin: 6px;
            border-radius: 25px;
            font-size: 10px;
            font-weight: bold;
        }

        /* PAGES - Modern Layout */
        .page {
            padding: 40px;
            page-break-after: always;
        }

        /* Header with accent line */
        .page-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #131B31;
            position: relative;
            padding-left: 15px;
        }

        h1:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, #8046F1 0%, #FFD700 100%);
            border-radius: 3px;
        }

        h2 {
            font-size: 16px;
            font-weight: bold;
            color: #131B31;
            margin: 25px 0 15px 0;
            padding-left: 12px;
            border-left: 4px solid #8046F1;
        }

        /* Modern Image Container */
        .image-container {
            position: relative;
            margin-bottom: 25px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .main-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(19, 27, 49, 0.8) 0%, transparent 100%);
            padding: 20px;
            color: white;
        }

        /* Modern Stats Grid */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px 12px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, #8046F1 0%, #FFD700 100%);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8046F1 0%, #9d5ff5 100%);
            color: #000000;
            border-radius: 12px;
            margin: 0 auto 12px;
            line-height: 50px;
            font-size: 22px;
            font-weight: bold;
        }

        .stat-value {
            font-size: 30px;
            font-weight: bold;
            color: #131B31;
            display: block;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 9px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Modern Description Box */
        .description-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            line-height: 1.8;
            border-left: 4px solid #8046F1;
        }

        /* Modern Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table tr {
            border-bottom: 1px solid #e9ecef;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 12px 10px;
        }

        .info-table td:first-child {
            width: 38%;
            color: #6c757d;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-table td:last-child {
            color: #131B31;
            font-weight: bold;
            font-size: 12px;
        }

        /* Modern Badges */
        .badge-modern {
            background: linear-gradient(135deg, #8046F1 0%, #9d5ff5 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffcd39 100%);
            color: #000;
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e4606d 100%);
        }

        /* Modern Feature Cards */
        .features-grid {
            margin-bottom: 20px;
        }

        .feature-card {
            background: #ffffff;
            border: 2px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 10px;
            position: relative;
            padding-left: 45px;
        }

        .feature-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #8046F1 0%, #9d5ff5 100%);
            color: white;
            border-radius: 6px;
            text-align: center;
            line-height: 24px;
            font-size: 12px;
            font-weight: bold;
        }

        /* Modern Contact Card */
        .contact-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #000000;
            padding: 28px;
            border-radius: 15px;
            margin-top: 25px;
            position: relative;
            overflow: hidden;
            border: 2px solid #d1d5db;
        }

        .contact-card:before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(128, 70, 241, 0.3) 0%, transparent 70%);
        }

        .contact-header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #8046F1;
            position: relative;
        }

        .contact-info {
            position: relative;
        }

        .contact-row {
            margin-bottom: 12px;
            font-size: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
            color: #000000;
        }

        .contact-row:last-child {
            border-bottom: none;
        }

        .contact-label {
            color: #6c757d;
            font-weight: bold;
            display: inline-block;
            width: 100px;
            font-size: 10px;
            text-transform: uppercase;
        }

        /* Alert Box */
        .alert-modern {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px 20px;
            margin: 15px 0;
            color: #856404;
            border-radius: 8px;
            font-size: 11px;
        }

        .alert-danger {
            background: #f8d7da;
            border-left-color: #dc3545;
            color: #721c24;
        }

        /* Modern Gallery */
        .gallery-grid {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .gallery-item {
            width: 33.33%;
            padding: 0;
        }

        .gallery-image {
            width: 100%;
            height: 160px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Modern Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            font-size: 9px;
            color: #6c757d;
        }

        .footer-logo {
            font-size: 14px;
            font-weight: bold;
            background: linear-gradient(to right, #131B31 0%, #8046F1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    <!-- MODERN COVER PAGE -->
    <div class="cover">
        <div class="cover-gradient"></div>
        <div class="cover-content">
            @if(!($hideBranding ?? false))
                <div class="logo">PROPERTYFINDA</div>
            @endif

            <div class="ref-badge">REF: {{ $listing->property_reference_number }}</div>

            <div class="title">{{ $listing->property_title }}</div>
            <div class="address">{{ $listing->address }}</div>

            <div class="price-section">
                <div class="price-label">ASKING PRICE</div>
                <div class="price">£{{ number_format($listing->price) }}</div>
            </div>

            <div class="cover-badges">
                <span class="badge">FOR {{ strtoupper($listing->purpose) }}</span>
                <span class="badge">{{ strtoupper($listing->propertyType->title ?? 'PROPERTY') }}</span>
                @if($listing->unitType)
                    <span class="badge">{{ strtoupper($listing->unitType->title) }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- PAGE 1: OVERVIEW -->
    <div class="page">
        <div class="page-header">
            <h1>Property Overview</h1>
        </div>

        @if($listing->thumbnail)
            @php
                $imagePath = public_path('storage/' . $listing->thumbnail);
                $imageData = '';
                if (file_exists($imagePath)) {
                    $imageData = base64_encode(file_get_contents($imagePath));
                    $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $imageData = 'data:image/' . $imageType . ';base64,' . $imageData;
                }
            @endphp
            @if($imageData)
                <div class="image-container">
                    <img src="{{ $imageData }}" class="main-image">
                </div>
            @endif
        @endif

        <table class="stats-grid">
            <tr>
                <td class="stat-card">
                    <div class="stat-icon text-dark">B</div>
                    <span class="stat-value">{{ $listing->bedrooms }}</span>
                    <div class="stat-label">Bedrooms</div>
                </td>
                <td class="stat-card">
                    <div class="stat-icon text-dark">W</div>
                    <span class="stat-value">{{ $listing->bathrooms }}</span>
                    <div class="stat-label">Bathrooms</div>
                </td>
                <td class="stat-card">
                    <div class="stat-icon text-dark">A</div>
                    <span class="stat-value">{{ $listing->area_size ?? 'N/A' }}</span>
                    <div class="stat-label">Sq Ft</div>
                </td>
                <td class="stat-card">
                    <div class="stat-icon text-dark">F</div>
                    <span class="stat-value">{{ $listing->floors_count ?? '1' }}</span>
                    <div class="stat-label">Floors</div>
                </td>
            </tr>
        </table>

        <div class="description-box">
            {{ strip_tags($listing->description) }}
        </div>
    </div>

    <!-- PAGE 2: DETAILS -->
    <div class="page">
        <div class="page-header">
            <h1>Property Details</h1>
        </div>

        <table class="info-table">
            <tr>
                <td>Property ID</td>
                <td>{{ $listing->property_reference_number }}</td>
            </tr>
            <tr>
                <td>Property Type</td>
                <td>{{ $listing->propertyType->title ?? 'N/A' }}</td>
            </tr>
            @if($listing->unitType)
                <tr>
                    <td>Unit Type</td>
                    <td>{{ $listing->unitType->title }}</td>
                </tr>
            @endif
            <tr>
                <td>Purpose</td>
                <td>{{ ucfirst($listing->purpose) }}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>£{{ number_format($listing->price) }}</td>
            </tr>
            <tr>
                <td>Ownership</td>
                <td>{{ $listing->ownershipStatus->title ?? 'Freehold' }}</td>
            </tr>
            @if($listing->epc_rating)
                <tr>
                    <td>Energy Rating</td>
                    <td><span class="badge-modern badge-success">EPC {{ $listing->epc_rating }}</span></td>
                </tr>
            @endif
            @if($listing->council_tax_band)
                <tr>
                    <td>Council Tax</td>
                    <td>Band {{ $listing->council_tax_band }}</td>
                </tr>
            @endif
            <tr>
                <td>Total Area</td>
                <td>{{ $listing->area_size ?? 'N/A' }} Square Feet</td>
            </tr>
        </table>

        @if($listing->flood_risk || $listing->listed_property || $listing->no_onward_chain)
            <h2>Legal & Environmental</h2>

            <table class="info-table">
                @if($listing->listed_property)
                    <tr>
                        <td>Listed Building</td>
                        <td><span class="badge-modern badge-warning">{{ $listing->listed_property }}</span></td>
                    </tr>
                @endif
                @if($listing->no_onward_chain)
                    <tr>
                        <td>Chain Status</td>
                        <td><span class="badge-modern badge-success">No Onward Chain</span></td>
                    </tr>
                @endif
                @if($listing->flood_risk)
                    <tr>
                        <td>Flood Risk</td>
                        <td>
                            @if($listing->flood_risk === 'Very Low' || $listing->flood_risk === 'Low')
                                <span class="badge-modern badge-success">{{ $listing->flood_risk }}</span>
                            @elseif($listing->flood_risk === 'Medium')
                                <span class="badge-modern badge-warning">{{ $listing->flood_risk }}</span>
                            @else
                                <span class="badge-modern badge-danger">{{ $listing->flood_risk }}</span>
                            @endif
                        </td>
                    </tr>
                @endif
                @if($listing->flood_history)
                    <tr>
                        <td>Flood History</td>
                        <td>{{ ucfirst($listing->flood_history) }}</td>
                    </tr>
                @endif
                @if($listing->flood_defenses)
                    <tr>
                        <td>Flood Defenses</td>
                        <td>{{ ucfirst($listing->flood_defenses) }}</td>
                    </tr>
                @endif
            </table>

            @if($listing->flood_risk && in_array($listing->flood_risk, ['High', 'Medium']))
                <div class="alert-modern alert-danger">
                    <strong>⚠ Flood Risk Warning:</strong> This property is in a {{ $listing->flood_risk }} flood risk area.
                </div>
            @endif
        @endif

        @if(isset($mortgageDetails) && $mortgageDetails)
            <h2>Estimated Mortgage</h2>
            <div class="alert-modern" style="background: #f0fdf9; border-left-color: #8046F1;">
                <table class="info-table" style="margin: 0;">
                    <tr>
                        <td>Monthly Payment</td>
                        <td style="font-size: 16px; color: #8046F1;">
                            £{{ number_format($mortgageDetails['monthly_payment'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Down Payment ({{ $mortgageDetails['deposit_percent'] }}%)</td>
                        <td>£{{ number_format($mortgageDetails['deposit']) }}</td>
                    </tr>
                    <tr>
                        <td>Interest Rate</td>
                        <td>{{ $mortgageDetails['interest_rate'] }}%</td>
                    </tr>
                    <tr>
                        <td>Loan Term</td>
                        <td>{{ $mortgageDetails['term_years'] }} Years</td>
                    </tr>
                </table>
                <div style="font-size: 9px; color: #666; margin-top: 8px; font-style: italic;">
                    *Estimated monthly payment based on {{ $mortgageDetails['interest_rate'] }}% interest rate over
                    {{ $mortgageDetails['term_years'] }} years. Actual rates may vary.
                </div>
            </div>
        @endif

        @if($listing->features->count() > 0)
            <h2>Key Features & Amenities</h2>

            <div class="features-grid">
                @foreach($listing->features as $feature)
                    <div class="feature-card">
                        <div class="feature-icon">✓</div>
                        {{ $feature->title }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- PAGE 3: GALLERY & CONTACT -->
    <div class="page">
        @if(count($gallery) > 0)
            <div class="page-header">
                <h1>Property Gallery</h1>
            </div>

            <table class="gallery-grid">
                @foreach(array_chunk($gallery, 3) as $row)
                    <tr>
                        @foreach($row as $image)
                            <td class="gallery-item">
                                @php
                                    $galleryPath = public_path('storage/' . $image);
                                    $galleryData = '';
                                    if (file_exists($galleryPath)) {
                                        $galleryData = base64_encode(file_get_contents($galleryPath));
                                        $galleryType = pathinfo($galleryPath, PATHINFO_EXTENSION);
                                        $galleryData = 'data:image/' . $galleryType . ';base64,' . $galleryData;
                                    }
                                @endphp
                                @if($galleryData)
                                    <img src="{{ $galleryData }}" class="gallery-image">
                                @endif
                            </td>
                        @endforeach
                        @if(count($row) < 3)
                            @for($i = count($row); $i < 3; $i++)
                                <td class="gallery-item"></td>
                            @endfor
                        @endif
                    </tr>
                @endforeach
            </table>
        @endif

        <div class="contact-card">
            <div class="contact-header">Get In Touch</div>
            <div class="contact-info">
                <div class="contact-row text-dark">
                    <span class="contact-label">Agent Name</span>
                    {{ $agent->name ?? 'Agent' }}
                </div>
                @if($agent && $agent->phone_number)
                    <div class="contact-row text-dark">
                        <span class="contact-label">Phone</span>
                        {{ $agent->phone_number }}
                    </div>
                @endif
                @if($agent && $agent->email)
                    <div class="contact-row text-dark">
                        <span class="contact-label">Email</span>
                        {{ $agent->email }}
                    </div>
                @endif
                <div class="contact-row text-dark">
                    <span class="contact-label">Reference</span>
                    {{ $listing->property_reference_number }}
                </div>
            </div>
        </div>

        <div class="footer">
            @if(!($hideBranding ?? false))
                <div class="footer-logo">PROPERTYFINDA</div>
                <div>Your Trusted Real Estate Partner</div>
            @endif
            <div>Generated: {{ now()->format('d M Y, h:i A') }}</div>
            <div style="margin-top: 6px; font-style: italic;">This brochure is for informational purposes only.</div>
        </div>
    </div>
</body>

</html>