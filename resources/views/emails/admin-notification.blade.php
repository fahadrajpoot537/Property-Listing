<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #eee;
        }

        .header {
            margin-bottom: 25px;
            border-bottom: 2px solid #8046F1;
            padding-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            color: #131B31;
        }

        .content {
            margin-bottom: 25px;
        }

        .info-item {
            margin-bottom: 12px;
        }

        .label {
            font-weight: bold;
            color: #718096;
            width: 140px;
            display: inline-block;
        }

        .value {
            color: #131B31;
        }

        .footer {
            font-size: 12px;
            color: #a0aec0;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>{{ $subject }}</h2>
        </div>
        <div class="content">
            @if($type === 'user_registered')
                <p>A new user has registered on the platform:</p>
                <div class="info-item"><span class="label">Name:</span> <span class="value">{{ $data['user']->name }}</span>
                </div>
                <div class="info-item"><span class="label">Email:</span> <span
                        class="value">{{ $data['user']->email }}</span></div>
                <div class="info-item"><span class="label">Role:</span> <span
                        class="value">{{ $data['role'] ?? 'N/A' }}</span></div>
            @elseif($type === 'document_uploaded')
                <p>A user has uploaded a new document for verification:</p>
                <div class="info-item"><span class="label">User:</span> <span class="value">{{ $data['user']->name }}
                        ({{ $data['user']->email }})</span></div>
                <div class="info-item"><span class="label">Doc Type:</span> <span
                        class="value">{{ $data['doc_type'] }}</span></div>
            @elseif($type === 'listing_added')
                <p>A new property listing has been added and is pending review:</p>
                <div class="info-item"><span class="label">Property:</span> <span
                        class="value">{{ $data['listing']->property_title }}</span></div>
                <div class="info-item"><span class="label">Reference:</span> <span
                        class="value">{{ $data['listing']->property_reference_number }}</span></div>
                <div class="info-item"><span class="label">Agent/User:</span> <span
                        class="value">{{ $data['user']->name }}</span></div>
                <div class="info-item"><span class="label">Type:</span> <span
                        class="value">{{ $data['listing_type'] }}</span></div>
            @elseif($type === 'affiliate_registered')
                <p>A new user has registered for the affiliate program:</p>
                <div class="info-item"><span class="label">Name:</span> <span class="value">{{ $data['user']->name }}</span>
                </div>
                <div class="info-item"><span class="label">Email:</span> <span
                        class="value">{{ $data['user']->email }}</span></div>
            @else
                <p>A new event has occurred that requires your attention.</p>
            @endif
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} PropertyFinda. All rights reserved.
        </div>
    </div>
</body>

</html>