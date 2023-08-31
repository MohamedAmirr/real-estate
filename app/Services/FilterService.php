<?php

namespace App\Services;

use App\Http\Resources\FilterUnitCollection;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilterService
{
    public function filter(array $attributes): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'body' => new FilterUnitCollection(
                Unit::filter(
                    $attributes
                )->paginate()
            )
        ], 200);
    }
}
