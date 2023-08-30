<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
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
            'price' => $this->price,
            'description' => $this->description,
            'type' => $this->type,
            'location' => $this->location,
            'area' => $this->area,
            'num_of_rooms' => $this->num_of_rooms,
            'num_of_bathrooms' => $this->num_of_bathrooms,
            'images' => ImageResource::collection($this->images),
        ];
    }
}
