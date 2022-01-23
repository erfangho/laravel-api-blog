<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
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


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh')->name('refresh');
    Route::get('me', 'App\Http\Controllers\AuthController@me')->name('me');
    Route::post('signup', 'App\Http\Controllers\AuthController@signUp')->name('signup');


});

Route::resource('posts', App\Http\Controllers\PostController::class)->except(['create','edit']);


