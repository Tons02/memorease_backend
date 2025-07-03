<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeceasedResource extends JsonResource
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
            'lot_id' => $this->lot_id,
            'lot' => [
                'id' => $this->lot->id,
                'lot_number' => $this->lot->lot_number,
            ],
            'full_name' => trim(collect([
                $this->fname,
                $this->mname,
                $this->lname,
                $this->suffix
            ])->filter()->implode(' ')),
            'fname' => $this->fname,
            'mname' => $this->mname,
            'lname' => $this->lname,
            'suffix' => $this->suffix,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'death_date' => $this->death_date,
            'death_certificate' => $this->death_certificate
                ? asset('storage/' . $this->death_certificate)
                : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
