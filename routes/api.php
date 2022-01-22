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


Route::get('/login', [App\Http\Controllers\AuthController::class],'login');


Route::prefix('posts')->group(function () {
    Route::get('/', [App\Http\Controllers\PostController::class, 'index']);
    Route::get('/{post}', [App\Http\Controllers\PostController::class, 'show']);
    Route::post('/', [App\Http\Controllers\PostController::class, 'create']);
    Route::put('/{post}', [App\Http\Controllers\PostController::class, 'edit']);
    Route::delete('/{post}',  [App\Http\Controllers\PostController::class, 'delete']);

});
