<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $listing->property_title }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
            background: #ffffff;
            line-height: 1.3;
        }

        /* Helpers */
        .text-white {
            color: white;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Hero Image */
        .hero-section {
            width: 100%;
            height: 380px;
            background-color: #f1f5f9;
            overflow: hidden;
            position: relative;
        }

        .hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Title Section */
        .title-section {
            background-color: #0f172a;
            color: #ffffff;
            padding: 20px 30px;
            overflow: hidden;
        }

        .property-title {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 5px 0;
            line-height: 1.2;
        }

        .property-address {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .property-price {
            font-size: 22px;
            font-weight: 800;
        }

        .badge {
            background: #8046F1;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-left: 10px;
        }

        /* Contact Cards */
        .contact-card {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 220px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            float: left;
            margin-right: 10px;
        }

        .contact-info {
            overflow: hidden;
        }

        .contact-name {
            font-weight: 800;
            font-size: 13px;
            color: #0f172a;
            display: block;
            margin-top: 5px;
        }

        .contact-role {
            font-size: 10px;
            color: #64748b;
            display: block;
        }

        .contact-actions {
            margin-top: 10px;
            clear: both;
            text-align: center;
        }

        .action-btn {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 9px;
            font-weight: bold;
            margin: 0 2px;
        }

        .bg-wa {
            background-color: #25D366;
        }

        .bg-email {
            background-color: #0f172a;
        }

        .bg-call {
            background-color: #3b82f6;
        }

        /* Main Content */
        .content-container {
            padding: 20px 30px;
        }

        .section-heading {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .section-heading:first-child {
            margin-top: 0;
        }

        /* Specs */
        .specs-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .specs-cell {
            width: 25%;
            padding: 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
        }

        .specs-label {
            font-size: 10px;
            color: #64748b;
            display: block;
            text-transform: uppercase;
        }

        .specs-value {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            display: block;
        }

        /* Description */
        .description {
            font-size: 11px;
            color: #475569;
            line-height: 1.5;
            margin-bottom: 20px;
            text-align: justify;
        }

        /* Gallery */
        .gallery-table {
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 5px;
            margin-left: -5px;
        }

        .gallery-cell {
            width: 50%;
            height: 300px;
            vertical-align: top;
        }

        .gallery-img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            border-radius: 6px;
            display: block;
        }

        /* Features */
        .feature-pill {
            display: inline-block;
            background: #8046F1;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            margin: 0 5px 5px 0;
            border: 1px solid #8046F1;
        }

        .property-details-box {
            background-color: #475569;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .property-details-box .d-label {
            color: #cbd5e1;
            /* lighten text for label */
            font-weight: 600;
        }

        .property-details-box .d-val {
            color: white;
            font-weight: 700;
            text-align: right;
        }

        .property-details-box td {
            border-bottom: 1px solid #64748b;
        }

        /* Two Column Layout */
        .two-col-table {
            width: 100%;
            border-spacing: 15px;
            margin-left: -15px;
            margin-bottom: 20px;
        }

        .col-half {
            width: 50%;
            vertical-align: top;
        }

        .mortgage-box {
            background: #f0f9ff;
            border: 1px dashed #bae6fd;
            color: black;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }

        .mortgage-row {
            margin-bottom: 5px;
            font-size: 11px;
            overflow: hidden;
        }

        .m-val {
            float: right;
            font-weight: 700;
            color: black !important;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }

        .d-label {
            font-weight: 600;
            color: #64748b;
        }

        .d-val {
            font-weight: 700;
            color: #0f172a;
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            font-size: 9px;
            text-align: center;
            color: #94a3b8;
            padding: 20px 0;
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
        // ROBUST IMAGE HANDLER
        function getBase64Image($path)
        {
            if (!$path)
                return null;

            // If it's already a full URL
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

            $pathsToCheck = [
                public_path('storage/' . $path),
                storage_path('app/public/' . $path),
                public_path($path)
            ];

            foreach ($pathsToCheck as $fullPath) {
                $fullPath = str_replace('\\', '/', $fullPath);
                if (file_exists($fullPath)) {
                    $type = pathinfo($fullPath, PATHINFO_EXTENSION) ?: 'jpg';
                    try {
                        $data = @file_get_contents($fullPath);
                        if ($data !== false) {
                            return 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
            return null;
        }

        $heroImage = getBase64Image($listing->thumbnail);
        $contactAvatar = $contactPerson && $contactPerson->profile_photo_path ? getBase64Image($contactPerson->profile_photo_path) : null;
    @endphp

    <!-- HERO SECTION -->
    <div class="hero-section">
        @if($heroImage)
            <img src="{{ $heroImage }}" class="hero-img">
        @else
            <div
                style="width:100%; height:100%; background:#cbd5e1; text-align:center; line-height:380px; color:#64748b; font-weight:bold;">
                No Image</div>
        @endif

        <!-- Floating Contact Card (Logged in User) -->
        <div class="contact-card">
            <div class="clearfix">
                @if($contactAvatar)
                    <img src="{{ $contactAvatar }}" class="contact-avatar">
                @else
                    <div class="contact-avatar"
                        style="background:#3b82f6; color:white; text-align:center; line-height:50px; font-weight:800; font-size:18px;">
                        {{ substr($contactPerson->name ?? 'A', 0, 1) }}
                    </div>
                @endif
                <div class="contact-info">
                    <span
                        class="contact-name">{{ \Illuminate\Support\Str::limit($contactPerson->name ?? 'Agent', 18) }}</span>
                    <span class="contact-role">Property Consultant</span>
                </div>
            </div>
            <div class="contact-actions">
                <a href="https://wa.me/{{ $contactPerson->phone_number ?? '' }}" class="action-btn bg-wa">WhatsApp</a>
                <a href="mailto:{{ $contactPerson->email ?? '' }}" class="action-btn bg-email">Email</a>
                <a href="tel:{{ $contactPerson->phone_number ?? '' }}" class="action-btn bg-call">Call</a>
            </div>
        </div>
    </div>

    <!-- TITLE SECTION -->
    <div class="title-section">
        <div style="float:left; width: 70%;">
            <div class="property-title">{{ $listing->property_title }} <span
                    class="badge">{{ $listing->purpose }}</span></div>
            <div class="property-address">{{ $listing->address }}</div>
        </div>
        <div style="float:right; width: 30%; text-align:right; padding-top:5px;">
            <div class="property-price">£{{ number_format($listing->price) }}</div>
        </div>
        <div style="clear:both;"></div>
    </div>

    <table class="specs-grid">
        <tr>
            <td class="specs-cell"><span class="specs-label">Type</span><span
                    class="specs-value">{{ $listing->propertyType->title ?? 'Flat' }}</span></td>
            <td class="specs-cell"><span class="specs-label">Bedrooms</span><span
                    class="specs-value">{{ $listing->bedrooms ?? 0 }}</span></td>
            <td class="specs-cell"><span class="specs-label">Bathrooms</span><span
                    class="specs-value">{{ $listing->bathrooms ?? 0 }}</span></td>
            <td class="specs-cell"><span class="specs-label">Area</span><span
                    class="specs-value">{{ $listing->area_size ?? 0 }} sqft</span></td>
        </tr>
    </table>

    <div class="content-container">
        <div class="section-heading">Description</div>
        <div class="description">{{ \Illuminate\Support\Str::limit(strip_tags($listing->description ?? ''), 600) }}
        </div>

        @if(count($gallery) > 0)
            <div class="section-heading">Gallery</div>
            <table class="gallery-table">
                @foreach(array_chunk($gallery, 2) as $row)
                    <tr>
                        @foreach($row as $img)
                            @php $gVal = getBase64Image($img); @endphp
                            @if($gVal)
                                <td class="gallery-cell" style="padding-bottom: 10px;"><img src="{{ $gVal }}" class="gallery-img"></td>
                            @endif
                        @endforeach
                        @if(count($row) < 2)
                        <td class="gallery-cell"></td> @endif
                    </tr>
                @endforeach
            </table>
        @endif
    </div>

    <div class="page-break"></div>

    <div class="content-container" style="padding-top: 20px;">
        <table class="two-col-table">
            <tr>
                <td class="col-half">
                    <div class="property-details-box">
                        <div class="section-heading" style="color: white; border-color: rgba(255,255,255,0.2);">Property
                            Details</div>
                        <table class="details-table" style="border: none;">
                            <tr>
                                <td class="d-label">Reference</td>
                                <td class="d-val">{{ $listing->property_reference_number }}</td>
                            </tr>
                            <tr>
                                <td class="d-label">Completion</td>
                                <td class="d-val">{{ $listing->completion_status ?? 'Ready' }}</td>
                            </tr>
                            <tr>
                                <td class="d-label">Furnished</td>
                                <td class="d-val">{{ $listing->furnishing_status ?? 'No' }}</td>
                            </tr>
                            <tr>
                                <td class="d-label">Tenure</td>
                                <td class="d-val">{{ $listing->tenure ?? 'Freehold' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div style="margin-top:20px;">
                        <div class="section-heading">Features</div>
                        @foreach($listing->features as $feature)
                            <div class="feature-pill">{{ $feature->title }}</div>
                        @endforeach
                    </div>
                </td>

                <td class="col-half">
                    @php
                        // Defaults as requested
                        $mPrice = $listing->price;
                        $mDepositPercent = 40;
                        $mInterestRate = 3.5;
                        $mYears = 20;

                        // Calculations
                        $mDepositAmount = $mPrice * ($mDepositPercent / 100);
                        $mLoanAmount = $mPrice - $mDepositAmount;

                        $mMonthlyInterest = ($mInterestRate / 100) / 12;
                        $mMonths = $mYears * 12;

                        if ($mLoanAmount > 0) {
                            $mMonthlyPayment = ($mLoanAmount * $mMonthlyInterest * pow((1 + $mMonthlyInterest), $mMonths)) / (pow((1 + $mMonthlyInterest), $mMonths) - 1);
                        } else {
                            $mMonthlyPayment = 0;
                        }
                    @endphp

                    <div class="section-heading">Mortgage Calculator</div>
                    <style>
                        .mortgage-table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        .mortgage-table td {
                            padding: 4px 0;
                            color: #000000 !important;
                            font-size: 11px;
                        }

                        .mortgage-table .m-label {
                            text-align: left;
                        }

                        .mortgage-table .m-val {
                            text-align: right;
                            font-weight: 700;
                            color: #000000 !important;
                        }
                    </style>
                    <div class="mortgage-box">
                        <table class="mortgage-table">
                            <tr>
                                <td class="m-label">Estimated Monthly Payment</td>
                                <td class="m-val" style="font-size: 14px;">£{{ number_format($mMonthlyPayment, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="border-bottom: 1px dashed #bae6fd; height: 1px; padding: 0; margin: 5px 0;">
                                </td>
                            </tr>
                            <tr>
                                <td class="m-label">Total Amount (£)</td>
                                <td class="m-val">{{ number_format($mPrice, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="m-label">Down Payment (%)</td>
                                <td class="m-val">{{ number_format($mDepositPercent, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="m-label">Interest Rate (%)</td>
                                <td class="m-val">{{ number_format($mInterestRate, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="m-label">Loan Terms (Years)</td>
                                <td class="m-val">{{ $mYears }}</td>
                            </tr>
                            <tr>
                                <td class="m-label">Down Payment Amount:</td>
                                <td class="m-val">£{{ number_format($mDepositAmount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="m-label">Loan Amount:</td>
                                <td class="m-val">£{{ number_format($mLoanAmount, 2) }}</td>
                            </tr>
                        </table>
                    </div>

                    @if($mapImage)
                        <div class="section-heading" style="margin-top:20px;">Location</div>
                        <div
                            style="width:100%; height:150px; border-radius:6px; overflow:hidden; border:1px solid #e2e8f0;">
                            <img src="{{ $mapImage }}" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <!-- BOTTOM CONTACT SECTION -->
        <div
            style="margin-top: 40px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px;">
            <div class="clearfix">
                <div style="float:left; width: 55%;">
                    <h3 style="margin:0 0 5px 0; color:#0f172a; font-size:16px;">Interested in this property?</h3>
                    <p style="margin:0 0 15px 0; color:#64748b; font-size:11px;">Contact me today for more information
                        or a viewing.</p>
                    <div class="contact-actions" style="text-align: left; margin-top: 0;">
                        <a href="https://wa.me/{{ $contactPerson->phone_number ?? '' }}" class="action-btn bg-wa"
                            style="width:auto; padding: 6px 15px;">WhatsApp</a>
                        <a href="mailto:{{ $contactPerson->email ?? '' }}" class="action-btn bg-email"
                            style="width:auto; padding: 6px 15px;">Email Agent</a>
                        <a href="tel:{{ $contactPerson->phone_number ?? '' }}" class="action-btn bg-call"
                            style="width:auto; padding: 6px 15px;">Call Now</a>
                    </div>
                </div>
                <div style="float:right; width: 40%; text-align: right;">
                    @if($contactAvatar)
                        <img src="{{ $contactAvatar }}"
                            style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover; border: 2px solid #e2e8f0; vertical-align: middle;">
                    @else
                        <div
                            style="width:55px; height:55px; background:#3b82f6; color:white; border-radius:50%; display:inline-block; line-height:55px; font-weight:800; font-size:18px; text-align:center; vertical-align: middle;">
                            {{ substr($contactPerson->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                    <div style="display:inline-block; vertical-align: middle; text-align: left; margin-left: 10px;">
                        <div style="font-weight: 800; font-size: 14px; color: #0f172a;">
                            {{ $contactPerson->name ?? 'Agent' }}
                        </div>
                        <div style="font-size: 11px; color: #64748b;">Property Consultant</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">Generated on {{ date('d M Y') }} &bull; Private & Confidential</div>
    </div>
</body>

</html>