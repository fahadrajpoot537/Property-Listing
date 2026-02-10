<!DOCTYPE html>
<html>

<head>
    <title>New Property Inquiry</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #131B31; border-bottom: 2px solid #8046F1; padding-bottom: 10px;">New Property Inquiry</h2>

        <p>You have received a new inquiry for your property: <strong>{{ $listing->property_title }}</strong></p>

        <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Name:</strong> {{ $inquiry['name'] }}</p>
            <p><strong>Email:</strong> {{ $inquiry['email'] }}</p>
            <p><strong>Message:</strong></p>
            <p style="white-space: pre-wrap;">{{ $inquiry['message'] }}</p>
        </div>

        <p>Property Link: <a href="{{ route('listing.show', $listing->id) }}" style="color: #8046F1;">View Property</a>
        </p>

        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777;">This email was sent from FindaUK Portal.</p>
    </div>
</body>

</html>