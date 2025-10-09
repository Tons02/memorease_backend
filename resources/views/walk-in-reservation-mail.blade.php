@component('mail::message')
# Walk-In Reservation Confirmation

Hello {{ $user->fname }} {{ $user->lname }},

Your walk-in reservation has been successfully created and approved!

## Account Details
**Username:** {{ $user->username }}
**Password:** {{ $tempPassword }}
**Email:** {{ $user->email }}

Please keep your account credentials safe. We recommend changing your password after your first login.

## Reservation Details
**Reservation ID:** {{ $reservation->id }}
**Lot ID:** {{ $lot->id }}
**Total Down Payment:** ₱{{ number_format($reservation->total_downpayment_price, 2) }}
**Status:** {{ ucfirst($reservation->status) }}
**Reserved Date:** {{ $reservation->reserved_at->format('F d, Y h:i A') }}

## Lot Information
**Lot Number:** {{ $lot->lot_number ?? 'N/A' }}
**Price:** ₱{{ number_format($lot->price, 2) }}
**Total Down Payment:** ₱{{ number_format($reservation->total_downpayment_price, 2) }}

---

If you have any questions regarding your reservation, please don't hesitate to contact us.

Thank you for your business!

@endcomponent
