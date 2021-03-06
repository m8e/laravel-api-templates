<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorAuthenticationWasDisabledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->profile->locale);

        $antiPhishingCode = $notifiable->profile->anti_phishing_code;
        $disableAccountToken = $notifiable->profile->email_token_disable_account;

        return (new MailMessage)
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email
            ])
            ->subject(__(':app_name - Two Factor Authentication Disabled', ['app_name' => config('app.name')]))
            ->greeting(__('Two Factor Authentication Disabled'))
            ->line(__('Your 2FA (Two Factor Authentication) was disabled.'));
    }
}
