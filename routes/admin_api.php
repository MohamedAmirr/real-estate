<?php

use App\Http\Controllers\AdminAuth\AdminSessionController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;


Route::group([], function () {
    Route::post('login', [AdminSessionController::class, 'login']);
    Route::post('logout', [AdminSessionController::class, 'logout'])
        ->middleware(['auth:sanctum', 'ability:admin']);

    Route::prefix('unit')->middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::post('store', [UnitController::class, 'store']);
        Route::get('{unit}', [UnitController::class, 'show']);
        Route::delete('{unit}', [UnitController::class, 'delete']);
        Route::put('{unit}', [UnitController::class, 'update']);
    });

    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function () {
        Route::get('users', [UserController::class, 'show']);
        Route::delete('user/{user}', [UserController::class, 'destroy']);
    });

    Route::get('purchases/{user}', [TransactionController::class, 'listPurchases'])
        ->middleware(['auth:sanctum', 'ability:admin']);

    Route::get('units', [UnitController::class, 'filter'])
        ->middleware(['auth:sanctum', 'ability:admin']);
});


