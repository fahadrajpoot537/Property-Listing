<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $listing->property_title }} - Brochure</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1a202c;
            background: #ffffff;
            line-height: 1.3;
        }

        /* Color Palette */
        .bg-primary {
            background-color: #131B31;
        }

        .bg-secondary {
            background-color: #8046F1;
        }

        .text-primary {
            color: #131B31;
        }

        .text-secondary {
            color: #8046F1;
        }

        .text-white {
            color: #ffffff;
        }

        .text-gray {
            color: #718096;
        }

        /* Typography */
        .font-black {
            font-weight: 900;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        /* Hero Page */
        .hero-page {
            height: 98vh;
            width: 100%;
            position: relative;
            background-color: #ffffff;
        }

        .hero-image-container {
            height: 60%;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            padding: 15px 40px;
            background-color: #131B31;
            color: white;
            height: 40%;
        }

        .hero-title {
            font-size: 26px;
            margin: 0 0 2px 0;
            line-height: 1.1;
        }

        .hero-address {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 8px;
        }

        .hero-price {
            font-size: 28px;
            color: #ffffff;
        }

        /* Content Sections */
        .container {
            padding: 10px 40px;
        }

        .section-title {
            font-size: 14px;
            border-left: 4px solid #8046F1;
            padding-left: 10px;
            margin-bottom: 10px;
            margin-top: 20px;
            color: #131B31;
            font-weight: 900;
        }

        .section-title:first-child {
            margin-top: 0;
        }

        /* Specs Grid */
        .specs-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .spec-item {
            width: 20%;
            padding: 8px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            text-align: center;
        }

        .spec-label {
            font-size: 8px;
            color: #718096;
            margin-bottom: 2px;
        }

        .spec-value {
            font-size: 12px;
            color: #131B31;
            font-weight: 900;
        }

        /* Description */
        .description-content {
            font-size: 10px;
            color: #2d3748;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .description-content ul,
        .description-content ol {
            padding-left: 20px;
            margin: 8px 0;
        }

        .description-content p {
            margin: 8px 0;
        }

        /* Details Cards */
        .detail-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .detail-row {
            padding: 5px 0;
            border-bottom: 1px solid #f7fafc;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 9px;
            color: #718096;
            font-weight: 700;
            text-transform: uppercase;
        }

        .detail-value {
            font-size: 10px;
            color: #131B31;
            text-align: right;
            font-weight: 900;
        }

        /* Feature Pills */
        .feature-pill {
            display: inline-block;
            background: #f3f0ff;
            color: #8046F1;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 9px;
            margin: 0 4px 4px 0;
            border: 1px solid #e9d8fd;
            font-weight: 700;
        }

        /* Gallery */
        .gallery-grid {
            width: 100%;
            border-spacing: 4px;
            margin-left: -4px;
        }

        .gallery-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Agent Info Card */
        .agent-card {
            background: #131B31;
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
            color: white;
        }

        .agent-avatar {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #8046F1;
        }

        .agent-name {
            font-size: 16px;
            color: #131B31;
        }

        .agent-role {
            font-size: 10px;
            color: #8046F1;
        }

        .page-break {
            page-break-after: always;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* QR Code */
        .qr-section {
            text-align: center;
            padding: 15px;
            background: #ffffff;
            border-radius: 10px;
            border: 1px dashed #e2e8f0;
        }

        /* Buttons */
        .btn-container {
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            margin-right: 8px;
            color: white !important;
        }

        .btn-wa {
            background-color: #25D366;
        }

        .btn-email {
            background-color: #8046F1;
        }

        .btn-call {
            background-color: #ffffff;
            color: #131B31 !important;
        }

        /* Mortgage Section */
        .mortgage-box {
            background: #f0f4f8;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #d1d5db;
        }

        .mortgage-title {
            font-size: 14px;
            font-weight: 900;
            color: #131B31;
            margin-bottom: 10px;
        }

        .mortgage-val {
            font-size: 20px;
            font-weight: 900;
            color: #8046F1;
        }
    </style>
</head>

<body>
    @php
        function getBase64Image($path)
        {
            if (!$path)
                return null;
            if (strpos($path, 'http') === 0) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $data = @file_get_contents($path, false, $ctx);
                    if ($data !== false) {
                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $mime = $finfo->buffer($data);
                        return 'data:' . $mime . ';base64,' . base64_encode($data);
                    }
                } catch (\Exception $e) {
                    return null;
                }
            }
            $pathsToCheck = [public_path('storage/' . $path), storage_path('app/public/' . $path), public_path($path)];
            foreach ($pathsToCheck as $fullPath) {
                $fullPath = str_replace('\\', '/', $fullPath);
                if (file_exists($fullPath)) {
                    $type = pathinfo($fullPath, PATHINFO_EXTENSION) ?: 'jpg';
                    try {
                        $data = @file_get_contents($fullPath);
                        if ($data !== false)
                            return 'data:image/' . $type . ';base64,' . base64_encode($data);
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
            return null;
        }
        $heroImage = getBase64Image($listing->thumbnail);
        $contactAvatar = $contactPerson && $contactPerson->profile_photo_path ? getBase64Image($contactPerson->profile_photo_path) : null;

        $propertyUrl = url('/property/' . ($listing->slug ?? $listing->id));
        $qrCode = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($propertyUrl);
        $qrImage = getBase64Image($qrCode);

        $phone = $contactPerson->phone ?? $contactPerson->phone_number ?? '';
        $email = $contactPerson->email ?? '';
        $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $phone);

        // Mortgage Calculation Basics
        $price = $listing->price;
        $downPayment = $price * 0.20;
        $loanAmount = $price - $downPayment;
        $annualInterest = 0.04;
        $monthlyRate = $annualInterest / 12;
        $months = 30 * 12;
        $monthlyPayment = $loanAmount * ($monthlyRate * pow(1 + $monthlyRate, $months)) / (pow(1 + $monthlyRate, $months) - 1);
    @endphp

    <!-- PAGE 1: HERO -->
    <div class="hero-page">
        <div class="hero-image-container">
            @if($heroImage)
                <img src="{{ $heroImage }}" class="hero-image">
            @else
                <div style="width:100%; height:100%; background:#edf2f7; display:table; text-align:center;">
                    <div style="display:table-cell; vertical-align:middle; color:#a0aec0; font-size:20px;">IMAGE UNAVAILABLE
                    </div>
                </div>
            @endif
        </div>

        <div class="hero-content clearfix">
            <div style="float:left; width: 70%;">
                <div class="hero-title font-black uppercase tracking-widest">{{ $listing->property_title }}</div>
                <div class="hero-address font-bold">{{ $listing->address }}</div>
                <div class="hero-price font-black">£{{ number_format($listing->price) }}</div>

                <div class="btn-container" style="margin-top: 15px;">
                    <a href="{{ $waLink }}" class="btn btn-wa">WhatsApp</a>
                    <a href="mailto:{{ $email }}" class="btn btn-email">Email Agent</a>
                    <a href="tel:{{ $phone }}" class="btn btn-call">Call Agent</a>
                </div>

                <table style="width: 100%; margin-top: 15px;">
                    <tr>
                        <td style="width: 33%;">
                            <div class="spec-label font-bold uppercase text-white opacity-60">Listing Purpose</div>
                            <div class="font-black" style="font-size: 14px;">{{ strtoupper($listing->purpose) }}</div>
                        </td>
                        <td style="width: 33%;">
                            <div class="spec-label font-bold uppercase text-white opacity-60">Property Type</div>
                            <div class="font-black" style="font-size: 14px;">
                                {{ $listing->propertyType->title ?? 'Residential' }}</div>
                        </td>
                        <td style="width: 33%;">
                            <div class="spec-label font-bold uppercase text-white opacity-60">Reference</div>
                            <div class="font-black" style="font-size: 14px;">{{ $listing->property_reference_number }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="float:right; width: 25%; text-align:right;">
                @if($qrImage)
                    <div
                        style="background:white; padding: 10px; display:inline-block; border-radius: 12px; margin-top: 10px;">
                        <img src="{{ $qrImage }}" style="width: 100px; height: 100px;">
                        <div style="color:#131B31; font-size: 8px; font-weight: 900; margin-top: 5px; text-align: center;">
                            SCAN TO VIEW DETAILS</div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- PAGE 2: SPECS -->
    <div class="container">
        <div class="section-title uppercase tracking-widest">Property Essentials</div>
        <table class="specs-table">
            <tr>
                <td class="spec-item">
                    <div class="spec-label uppercase font-bold">Bedrooms</div>
                    <div class="spec-value">{{ $listing->bedrooms ?? 'N/A' }}</div>
                </td>
                <td class="spec-item">
                    <div class="spec-label uppercase font-bold">Bathrooms</div>
                    <div class="spec-value">{{ $listing->bathrooms ?? 'N/A' }}</div>
                </td>
                <td class="spec-item">
                    <div class="spec-label uppercase font-bold">Reception</div>
                    <div class="spec-value">{{ $listing->reception_rooms ?? 'N/A' }}</div>
                </td>
                <td class="spec-item">
                    <div class="spec-label uppercase font-bold">Area Size</div>
                    <div class="spec-value">
                        {{ $listing->area_size ? number_format($listing->area_size) . ' sqft' : 'N/A' }}</div>
                </td>
                <td class="spec-item">
                    <div class="spec-label uppercase font-bold">Floor Level</div>
                    <div class="spec-value">{{ $listing->floor_level ?? 'N/A' }}</div>
                </td>
            </tr>
        </table>

        <div class="row">
            <div class="col w-half" style="padding-right: 20px;">
                <div class="section-title uppercase tracking-widest">Comprehensive Description</div>
                <div class="description-content">{!! $listing->description !!}</div>

                @if($listing->features->count() > 0)
                    <div class="section-title uppercase tracking-widest">Key Features</div>
                    <div>
                        @foreach($listing->features as $feature)
                            <span class="feature-pill">{{ $feature->title }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col w-half">
                <div class="section-title uppercase tracking-widest">Detailed Specifications</div>
                <div class="detail-card">
                    <table class="w-full">
                        <tr class="detail-row">
                            <td class="detail-label">Tenure</td>
                            <td class="detail-value">{{ $listing->tenure ?? 'N/A' }} @if($listing->unexpired_years)
                            ({{ $listing->unexpired_years }} yrs) @endif</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">EPC Rating</td>
                            <td class="detail-value">{{ $listing->epc_rating ?? 'N/A' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Council Tax</td>
                            <td class="detail-value">Band {{ $listing->council_tax_band ?? 'N/A' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Floors</td>
                            <td class="detail-value">{{ $listing->floors_count ?? 'N/A' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Construction</td>
                            <td class="detail-value">{{ $listing->construction_type ?? 'Standard' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Parking</td>
                            <td class="detail-value">{{ $listing->parking_type ?? 'N/A' }}
                                @if($listing->parking_spaces_count) ({{ $listing->parking_spaces_count }}) @endif</td>
                        </tr>
                    </table>
                </div>

                <div class="section-title uppercase tracking-widest">Utilities & Safety</div>
                <div class="detail-card">
                    <table class="w-full">
                        <tr class="detail-row">
                            <td class="detail-label">Heating</td>
                            <td class="detail-value">{{ $listing->heating_type ?? 'N/A' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Water</td>
                            <td class="detail-value">{{ $listing->utilities_water ?? 'Mains' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Broadband</td>
                            <td class="detail-value">{{ $listing->broadband ?? 'Available' }}</td>
                        </tr>
                        <tr class="detail-row">
                            <td class="detail-label">Flood Risk</td>
                            <td class="detail-value">{{ $listing->flood_risk ?? 'Very Low' }}</td>
                        </tr>
                    </table>
                </div>

        @if($listing->purpose === 'Buy' || $listing->purpose === 'Sale')
                <div class="section-title uppercase tracking-widest">Mortgage Illustration</div>
                <div class="mortgage-box">
                    <div class="mortgage-title">Estimated Monthly Payment</div>
                    <div class="mortgage-val">£{{ number_format($monthlyPayment, 2) }}</div>
                    <div style="font-size: 8px; color: #4a5568; margin-top: 5px;">* Based on 20% down payment (£{{ number_format($downPayment) }}), 4% fixed rate over 30 years. Illustration only.</div>
                </div>
                @endif
            </div>
        </div>

        <!-- GALLERY SECTION -->
        @if(count($gallery) > 1)
            <div class="section-title uppercase tracking-widest">Photo Gallery</div>
            <table style="width: 100%; border-spacing: 5px; margin-top: 5px;">
                @php 
                    $galleryItems = array_slice($gallery, 0, 9); // Show up to 9 more images
                @endphp
                @foreach(array_chunk($galleryItems, 3) as $row)
                <tr>
                    @foreach($row as $img)
                    <td style="width: 33.33%;">
                        @php $gImg = getBase64Image($img); @endphp
                        @if($gImg)
                            <img src="{{ $gImg }}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #edf2f7;">
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </table>
        @endif

        @if($mapImage)
            <div class="section-title uppercase tracking-widest">Location Map</div>
            <div style="width: 100%; height: 180px; border-radius: 12px; overflow: hidden; border: 1px solid #edf2f7; margin-top: 5px;">
                <img src="{{ $mapImage }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        @endif

        <!-- CONTACT SECTION AT THE BOTTOM -->
        <div class="agent-card clearfix">
            <div style="float: left; width: 60px;">
                @if($contactAvatar)
                    <img src="{{ $contactAvatar }}" class="agent-avatar">
                @else
                    <div
                        style="width:60px; height:60px; background:#8046F1; color:white; border-radius:12px; text-align:center; line-height:60px; font-weight:900; font-size:24px;">
                        {{ substr($contactPerson->name ?? 'A', 0, 1) }}
                    </div>
                @endif
            </div>
            <div style="float: left; margin-left: 20px; width: 350px;">
                <div style="font-size: 18px; font-weight: 900;">{{ $contactPerson->name ?? 'Property Consultant' }}
                </div>
                <div style="font-size: 10px; font-weight: 700; color: #8046F1; text-transform: uppercase;">Professional
                    Agent & Consultant</div>
                <div class="btn-container" style="margin-top: 10px;">
                    <a href="{{ $waLink }}" class="btn btn-wa" style="padding: 5px 10px; font-size: 8px;">WhatsApp</a>
                    <a href="mailto:{{ $email }}" class="btn btn-email"
                        style="padding: 5px 10px; font-size: 8px;">Email</a>
                    <a href="tel:{{ $phone }}" class="btn btn-call" style="padding: 5px 10px; font-size: 8px;">Call
                        Direct</a>
                </div>
            </div>
            
        </div>

        <div
            style="text-align: center; margin-top: 15px; font-size: 8px; color: #cbd5e0; text-transform: uppercase; letter-spacing: 2px; font-weight: 700;">
            Premium Property Marketing 
        </div>
    </div>

    @if(count($gallery) > 1) {{-- More than just the thumbnail --}}
            <div class="page-break"></div>
            <div class="container">
                <div class="section-title font-black uppercase tracking-widest">Gallery & Visuals</div>
                <table class="gallery-grid">
                    @php 
                                    // Show up to 12 images in a compact grid
                        $galleryItems = array_slice($gallery, 0, 12); 
                    @endphp
                    @foreach(array_chunk($galleryItems, 3) as $row)
                        <tr>
                            @foreach($row as $img)
                                <td style="width: 33.33%;">
                                        @php $gImg = getBase64Image($img); @endphp
                                        @if($gImg)
                                            <img src="{{ $gImg }}" class="gallery-img" style="height: 140px;">
                                        @endif
                                </td>
                            @endforeach
                            @for($i = count($row); $i < 3; $i++)
                                <td style="width: 33.33%;"></td>
                            @endfor
                        </tr>
                    @endforeach
                </table>

                @if($mapImage)
                    <div class="section-title font-black uppercase tracking-widest">Location Map</div>
                    <div style="width: 100%; height: 200px; border-radius: 10px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <img src="{{ $mapImage }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endif
            </d
        iv>
    @endif

</body>
</html>