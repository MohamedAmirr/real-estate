<?php

use App\Http\Controllers\AdminSessionController;
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
