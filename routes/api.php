<?php

use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\UserSessionController;
use App\Http\Controllers\VerificationController;
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


Route::group(['admin'], function () {
    Route::post('admin/login', [AdminSessionController::class, 'login']);
    Route::post('admin/logout', [AdminSessionController::class, 'logout'])
        ->middleware(['auth:sanctum', 'ability:admin']);
});

Route::group(['user'], function () {
    Route::post('register', [UserRegisterController::class, 'store']);
    Route::post('login', [UserSessionController::class, 'login']);
    Route::post('logout', [UserSessionController::class, 'logout'])
        ->middleware(['auth:sanctum', 'ability:user']);
});

Route::group(['user_email_verification'],function (){
    Route::get('email/verify/{id}', [VerificationController::class,'verify'])
        ->name('verification.verify');

    Route::get('email/resend', [VerificationController::class,'resend'])
        ->name('verification.resend');
});

Route::middleware(['auth:sanctum','ability:admin'])->group(function (){
    Route::post('unit/store',[UnitController::class,'store']);
    Route::get('unit/{unit}',[UnitController::class,'read']);
    Route::delete('unit/{unit}',[UnitController::class,'delete']);
    Route::put('unit/{unit}',[UnitController::class,'update']);
})->name('unit');

