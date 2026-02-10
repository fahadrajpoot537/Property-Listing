<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MatchedPropertyNotification extends Mailable
{
    public $listing;
    public $inquiry;
    public $template;

    /**
     * Create a new message instance.
     */
    public function __construct($listing, $inquiry, $template = null)
    {
        $this->listing = $listing;
        $this->inquiry = $inquiry;
        $this->template = $template;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->template ? $this->template->subject : 'New Property Matched For You!';

        // Replace placeholders in subject
        $subject = str_replace('{property_title}', $this->listing->property_title, $subject);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if ($this->template) {
            $body = $this->template->body;
            $placeholders = [
                '{user_name}' => $this->inquiry->name,
                '{property_title}' => $this->listing->property_title,
                '{price}' => number_format($this->listing->price),
                '{bedrooms}' => $this->listing->bedrooms,
                '{bathrooms}' => $this->listing->bathrooms,
                '{area_size}' => $this->listing->area_size ?? 'N/A',
                '{address}' => $this->listing->address,
                '{property_url}' => route('listing.show', $this->listing->id),
                '{thumbnail_url}' => $this->listing->thumbnail ? url('storage/' . $this->listing->thumbnail) : url('assets/img/all-images/hero/1.jpg'),
                '{logo_url}' => url('logoor.png'),
                '{year}' => date('Y'),
            ];

            $body = str_replace(array_keys($placeholders), array_values($placeholders), $body);

            return new Content(
                htmlString: $body,
            );
        }

        return new Content(
            markdown: 'emails.matched-property',
            with: [
                'listing' => $this->listing,
                'inquiry' => $this->inquiry,
            ],
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
