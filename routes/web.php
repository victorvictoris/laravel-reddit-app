<?php

use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('thread')->controller(ThreadController::class)->group(function () {
    Route::get('/', 'index')->name('thread.index');
    Route::get('/{thread}', 'show')->name('thread.show');
});
