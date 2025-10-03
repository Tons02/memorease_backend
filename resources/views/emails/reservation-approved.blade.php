@component('mail::message')
# ✅ Reservation Approved!

Dear {{ $reservation->customer->name ?? $reservation->customer->first_name ?? 'Valued Customer' }},

Great news! Your reservation has been **approved**.

## Reservation Details:

**Reservation ID:** #{{ $reservation->id }}

**Lot Number:** {{ $lot->lot_number }}

**Status:** **APPROVED** ✅

Your lot has been reserved and marked as sold. Please proceed with the next steps as outlined in your agreement.

If you have any questions or need assistance, please don't hesitate to contact us.

Thank you for choosing us!

Best regards,
{{ config('app.name') }} Team

@endcomponent
