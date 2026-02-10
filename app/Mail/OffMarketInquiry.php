<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\OffMarketListing;

class OffMarketInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $listing;

    /**
     * Create a new message instance.
     */
    public function __construct($inquiry, OffMarketListing $listing)
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
            ->subject('New Off-Market Inquiry: ' . $this->listing->property_title)
            ->replyTo($this->inquiry['email'], $this->inquiry['name'])
            ->view('emails.off-market-inquiry');
    }
}
