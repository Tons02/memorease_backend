<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lot' => [
                'id' => $this->lot->id,
                'lot_number' => $this->lot->lot_number,
                'lot_image' => $this->lot->lot_image
                    ? asset('storage/' . $this->lot->lot_image)
                    : null,

            ],
            'customer' => [
                'id' => $this->customer->id,
                'fullname' => implode(' ', array_filter([
                    $this->customer->fname,
                    $this->customer->mi,
                    $this->customer->lname,
                    $this->customer->suffix,
                ])),
            ],
            'status' => $this->status,
            'total_downpayment_price' => $this->total_downpayment_price,
            'remarks' => $this->remarks,
            'reserved_at' => $this->reserved_at,
            'expires_at' => $this->expires_at,
            'proof_of_payment' => $this->proof_of_payment
                ? asset('storage/' . $this->proof_of_payment)
                : null,
            'paid_at' => $this->paid_at,
            'approved_date' => $this->approved_date,
            'approved_by' => $this->approved ? [
                'id' => $this->approved->id,
                'fullname' => implode(' ', array_filter([
                    $this->approved->fname,
                    $this->approved->mi,
                    $this->approved->lname,
                    $this->approved->suffix,
                ])),
            ] : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
