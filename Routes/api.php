<?php
/**
 * api.php
 * Created by rn on 10/22/2017 1:22 AM.
 */
Route::group(['middleware' => 'api', 'prefix' => '', 'namespace' => 'App\Components\Passerby\Http\Controllers\Auth'], function () {
    Route::post('/login', 'LoginController@login');
    Route::post('/login/refresh', 'LoginController@refresh');
});

Route::group(['middleware' => 'auth:api', 'prefix' => '', 'namespace' => 'App\Components\Passerby\Http\Controllers\Auth'], function () {
    Route::post('/logout', 'LoginController@logout');
});

Route::group(['middleware' => 'api', 'prefix' => 'passerby', 'namespace' => 'App\Components\Passerby\Http\Controllers'], function () {
    //
});

//Route::group(['middleware' => 'api', 'prefix' => 'passerby', 'namespace' => 'App\\Components\Passerby\Http\Controllers'], function() {
//    //
//});