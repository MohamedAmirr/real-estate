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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'description' => $this->resource->description,
            'type' => $this->resource->type,
            'location' => $this->resource->location,
            'area' => $this->resource->area,
            'num_of_rooms' => $this->resource->num_of_rooms,
            'num_of_bathrooms' => $this->resource->num_of_bathrooms,
            'images' => ImageResource::collection($this->resource->images),
        ];
    }
}
