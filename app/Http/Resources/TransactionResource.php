<?php

namespace App\Http\Resources;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    private function getUnits($id)
    {
        return (Unit::where('id', $id)->get());
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'TransactionID' => $this->id,
            'UnitDetails' => UnitResource::collection($this->getUnits($this->unit_id)),
        ];
    }
}