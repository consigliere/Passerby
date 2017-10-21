<?php

Route::group(['middleware' => 'web', 'prefix' => 'passerby', 'namespace' => 'App\\Components\Passerby\Http\Controllers'], function() {
    Route::get('/', 'PasserbyController@index');
});