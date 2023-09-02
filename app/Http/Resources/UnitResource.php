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
        $data = collect($this->resource->toArray())->put('images', ImageResource::collection($this->resource->images));
        return [
            $data->except(['created_at', 'updated_at', 'deleted_at']),
        ];
    }
}
