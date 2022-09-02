<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
});


Route::controller(UserController::class)->group(function () {
    Route::get('/me', 'show');
});
