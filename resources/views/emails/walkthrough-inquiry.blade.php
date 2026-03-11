<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PropertyFinda Virtual Tour Request</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Outfit', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px 40px; background-color: #131B31;">
                            <img src="{{ $message->embed(public_path('logoor.png')) }}" alt="PropertyFinda" width="180"
                                style="display: block; height: auto;">
                        </td>
                    </tr>

                    <!-- Decorative Border -->
                    <tr>
                        <td height="4" style="background: linear-gradient(to right, #8046F1, #131B31);"></td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2
                                style="margin: 0 0 20px 0; color: #131B31; font-size: 24px; font-weight: 800; letter-spacing: -0.025em;">
                                New Virtual Tour Request
                            </h2>

                            <p style="margin: 0 0 30px 0; color: #64748b; font-size: 16px; line-height: 1.6;">
                                You have received a new virtual tour request for your property:
                                <strong style="color: #1e293b;">{{ $listing->property_title }}</strong>
                                @if($isOffMarket) <span
                                    style="background-color: #8046F1; color: #ffffff; font-size: 10px; padding: 2px 8px; border-radius: 4px; font-weight: bold; margin-left: 5px; vertical-align: middle;">OFF-MARKET</span>
                                @endif
                            </p>

                            <!-- Inquiry Box -->
                            <div
                                style="background-color: #f1f5f9; border-radius: 16px; padding: 30px; margin-bottom: 30px; border-left: 4px solid #8046F1;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td
                                            style="padding-bottom: 12px; color: #94a3b8; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                            Prospect Details</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong
                                                style="color: #64748b; width: 100px; display: inline-block;">Name:</strong>
                                            {{ $inquiry['name'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong
                                                style="color: #64748b; width: 100px; display: inline-block;">Email:</strong>
                                            <a href="mailto:{{ $inquiry['email'] }}"
                                                style="color: #8046F1; text-decoration: none; font-weight: 600;">{{ $inquiry['email'] }}</a>
                                        </td>
                                    </tr>
                                    @if(!empty($inquiry['phone']))
                                        <tr>
                                            <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                                <strong
                                                    style="color: #64748b; width: 100px; display: inline-block;">Phone:</strong>
                                                {{ $inquiry['phone'] }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if(!empty($inquiry['preferred_time']))
                                        <tr>
                                            <td style="padding-bottom: 20px; color: #334155; font-size: 15px;">
                                                <strong style="color: #64748b; width: 100px; display: inline-block;">Pref.
                                                    Time:</strong> {{ $inquiry['preferred_time'] }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if(!empty($inquiry['message']))
                                        <tr>
                                            <td
                                                style="padding-top: 15px; border-top: 1px dashed #cbd5e1; color: #334155; font-size: 15px; line-height: 1.6; font-style: italic;">
                                                "{{ $inquiry['message'] }}"
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <!-- CTA -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/') }}"
                                            style="display: inline-block; background-color: #131B31; color: #ffffff; font-weight: 800; font-size: 14px; text-decoration: none; padding: 18px 36px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 4px 14px rgba(19, 27, 49, 0.25);">
                                            View in Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                This is an automated notification from <strong style="color: #131B31;">PropertyFinda
                                    Portal</strong>.
                                <br>
                                &copy; {{ date('Y') }} PropertyFinda. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>