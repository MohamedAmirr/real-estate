<?php

use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\UnitController;
use App\Http\Controllers\UserAuth\UserRegisterController;
use App\Http\Controllers\UserAuth\UserSessionController;
use App\Http\Controllers\UserAuth\VerificationController;
use Illuminate\Support\Facades\Route;


Route::group([], function () {
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

    Route::get('units', [UnitController::class, 'filter'])
        ->middleware(['auth:sanctum', 'ability:user']);
    Route::get('purchases', [TransactionController::class, 'listPurchases'])
        ->middleware(['auth:sanctum', 'ability:user']);
    Route::get('purchased', [TransactionController::class, 'filterUserUnits'])
        ->middleware(['auth:sanctum', 'ability:user']);

});

