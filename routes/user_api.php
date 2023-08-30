<?php

use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserAuth\UserRegisterController;
use App\Http\Controllers\UserAuth\UserSessionController;
use App\Http\Controllers\UserAuth\VerificationController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')->group(function () {
    Route::post('register', [UserRegisterController::class, 'store']);
    Route::post('login', [UserSessionController::class, 'login']);
    Route::post('logout', [UserSessionController::class, 'logout'])
        ->middleware(['auth:sanctum', 'ability:user']);

    Route::prefix('unit')->group(function () {
        Route::get('{unit}', [UnitController::class, 'show'])
            ->middleware(['auth:sanctum', 'ability:user']);
        Route::post('buy/{unit}', [UnitController::class, 'buy'])
            ->middleware(['auth:sanctum', 'ability:user']);
    });
});


