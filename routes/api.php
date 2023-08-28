<?php

use App\Http\Controllers\AdminSessionController;
use App\Http\Controllers\UserAuth\UserRegisterController;
use App\Http\Controllers\UserAuth\UserSessionController;
use App\Http\Controllers\UserAuth\VerificationController;
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


Route::prefix('admin')->group(function () {
    Route::post('login', [AdminSessionController::class, 'login']);
    Route::post('logout', [AdminSessionController::class, 'logout'])
        ->middleware(['auth:sanctum', 'ability:admin']);
});

Route::prefix('user')->group(function () {
    Route::post('register', [UserRegisterController::class, 'store']);
    Route::post('login', [UserSessionController::class, 'login']);
    Route::post('logout', [UserSessionController::class, 'logout'])->middleware(['auth:sanctum', 'ability:user']);
});

Route::prefix('email')->group(function () {
    Route::get('verify/{id}', [VerificationController::class, 'verify'])
        ->name('verification.verify');

    Route::get('resend', [VerificationController::class, 'resend'])
        ->name('verification.resend');
});

