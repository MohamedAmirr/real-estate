<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSessionController extends Controller
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !$this->checkPassword($user->password)) {
            return response()->json([
                'message' => 'login credentials not valid',
            ], 401);
        }

        return response()->json([
            'message' => 'Success',
            'token' => $user->createToken($user, ['user'])
        ], 200);
    }

    public function logout(): JsonResponse
    {
        $token = Auth::user()->currentAccessToken();
        $token->delete();

        return response()->json([
            'message' => 'You are logged out'
        ], 200);
    }
}
