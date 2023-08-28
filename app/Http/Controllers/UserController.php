<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserTransactionResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(){
        return response()->json([
            'message'=>'Success',
            'body'=> UserResource::collection(User::all())
        ],200);
    }
    public function destroy(User $user){
        $user->delete();
        return response()->json([
            'message'=>'User has been deleted successfully'
        ],200);
    }

    public function listPurchases(User $user){
        return response()->json([
            'message'=>'success',
            'body'=> new UserTransactionResource($user),
        ]);
    }
}
