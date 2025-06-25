<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDefaultCredentialsNotification extends Notification
{
    use Queueable;

    protected $password;

    /**
     * Create a new notification instance.
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */


    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');

        return (new MailMessage)
            ->subject('Your Account Credentials')
            ->greeting('Hello ' . $notifiable->fname)
            ->line('Your account has been created.')
            ->line('Username: ' . $notifiable->username)
            ->line('Password: ' . $this->password)
            ->action('Login Here', $frontendUrl . '/login')
            ->line('Please change your password after logging in.');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
