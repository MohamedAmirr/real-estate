<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilterUnitCollection;
use App\Http\Resources\FilterUserUnitCollection;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function listPurchases(): JsonResponse
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'success',
            'body' => TransactionResource::collection($user->transactions()->get()),
        ]);
    }

    public function filterUserUnits(Request $request): JsonResponse
    {
        $attributes = $this->getFiltrationAttributes($request);

        $units = Unit::whereHas('transaction', function ($q) {
            $q->where('user_id', Auth::user()->id);
        })->filter($attributes)->paginate();

        return response()->json([
            'message' => 'success',
            'body' => new FilterUserUnitCollection(
                $units
            )
        ], 200);
    }
}
