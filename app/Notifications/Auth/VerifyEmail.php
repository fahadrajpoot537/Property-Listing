<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class VerifyEmail extends BaseVerifyEmail
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->mailer('noreply')
            ->subject(\Illuminate\Support\Facades\Lang::get('Verify Email Address'))
            ->line(\Illuminate\Support\Facades\Lang::get('Please click the button below to verify your email address.'))
            ->action(\Illuminate\Support\Facades\Lang::get('Verify Email Address'), $verificationUrl)
            ->line(\Illuminate\Support\Facades\Lang::get('If you did not create an account, no further action is required.'));
    }
}
