<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            return response()->json(["message" => "Invalid/Expired url provided."], 401);
        }

        $user = User::findOrFail($request->id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'message' => "Email activated successfully"
        ]);
    }

    public function resend(Request $request): JsonResponse
    {
        $user = User::findOrFail($request->id);
        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["message" => "Email verification link sent on your email id"]);
    }

}
