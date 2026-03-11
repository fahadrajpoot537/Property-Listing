<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $body = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exclusive Property Match</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body style="font-family: 'Outfit', 'Inter', Helvetica, Arial, sans-serif; background-color: #f6f9fc; color: #1a1f36; margin: 0; padding: 0; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 32px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04); border: 1px solid #edf2f7;">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #131B31; padding: 30px 40px; border-bottom: 4px solid #8046F1;">
                            <img src="{logo_url}" alt="PropertyFinda" style="height: 32px; width: auto; display: block;">
                        </td>
                    </tr>

                    <!-- Hero Section -->
                    <tr>
                        <td style="position: relative;">
                            <a href="{property_url}" style="text-decoration: none; display: block;">
                                <img src="{thumbnail_url}" alt="Property Image" style="width: 100%; height: 350px; object-fit: cover; display: block;">
                            </a>
                            <div style="padding: 40px 40px 30px 40px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td>
                                            <span style="background: rgba(128, 70, 241, 0.1); color: #8046F1; padding: 6px 16px; border-radius: 100px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">NEW LISTING ALERT</span>
                                            <h1 style="font-size: 32px; font-weight: 800; color: #131B31; margin: 15px 0 10px 0; letter-spacing: -0.02em; line-height: 1.2;">{property_title}</h1>
                                            <p style="font-size: 16px; color: #64748b; margin: 0 0 20px 0; font-weight: 500;">
                                                <img src="https://cdn-icons-png.flaticon.com/512/2838/2838912.png" width="16" style="vertical-align: middle; margin-right: 6px; opacity: 0.5;"> 
                                                {address}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Property Stats -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F9FAFB; border-radius: 24px; padding: 30px; border: 1px solid #f1f5f9;">
                                <tr>
                                    <td width="33.33%" align="center" style="border-right: 1px solid #e2e8f0;">
                                        <p style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin: 0 0 5px 0; letter-spacing: 0.05em;">Bedrooms</p>
                                        <p style="font-size: 20px; font-weight: 800; color: #131B31; margin: 0;">{bedrooms}</p>
                                    </td>
                                    <td width="33.33%" align="center" style="border-right: 1px solid #e2e8f0;">
                                        <p style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin: 0 0 5px 0; letter-spacing: 0.05em;">Bathrooms</p>
                                        <p style="font-size: 20px; font-weight: 800; color: #131B31; margin: 0;">{bathrooms}</p>
                                    </td>
                                    <td width="33.33%" align="center">
                                        <p style="font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin: 0 0 5px 0; letter-spacing: 0.05em;">Price</p>
                                        <p style="font-size: 20px; font-weight: 800; color: #8046F1; margin: 0;">£{price}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Personal Note & CTA -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <p style="font-size: 16px; line-height: 1.6; color: #475569; margin-bottom: 30px;">
                                Hello <strong>{user_name}</strong>, based on your recent property search, we thought you might be interested in this exclusive opportunity. It fits your requirements perfectly.
                            </p>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{property_url}" style="background: linear-gradient(135deg, #8046F1 0%, #6D28D9 100%); color: #ffffff; text-decoration: none; padding: 22px 45px; border-radius: 18px; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; display: inline-block; box-shadow: 0 15px 30px rgba(128, 70, 241, 0.3);">View Full Premium Details</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Trust Badge -->
                    <tr>
                        <td style="padding: 20px 40px; background-color: #F8FAFC; text-align: center;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/10629/10629607.png" width="24" style="opacity: 0.6; margin-bottom: 10px; display: block;">
                                        <p style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Verified Premium Listing • PropertyFinda Network</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 40px; text-align: center; background-color: #131B31; color: #ffffff;">
                            <img src="{logo_url}" alt="PropertyFinda" style="height: 20px; width: auto; opacity: 0.5; margin-bottom: 20px;">
                            <p style="font-size: 13px; color: #94a3b8; line-height: 1.7; margin: 0;">
                                © {year} PropertyFinda. All rights reserved.<br>
                                <strong>The Smart Way to Find Property in the UK.</strong>
                            </p>
                            <div style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 25px;">
                                <a href="#" style="color: #8046F1; text-decoration: none; font-size: 11px; font-weight: 700; text-transform: uppercase; margin: 0 15px;">Privacy Policy</a>
                                <a href="#" style="color: #8046F1; text-decoration: none; font-size: 11px; font-weight: 700; text-transform: uppercase; margin: 0 15px;">Support Center</a>
                                <a href="#" style="color: #8046F1; text-decoration: none; font-size: 11px; font-weight: 700; text-transform: uppercase; margin: 0 15px;">Unsubscribe</a>
                            </div>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 12px; color: #94a3b8; text-align: center; margin-top: 30px;">
                    This is an automated match notification based on your inquiry. 
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;

        EmailTemplate::updateOrCreate(
            ['type' => 'matched_property'],
            [
                'name' => 'Ultra-Modern Property Match Notification',
                'subject' => '✨ Exclusive Premium Match: {property_title} wait for you!',
                'body' => trim($body),
                'is_active' => true,
            ]
        );
    }
}
