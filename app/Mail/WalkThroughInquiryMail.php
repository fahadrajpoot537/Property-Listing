<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WalkThroughInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $listing;
    public $isOffMarket;

    /**
     * Create a new message instance.
     */
    public function __construct($inquiry, $listing, $isOffMarket = false)
    {
        $this->inquiry = $inquiry;
        $this->listing = $listing;
        $this->isOffMarket = $isOffMarket;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $title = $this->listing->property_title ?? 'Property';
        return $this->mailer('inquiries')
            ->subject('Virtual Tour Request: ' . $title)
            ->view('emails.walkthrough-inquiry');
    }
}
