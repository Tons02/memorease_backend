<?php

namespace App\Http\Resources;

use App\Traits\HandlesMediaUrls;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
{
    use HandlesMediaUrls;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lot_image' => $this->getMediaUrl($this->lot_image, 'lot'),
            'second_lot_image' => $this->getMediaUrl($this->second_lot_image, 'lot'),
            'third_lot_image' => $this->getMediaUrl($this->third_lot_image, 'lot'),
            'fourth_lot_image' => $this->getMediaUrl($this->fourth_lot_image, 'lot'),
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
