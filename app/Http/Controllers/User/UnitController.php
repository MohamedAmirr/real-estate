<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UnitResource;
use App\Models\Transaction;
use App\Models\Unit;
use App\Services\FilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function show(Unit $unit): JsonResponse
    {
        return response()->json([
            'unit' => new UnitResource($unit),
        ], 200);
    }

    public function filter(Request $request): JsonResponse
    {
        $filterService = new FilterService();
        return $filterService->filter($this->getFiltrationAttributes($request));
    }

    public function buy(Unit $unit): JsonResponse
    {
        if ($unit->is_sold) {
            return response()->json([
                'message' => 'Unit is sold out'
            ], 403);
        }

        $user = Auth::user();

        $price = $unit->price;

        $transaction = $this->createNewTransaction($unit->id, $user->id, $price);

        return response()->json([
            'message' => 'Success',
            'body' => new TransactionResource($transaction)
        ], 200);
    }

    private function createNewTransaction(int $unitId, int $userId, int $price): Transaction
    {
        return Transaction::create([
            'user_id' => $userId,
            'unit_id' => $unitId,
            'price' => $price
        ]);
    }
}
