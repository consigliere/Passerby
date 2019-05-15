<?php
/**
 * Copyright(c) 2019. All rights reserved.
 * Last modified 5/15/19 9:56 AM
 */

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
Route::group(['middleware' => 'api', 'prefix' => '', 'namespace' => '\App\Components\Passerby\Http\Controllers'], function() {
    Route::post('/authenticate', 'AuthController@login');
    Route::post('/login', 'AuthController@login');
    Route::post('/refresh', 'AuthController@refresh');
});
Route::group(['middleware' => 'auth:api', 'prefix' => '', 'namespace' => '\App\Components\Passerby\Http\Controllers'], function() {
    Route::post('/logout', 'AuthController@logout');
});
