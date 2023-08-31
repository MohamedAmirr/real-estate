<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function listPurchases(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'body' => TransactionResource::collection($user->transactions()->get()),
        ]);
    }
}
