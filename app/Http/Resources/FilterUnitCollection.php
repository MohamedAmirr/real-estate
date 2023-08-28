<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FilterUnitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this->resource->total(),
            'current_page' => $this->resource->currentPage(),
            'perPage' => $this->resource->perPage(),
            'data' => $this->collection,
        ];
    }
}
