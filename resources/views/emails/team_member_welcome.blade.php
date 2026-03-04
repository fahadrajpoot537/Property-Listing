<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PropertyFinda</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
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
                                Welcome to the Team!
                            </h2>

                            <p style="margin: 0 0 30px 0; color: #64748b; font-size: 16px; line-height: 1.6;">
                                Hi <strong>{{ $user->name }}</strong>,
                                <br><br>
                                You have been added as a team member on the PropertyFinda Portal. Below are your login
                                credentials to access your dashboard.
                            </p>

                            <!-- Credentials Box -->
                            <div
                                style="background-color: #f1f5f9; border-radius: 16px; padding: 30px; margin-bottom: 30px; border-left: 4px solid #8046F1;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td
                                            style="padding-bottom: 12px; color: #94a3b8; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                            Your Access Details</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong
                                                style="color: #64748b; width: 80px; display: inline-block;">Email:</strong>
                                            <span style="color: #131B31; font-weight: 600;">{{ $user->email }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #334155; font-size: 15px;">
                                            <strong
                                                style="color: #64748b; width: 80px; display: inline-block;">Password:</strong>
                                            <span style="color: #131B31; font-weight: 600;">{{ $password }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $loginLink }}"
                                            style="display: inline-block; background-color: #8046F1; color: #ffffff; font-weight: 800; font-size: 14px; text-decoration: none; padding: 18px 36px; border-radius: 12px; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 4px 14px rgba(128, 70, 241, 0.25);">
                                            Login to Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p
                                style="margin: 30px 0 0 0; color: #94a3b8; font-size: 14px; line-height: 1.6; text-align: center;">
                                Please make sure to change your password after your first login for security purposes.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; text-align: center;">
                            <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                &copy; {{ date('Y') }} PropertyFinda. All rights reserved.
                                <br>
                                Making property sourcing simple and efficient.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>