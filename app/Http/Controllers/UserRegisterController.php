<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserRegister extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        $attributes = $request->validated();

        $user = User::create($attributes);

        return response()->json([
            'message' => 'User Registered Successfully',
            'id' => $user->id
        ], 200);
    }
}
