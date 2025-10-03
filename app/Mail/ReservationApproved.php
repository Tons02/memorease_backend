<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Models\Lot;

class ReservationApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reservation;
    public $lot;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation, Lot $lot)
    {
        $this->reservation = $reservation;
        $this->lot = $lot;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Approved - Lot #' . $this->lot->lot_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservation-approved',
            with: [
                'reservation' => $this->reservation,
                'lot' => $this->lot,
                'approvedDate' => $this->reservation->approved_date,
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
