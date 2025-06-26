<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CemeteryResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'profile_picture' => $this->profile_picture
                ? asset('storage/' . $this->profile_picture)
                : null,

            'coordinates' => $this->coordinates,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
