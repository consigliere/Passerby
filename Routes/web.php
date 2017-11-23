<?php
/**
 * web.php
 * Created by rn on 10/22/2017 1:23 AM.
 */

if (config('route.web')) {
    Route::group(['middleware' => 'web', 'prefix' => 'passerby', 'namespace' => 'App\\Components\Passerby\Http\Controllers'], function () {
        // Route::get('/', 'PasserbyController@index');
    });
}
