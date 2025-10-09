<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WalkInReservationNotification extends Notification
{
    use Queueable;

    public $user;
    public $reservation;
    public $lot;
    public $tempPassword;

    public function __construct($user, $reservation, $lot, $tempPassword)
    {
        $this->user = $user;
        $this->reservation = $reservation;
        $this->lot = $lot;
        $this->tempPassword = $tempPassword;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Walk-In Reservation Confirmation')
            ->greeting('Hello ' . $this->user->fname . ' ' . $this->user->lname . ',')
            ->line('Your walk-in reservation has been successfully created and approved!')
            ->line('')
            ->line('**Account Details**')
            ->line('Username: ' . $this->user->username)
            ->line('Password: ' . $this->tempPassword)
            ->line('Email: ' . $this->user->email)
            ->line('')
            ->line('Please keep your account credentials safe. We recommend changing your password after your first login.')
            ->line('')
            ->line('**Reservation Details**')
            ->line('Reservation ID: ' . $this->reservation->id)
            ->line('Lot ID: ' . $this->lot->id)
            ->line('Total Down Payment: ₱' . number_format($this->reservation->total_downpayment_price, 2))
            ->line('Status: ' . ucfirst($this->reservation->status))
            ->line('Reserved Date: ' . $this->reservation->reserved_at->format('F d, Y h:i A'))
            ->line('')
            ->line('**Lot Information**')
            ->line('Lot Number: ' . ($this->lot->lot_number ?? 'N/A'))
            ->line('Location: ' . ($this->lot->location ?? 'N/A'))
            ->line('Price: ₱' . number_format($this->lot->price, 2))
            ->line('')
            ->line('If you have any questions regarding your reservation, please don\'t hesitate to contact us.')
            ->line('')
            ->salutation('Thank you for your business!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'lot_id' => $this->lot->id,
            'user_id' => $this->user->id,
            'title' => 'Walk-In Reservation Confirmation',
            'message' => 'Your reservation for Lot #' . $this->lot->lot_number . ' has been approved.',
            'type' => 'reservation',
        ];
    }
}
