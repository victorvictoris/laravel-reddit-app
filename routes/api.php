<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ThreadController;
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

Route::middleware('redditRegistered')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/me', 'show');
    });

    Route::prefix('thread')->controller(ThreadController::class)->group(function () {
        Route::post('/store', 'store')->name('thread.store');
        Route::patch('/update/{thread}', 'update')->name('thread.update');
        Route::delete('/destroy/{thread}', 'destroy')->name('thread.destroy');
        Route::post('/publish/{thread}', 'publish')->name('thread.publish');
        Route::get('/{thread}', 'show')->name('thread.show');
    });

    Route::prefix('comment')->controller(CommentController::class)->group(function () {
        Route::post('/store', 'store')->name('comment.store');
        Route::patch('/update/{comment}', 'update')->name('comment.update');
        Route::delete('/destroy/{comment}', 'destroy')->name('comment.destroy');
        Route::post('/visibility/{comment}', 'setVisibility')->name('comment.visibility');
        Route::get('/{comment}', 'show')->name('comment.show');
    });
});
