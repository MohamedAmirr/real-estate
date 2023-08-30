<?php

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


Route::name('admin')->group(base_path('routes/admin_api.php'));
Route::name('user')->group(base_path('routes/user_api.php'));


Route::prefix('email')->group(function () {
    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])
        ->name('verification.verify');

    Route::get('email/resend', [VerificationController::class, 'resend'])
        ->name('verification.resend');
});
