<?php

use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\UserSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['admin'],function (){
    Route::post('admin/login',[AdminSessionController::class,'login']);
    Route::post('admin/logout',[AdminSessionController::class,'logout'])
        ->middleware(['auth:sanctum','ability:admin']);
});

Route::group(['user'],function (){
    Route::post('register',[UserRegisterController::class,'store']);
    Route::post('login',[UserSessionController::class,'login']);
    Route::post('logout',[UserSessionController::class,'logout'])->middleware(['auth:sanctum','ability:user']);
});
