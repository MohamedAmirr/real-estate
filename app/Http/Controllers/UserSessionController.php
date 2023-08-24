<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserSessionController extends Controller
{
    private function checkPassword($password): bool
    {
        return Hash::check(request()->password, $password);
    }
    public function login(UserLoginRequest $request){
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
        request()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'You are logged out'
        ], 200);
    }
}
