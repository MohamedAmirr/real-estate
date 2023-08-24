<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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
