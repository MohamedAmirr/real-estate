<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;

class UserRegisterController extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        $attributes = $request->validated();

        $user = User::create($attributes);

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'User Registered Successfully',
            'id' => $user->id
        ], 200);
    }
}
