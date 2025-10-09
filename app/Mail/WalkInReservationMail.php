<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WalkInReservationMail extends Mailable
{
    use Queueable, SerializesModels;

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

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Walk-In Reservation Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'walk-in-reservation-mail',
            with: [
                'user' => $this->user,
                'reservation' => $this->reservation,
                'lot' => $this->lot,
                'tempPassword' => $this->tempPassword,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
