<?php

Route::group(['middleware' => 'web', 'namespace' => 'Modules\Pc\Http\Controllers'], function()
{
    Route::get('/', 'IndexController@index');
    //通告
    Route::get('/notice', 'NoticeController@index');
    Route::get('/notice/{id}', 'NoticeController@desc')->where('id','[0-9]+');
    //培训
    Route::get('/study', 'StudyController@index');
    Route::get('/study/{id}', 'StudyController@desc')->where('id','[0-9]+');
    //工作通知
    Route::get('/work', 'WorkController@index');
    Route::get('/work/{id}', 'WorkController@desc')->where('id','[0-9]+');

});
