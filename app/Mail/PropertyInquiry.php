<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Listing;

class PropertyInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $listing;

    /**
     * Create a new message instance.
     */
    public function __construct($inquiry, Listing $listing)
    {
        $this->inquiry = $inquiry;
        $this->listing = $listing;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->mailer('inquiries')
            ->subject('New Property Inquiry: ' . $this->listing->property_title)
            ->view('emails.property-inquiry');
    }
}
