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
        return [
            'transaction_id' => $this->id,
            'user_id' => $this->user_id,
            //TODO
            'UnitDetails' => UnitResource::collection($this->getUnits($this->unit_id)),
            'unit_id' => $this->unit_id,
            'price' => $this->price,
        ];
    }

    private function getUnits($id)
    {
        return (Unit::where('id', $id)->get());
    }
}
