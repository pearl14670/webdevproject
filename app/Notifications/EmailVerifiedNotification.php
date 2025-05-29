<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifiedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name'))
            ->line('Thank you for verifying your email address.')
            ->line('You now have full access to all features.')
            ->action('Get Started', url('/dashboard'))
            ->line('If you have any questions, please contact our support team.');
    }
}