<?php

Route::group(['middleware' => 'web', 'prefix' => 'mobile', 'namespace' => 'Modules\Mobile\Http\Controllers'], function()
{
    Route::get('/', 'MobileController@index');
});
