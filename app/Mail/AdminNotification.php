<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $data;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param string $type
     * @param array $data
     * @param string|null $subject
     */
    public function __construct($type, $data, $subject = null)
    {
        $this->type = $type;
        $this->data = $data;
        $this->subject = $subject ?? $this->getDefaultSubject($type);
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->mailer('noreply')
            ->subject($this->subject)
            ->view('emails.admin-notification');
    }

    /**
     * Get default subject based on type.
     */
    protected function getDefaultSubject($type)
    {
        switch ($type) {
            case 'user_registered':
                return 'New User Registration';
            case 'document_uploaded':
                return 'New Document Verification Request';
            case 'listing_added':
                return 'New Property Listing Added';
            case 'affiliate_registered':
                return 'New Affiliate Program Registration';
            default:
                return 'Admin Notification';
        }
    }
}
