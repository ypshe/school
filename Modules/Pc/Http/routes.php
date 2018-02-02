<?php

Route::group(['middleware' => 'web', 'prefix' => 'pc', 'namespace' => 'Modules\Pc\Http\Controllers'], function()
{
    Route::get('/', 'IndexController@index');
});
