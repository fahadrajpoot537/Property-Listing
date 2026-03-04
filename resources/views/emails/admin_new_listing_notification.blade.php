<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Property Listing Notification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;">
                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px 40px; background-color: #131B31;">
                            <img src="{{ $message->embed(public_path('logoor.png')) }}" alt="PropertyFinda" width="180" style="display: block; height: auto;">
                        </td>
                    </tr>

                    <!-- Decorative Border -->
                    <tr>
                        <td height="4" style="background: linear-gradient(to right, #8046F1, #131B31);"></td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 20px 0; color: #131B31; font-size: 24px; font-weight: 800; letter-spacing: -0.025em;">
                                New Property Added
                                @if($isOffMarket) <span style="background-color: #8046F1; color: #ffffff; font-size: 10px; padding: 4px 10px; border-radius: 6px; font-weight: bold; margin-left: 8px; vertical-align: middle; text-transform: uppercase;">Off-Market</span> @endif
                            </h2>
                            
                            <p style="margin: 0 0 30px 0; color: #64748b; font-size: 16px; line-height: 1.6;">
                                A new property listing has been submitted by <strong style="color: #1e293b;">{{ $listing->user->name }}</strong> ({{ $listing->user->email }}).
                            </p>

                            <!-- Listing Info Box -->
                            <div style="background-color: #f1f5f9; border-radius: 16px; padding: 30px; margin-bottom: 30px; border-left: 4px solid #131B31;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="padding-bottom: 12px; color: #94a3b8; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Listing Details</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong style="color: #64748b; width: 100px; display: inline-block;">Title:</strong> 
                                            <span style="color: #131B31; font-weight: 600;">{{ $listing->property_title }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong style="color: #64748b; width: 100px; display: inline-block;">Reference:</strong> 
                                            <span style="color: #131B31; font-weight: 600;">{{ $listing->property_reference_number }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong style="color: #64748b; width: 100px; display: inline-block;">Price:</strong> 
                                            <span style="color: #131B31; font-weight: 600;">{{ number_format($listing->price) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong style="color: #64748b; width: 100px; display: inline-block;">Location:</strong> 
                                            <span style="color: #131B31; font-weight: 600;">{{ $listing->display_address }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $isOffMarket ? route('admin.off-market-listings.show', $listing->id) : route('admin.listings.show', $listing->id) }}" 
                                           style="display: inline-block; background-color: #131B31; color: #ffffff; font-weight: 800; font-size: 14px; text-decoration: none; padding: 18px 36px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
                                            Review Listing
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
                                &copy; {{ date('Y') }} PropertyFinda. All rights reserved.
                                <br>
                                This is an automated administrative notification.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
