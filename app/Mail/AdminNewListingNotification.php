<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class AdminNewListingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $listing;
    public $isOffMarket;

    /**
     * Create a new message instance.
     */
    public function __construct($listing, $isOffMarket = false)
    {
        $this->listing = $listing;
        $this->isOffMarket = $isOffMarket;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.mailers.inquiries.from.address'), config('mail.mailers.inquiries.from.name')),
            subject: 'New Property Listing Added: ' . $this->listing->property_title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_new_listing_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
