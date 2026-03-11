<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $listing->property_title }} - Exclusive Brochure</title>
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
            line-height: 1.4;
        }

        .bg-navy {
            background-color: #131B31;
        }

        .bg-accent {
            background-color: #8046F1;
        }

        .text-navy {
            color: #131B31;
        }

        .text-accent {
            color: #8046F1;
        }

        .text-white {
            color: #ffffff;
        }

        .text-muted {
            color: #718096;
        }

        .font-black {
            font-weight: 900;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .tracking-tight {
            letter-spacing: -0.02em;
        }

        .tracking-widest {
            letter-spacing: 0.15em;
        }

        /* Cover Page */
        .cover {
            height: 100vh;
            width: 100%;
            background-color: #131B31;
            color: white;
            position: relative;
        }

        .cover-image-box {
            height: 65%;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cover-content {
            padding: 5px 10px;
            height: 20%;
        }

        .cover-title {
            font-size: 32px;
            line-height: 1;
            margin-bottom: 5px;
        }

        .cover-address {
            font-size: 14px;
            opacity: 0.7;
            margin-bottom: 15px;
        }

        .cover-price {
            font-size: 36px;
            color: #8046F1;
        }

        /* Branding Strip */
        .branding-strip {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #8046F1, #4c1d95);
        }

        /* Page Layout */
        .page {
            padding: 20px 30px;
            position: relative;
        }

        .section-header {
            margin-bottom: 12px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 6px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 900;
            color: #131B31;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Essential Grid */
        .essential-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 -10px 15px -10px;
        }

        .essential-item {
            background: #f8fafc;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            border: 1px solid #f1f5f9;
        }

        .essential-label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .essential-value {
            font-size: 15px;
            color: #131B31;
            font-weight: 900;
        }

        /* Info Layout */
        .info-table {
            width: 100%;
        }

        .description-pane {
            width: 60%;
            padding-right: 30px;
            vertical-align: top;
        }

        .specs-pane {
            width: 40%;
            vertical-align: top;
        }

        .description-text {
            font-size: 10.5px;
            color: #334155;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* Specs Group */
        .spec-group {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 5px;
            margin-bottom: 5px;
        }

        .spec-row {
            padding: 6px 0;
            border-bottom: 1px solid #f8fafc;
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-label {
            font-size: 8.5px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
        }

        .spec-val {
            font-size: 10px;
            color: #131B31;
            font-weight: 900;
            text-align: right;
        }

        /* Pills */
        .pill {
            display: inline-block;
            background: #f1f5f9;
            color: #475569;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0 4px 6px 0;
        }

        .pill-accent {
            background: #f3f0ff;
            color: #8046F1;
        }

        /* Gallery */
        .gallery-table {
            width: 100%;
            border-spacing: 8px;
            margin: 0 -8px;
        }

        .gallery-box {
            width: 50%;
            vertical-align: top;
            padding-bottom: 8px;
        }

        .gallery-img {
            width: 100%;
            height: auto;
            max-height: 200px;
            /* safety fallback */
            border-radius: 8px;
        }

        /* Agent Card */
        .agent-card {
            background: #131B31;
            border-radius: 16px;
            padding: 15px 20px;
            color: white;
            margin-top: 20px;
        }

        .agent-avatar {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            border: 2px solid #8046F1;
        }

        /* QR */
        .qr-box {
            background: white;
            padding: 10px;
            border-radius: 12px;
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
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
        $qrImage = getBase64Image("https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($propertyUrl));
        $phone = $contactPerson->phone ?? $contactPerson->phone_number ?? '';
    @endphp

    <!-- COVER -->
    <div class="cover">
        <div style="height: 65%; position: relative; overflow: hidden; background: #131B31;">
            <!-- Full Width Hero Image -->
            <div class="cover-image-box" style="width: 100%; height: 100%;">
                @if($heroImage)
                    <img src="{{ $heroImage }}" class="cover-image" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width:100%; height:100%; background:#1e293b; display:table; text-align:center;">
                        <span
                            style="display:table-cell; vertical-align:middle; color:#475569; font-size:14px; font-weight:900; letter-spacing:2px;">PREVIEW
                            UNAVAILABLE</span>
                    </div>
                @endif
            </div>

            <!-- Overlaid Contact Panel -->
            <div
                style="position: absolute; top: 0; right: 0; width: 28%; height: 100%; background: rgba(19, 27, 49, 0.85); padding: 40px 20px; box-sizing: border-box; color: white; border-left: 1px solid rgba(255,255,255,0.1);">


                <div style="text-align: left;">
                    <div style="
                               font-size:18px; font-weight:900; margin-bottom:2px; color: white; line-height: 1.2;">
                        {{ $contactPerson->name ?? 'Property Consultant' }}
                    </div>
                    <div
                        style="font-size:8px; font-weight:900; color:#8046F1; text-transform:uppercase; letter-spacing:1px; margin-bottom:25px;">
                        Accredited Property Consultant</div>

                    <div style="margin-top: 20px;">
                        @if($phone)
                            <div style="margin-bottom: 12px;">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}"
                                    style="display:block; text-align: center; background-color:#25D366; color:white; padding:12px 15px; border-radius:8px; text-decoration:none; font-size:11px; font-weight:bold;">WhatsApp</a>
                            </div>
                            <div style="margin-bottom: 12px;">
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $phone) }}"
                                    style="display:block; text-align: center; background-color:white; color:#131B31; padding:12px 15px; border-radius:8px; text-decoration:none; font-size:11px; font-weight:bold;">Call
                                    Agent</a>
                            </div>
                        @endif
                        @if(isset($contactPerson) && $contactPerson->email)
                            <div style="margin-bottom: 12px;">
                                <a href="mailto:{{ $contactPerson->email }}"
                                    style="display:block; text-align: center; background-color:#8046F1; color:white; padding:12px 15px; border-radius:8px; text-decoration:none; font-size:11px; font-weight:bold;">Email</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="cover-content clearfix">
            <div style="float:left; width:70%;">
                <h1 class="cover-title font-black uppercase tracking-tight">{{ $listing->property_title }}</h1>
                <p class="cover-address font-bold uppercase tracking-widest">{{ $listing->address }}</p>
                <div class="cover-price font-black">£{{ number_format($listing->price) }} <span
                        style="font-size:12px; opacity:0.6; font-weight:700;">{{ $listing->price_qualifier }}</span>
                </div>

                <table style="margin-top:20px; width:100%;">
                    <tr>
                        <td style="width:33%;">
                            <div
                                style="font-size:7px; text-transform:uppercase; font-weight:900; color:#8046F1; margin-bottom:2px;">
                                Ref. Number</div>
                            <div style="font-size:11px; font-weight:900;">#{{ $listing->property_reference_number }}
                            </div>
                        </td>
                        <td style="width:33%;">
                            <div
                                style="font-size:7px; text-transform:uppercase; font-weight:900; color:#8046F1; margin-bottom:2px;">
                                Property Type</div>
                            <div style="font-size:11px; font-weight:900;">
                                {{ $listing->propertyType->title ?? 'Residential' }}
                            </div>
                        </td>
                        <td style="width:33%;">
                            <div
                                style="font-size:7px; text-transform:uppercase; font-weight:900; color:#8046F1; margin-bottom:2px;">
                                Market Status</div>
                            <div style="font-size:11px; font-weight:900;">{{ strtoupper($listing->purpose) }}</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="float:right; width:22%; text-align:right;">
                @if($qrImage)
                    <div class="qr-box">
                        <img src="{{ $qrImage }}" style="width:80px; height:80px;">
                        <div style="color:#131B31; font-size:6px; font-weight:900; margin-top:5px;">DIGITAL PORTAL</div>
                    </div>
                @endif
            </div>
        </div>
        <div class="branding-strip"></div>
    </div>

    <div class="page-break"></div>

    <!-- SPECS & DETAILS -->
    <div class="page">
        <div class="section-header">
            <div class="section-title">Essential Overview</div>
        </div>

        <table class="essential-grid">
            <tr>
                <td style="width:20%;" class="essential-item">
                    <div class="essential-label">Beds</div>
                    <div class="essential-value">{{ $listing->bedrooms ?? '—' }}</div>
                </td>
                <td style="width:20%;" class="essential-item">
                    <div class="essential-label">Baths</div>
                    <div class="essential-value">{{ $listing->bathrooms ?? '—' }}</div>
                </td>
                <td style="width:20%;" class="essential-item">
                    <div class="essential-label">Recep.</div>
                    <div class="essential-value">{{ $listing->reception_rooms ?? '—' }}</div>
                </td>
                <td style="width:20%;" class="essential-item">
                    <div class="essential-label">Size</div>
                    <div class="essential-value">
                        @if($listing->area_size && is_numeric($listing->area_size))
                            {{ number_format((float) $listing->area_size) }}<span style="font-size:8px;">ft²</span>
                        @else
                            {{ $listing->area_size ?? '—' }}
                        @endif
                    </div>
                </td>
                <td style="width:20%;" class="essential-item">
                    <div class="essential-label">Floor</div>
                    <div class="essential-value">{{ $listing->floor_level ?? '—' }}</div>
                </td>
            </tr>
        </table>

        <table class="info-table" style="width: 100%; border-spacing: 0;">
            <tr>
                <td class="description-pane" style="width: 65%; vertical-align: top; padding-right: 25px;">
                    <div class="section-header">
                        <div class="section-title">About this Property</div>
                    </div>
                    <div class="description-text" style="min-height: 150px;">{!! $listing->description !!}</div>

                    @if($listing->features->count() > 0)
                        <div class="section-header" style="margin-top: 25px;">
                            <div class="section-title">Property Highlights</div>
                        </div>
                        <div
                            style="margin-bottom:15px; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #f1f5f9;">
                            @foreach($listing->features as $feature)
                                <span class="pill pill-accent" style="margin-bottom: 8px;">{{ $feature->title }}</span>
                            @endforeach
                        </div>
                    @endif
                </td>
                <td class="specs-pane" style="width: 35%; vertical-align: top;">
                    <div class="section-header">
                        <div class="section-title">Technical Specifications</div>
                    </div>
                    <div class="spec-group" style="padding: 10px;">
                        <table style="width:100%;">
                            <tr class="spec-row">
                                <td class="spec-label">Tenure</td>
                                <td class="spec-val">{{ $listing->tenure ?? 'N/A' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Lease Yrs</td>
                                <td class="spec-val">{{ $listing->unexpired_years ?? '—' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Service Charge</td>
                                <td class="spec-val">{{ $listing->service_charge ?? '—' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Ground Rent</td>
                                <td class="spec-val">{{ $listing->ground_rent ?? '—' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Tax Band</td>
                                <td class="spec-val">{{ $listing->council_tax_band ?? '—' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Parking</td>
                                <td class="spec-val">{{ $listing->parking_type ?? 'N/A' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Construction</td>
                                <td class="spec-val">{{ $listing->construction_type ?? 'Standard' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="section-header" style="margin-top: 20px;">
                        <div class="section-title">Utilities & Infrastructure</div>
                    </div>
                    <div class="spec-group" style="padding: 10px;">
                        <table style="width:100%;">
                            <tr class="spec-row">
                                <td class="spec-label">Water</td>
                                <td class="spec-val">{{ $listing->utilities_water ?? 'Ask Agent' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Electricity</td>
                                <td class="spec-val">{{ $listing->utilities_electricity ?? 'Ask Agent' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Heating</td>
                                <td class="spec-val">{{ $listing->heating_type ?? 'Ask Agent' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Broadband</td>
                                <td class="spec-val">{{ $listing->broadband ?? 'Ask Agent' }}</td>
                            </tr>
                            <tr class="spec-row">
                                <td class="spec-label">Mobile</td>
                                <td class="spec-val">{{ $listing->mobile_coverage ?? 'Ask Agent' }}</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @if(count($gallery) > 1)
        <div class="page" style="padding-top: 10px;">
            <div class="section-header">
                <div class="section-title">Visual Gallery</div>
            </div>
            <table class="gallery-table">
                @php $galleryItems = array_slice($gallery, 0, 12); @endphp
                @foreach(array_chunk($galleryItems, 2) as $row)
                    <tr>
                        @foreach($row as $img)
                            <td class="gallery-box">
                                @php $gImg = getBase64Image($img); @endphp
                                @if($gImg) <img src="{{ $gImg }}" class="gallery-img"> @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>

            @if($mapImage)
                <div class="section-header" style="margin-top:30px;">
                    <div class="section-title">Property Location</div>
                </div>
                <div style="width:100%; height:350px; border-radius:15px; overflow:hidden; border:1px solid #f1f5f9;">
                    <img src="{{ $mapImage }}" style="width:100%; height:100%; object-fit:cover;">
                </div>
            @endif

            <div class="agent-card clearfix">
                <div style="float:left; width:60px;">
                    @if($contactAvatar)
                        <img src="{{ $contactAvatar }}" class="agent-avatar">
                    @else
                        <div
                            style="width:55px; height:55px; background:#8046F1; color:white; border-radius:12px; text-align:center; line-height:55px; font-weight:900; font-size:22px;">
                            {{ substr($contactPerson->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                </div>
                <div style="float:left; margin-left:20px; width:450px;">
                    <div style="font-size:16px; font-weight:900; margin-bottom:2px;">
                        {{ $contactPerson->name ?? 'Property Consultant' }}
                    </div>
                    <div
                        style="font-size:9px; font-weight:900; color:#8046F1; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">
                        Accredited Property Consultant</div>

                    <div>
                        @if($phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}"
                                style="display:inline-block; background-color:#25D366; color:white; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:10px; font-weight:bold; margin-right:5px;">WhatsApp</a>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', $phone) }}"
                                style="display:inline-block; background-color:#ffffff; color:#131B31; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:10px; font-weight:bold; margin-right:5px;">Call
                                Agent</a>
                        @endif
                        @if(isset($contactPerson) && $contactPerson->email)
                            <a href="mailto:{{ $contactPerson->email }}"
                                style="display:inline-block; background-color:#8046F1; color:white; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:10px; font-weight:bold;">Email</a>
                        @endif
                    </div>
                </div>
            </div>

            <div
                style="text-align:center; margin-top:20px; font-size:7px; color:#94a3b8; text-transform:uppercase; letter-spacing:3px; font-weight:900;">
                Premium Property Marketing </div>
        </div>
    @endif

</body>

</html>