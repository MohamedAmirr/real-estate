<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AdminSessionController extends Controller
{

    private function checkPassword($password): bool
    {
        return Hash::check(request()->password, $password);
    }

    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !$this->checkPassword($admin->password)) {
            return response()->json([
                'message' => 'login credentials not valid',
            ], 401);
        }

        return response()->json([
            'message' => 'Success',
            'token' => $admin->createToken($admin, ['admin'])
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
