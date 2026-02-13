<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends BaseResetPassword
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->mailer('noreply')
            ->subject(\Illuminate\Support\Facades\Lang::get('Reset Password Notification'))
            ->line(\Illuminate\Support\Facades\Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(\Illuminate\Support\Facades\Lang::get('Reset Password'), url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line(\Illuminate\Support\Facades\Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(\Illuminate\Support\Facades\Lang::get('If you did not request a password reset, no further action is required.'));
    }
}
