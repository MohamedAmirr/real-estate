<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
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
}
