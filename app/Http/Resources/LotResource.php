<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
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
            'lot_image' => $this->lot_image
                ? asset('storage/' . $this->lot_image)
                : null,
            'second_lot_image' => $this->second_lot_image
                ? asset('storage/' . $this->second_lot_image)
                : null,
            'third_lot_image' => $this->third_lot_image
                ? asset('storage/' . $this->third_lot_image)
                : null,
            'fourth_lot_image' => $this->fourth_lot_image
                ? asset('storage/' . $this->fourth_lot_image)
                : null,
            'lot_number' => $this->lot_number,
            'description' => $this->description,
            'coordinates' => $this->coordinates,

            'status' => $this->status,
            'reserved_until' => $this->reserved_until,
            'price' => $this->price,
            'downpayment_price' => $this->downpayment_price,
            'promo_price' => $this->promo_price,
            'promo_until' => $this->promo_until,
            'death_date' => $this->death_date,
            'is_land_mark' => $this->is_land_mark,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
