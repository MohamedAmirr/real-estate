<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class VerificationController extends Controller
{
    public function verify(Request $request){
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        $user = User::findOrFail($request->id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }
    public function resend(Request $request){
        $user = User::findOrFail($request->id);
        if ($user->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }

}
