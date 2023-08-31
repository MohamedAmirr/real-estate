<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTransactionResource;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'message' => 'Success',
            'body' => UserResource::collection(User::all())
        ], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json([
            'message' => 'User has been deleted successfully'
        ], 200);
    }

    public function listPurchases(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'body' => TransactionResource::collection($user->transactions()->get()),
        ]);
    }
}
