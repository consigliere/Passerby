<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/passerby', function (Request $request) {
//    return $request->user();
//});

if (config('password.routes.api.active')) {
//    Route::group(['prefix' => 'api'], function() {
    Route::group(['prefix' => 'v1'], function () {
//            Route::group(['middleware' => 'auth:api', 'prefix' => '', 'namespace' => '\App\Components\Passerby\Http\Controllers'], function() {
//                Route::get('/intest', 'LoginController@inTests');
//                Route::get('/outest', 'LoginController@authTests');
//            });
    });

    Route::group(['middleware' => 'api', 'prefix' => 'login', 'namespace' => '\App\Components\Passerby\Http\Controllers'], function () {
        Route::post('/', 'LoginController@login');
        Route::post('/refresh', 'LoginController@refresh');
    });
    Route::group(['middleware' => 'auth:api', 'prefix' => '', 'namespace' => '\App\Components\Passerby\Http\Controllers'], function () {
        Route::post('/logout', 'LoginController@logout');
    });
//    });
}
