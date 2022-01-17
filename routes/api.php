<?php

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


Route::get('/test', function (Request $request) {
    return "hello";
});


Route::prefix('posts')->group(function () {
    Route::get('/', [App\Http\Controllers\PostController::class, 'index']);
    Route::post('/create', [App\Http\Controllers\PostController::class, 'create']);
    Route::post('/edit/{post}', [App\Http\Controllers\PostController::class, 'edit']);
    Route::get('/delete/{post}',  [App\Http\Controllers\PostController::class, 'delete']);
    Route::get('/show/{post}', [App\Http\Controllers\PostController::class, 'show']);
});
