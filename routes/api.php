<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Auth\AuthController;
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

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout',  [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh',  [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me',  [AuthController::class, 'login'])->name('me');
    Route::post('signup',  [AuthController::class, 'signUp'])->name('signup');
});

Route::resource('posts', PostController::class)->except(['create','edit']);




