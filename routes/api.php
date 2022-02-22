<?php

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

Route::group([
    'middleware' => ['api', 'language'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('logout', 'Auth\AuthController@logout')->name('logout');
    Route::post('refresh', 'Auth\AuthController@refresh')->name('refresh');
    Route::post('me', 'Auth\AuthController@me')->name('me');
    Route::post('signup', 'Auth\AuthController@signUp')->name('signup');
});

Route::resource('posts', Post\PostController::class)->except(['create','edit'])->middleware('language');




