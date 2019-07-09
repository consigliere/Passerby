<?php
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

/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 7/9/19 5:50 PM
 */

Route::group(['middleware' => 'api', 'prefix' => 'login', 'namespace' => '\App\Components\Passerby\Http\Controllers'], static function() {
    Route::post('/', 'AuthController@login')->middleware('http.accept', 'http.content-type');
    Route::post('/refresh', 'AuthController@refresh')->middleware('http.accept');
});
Route::group(['middleware' => 'auth:api', 'prefix' => '', 'namespace' => '\App\Components\Passerby\Http\Controllers'], static function() {
    Route::post('/logout', 'AuthController@logout')->middleware('http.accept');
});
