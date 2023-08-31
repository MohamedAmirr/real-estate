<?php

namespace App\Http\Resources;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unitInfo = $this->getUnits($this->unit_id);
        return [
            'transaction_id' => $this->id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'unit_details' => UnitResource::collection($unitInfo),
        ];
    }

    private function getUnits($id)
    {
        return (Unit::where('id', $id)->get());
    }
}
