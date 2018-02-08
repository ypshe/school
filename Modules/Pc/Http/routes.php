<?php

Route::group(['middleware' =>'web','namespace' => 'Modules\Pc\Http\Controllers'], function()
{
    Route::get('/', 'IndexController@index');
    Route::get('/home', 'IndexController@index');
    //培训通告
    Route::get('/notice', 'NoticeController@index');
    Route::get('/notice/{id}', 'NoticeController@desc')->where('id','[0-9]+');
    //培训
    Route::any('/study', 'StudyController@index');
    Route::get('/study/{id}', 'StudyController@index')->where('id','[0-9]+');
    Route::get('/studyDesc/{id}', 'StudyController@desc')->where('id','[0-9]+');
    //设置登录才能看视频的中间件
    Route::group(['middleware' => 'auth'],function(){
        //用户是否完善个人信息中间件
        Route::group(['middleware' => 'video'],function() {
            Route::get('/video/{vid}', 'StudyController@video')->where('vid', '[0-9]+');
            Route::get('/videoFirst/{sid}', 'StudyController@videoFirst')->where('sid', '[0-9]+');
            //视频中题目弹出验证后错误题目操作
            Route::post('/ajax/userError', 'StudyController@userError');
            //视频学时计算
            Route::post('/ajax/userStudy', 'StudyController@userStudy');
        });
        //用户个人中心
        Route::get('/user', 'UserController@index');
        Route::post('/user/edit', 'UserController@edit');
        Route::post('/user/updatePwd', 'UserController@updatePwd');
    });
    //学时
    Route::get('/time', 'StudyController@getStudyTime');
    Route::get('/time/{cardId}', 'StudyController@getStudyTime')->where('cardId','[0-9Xx]+');
    //工作动态
    Route::get('/work', 'WorkController@index');
    Route::get('/work/{id}', 'WorkController@desc')->where('id','[0-9]+');
    Route::get('/logout', 'IndexController@logout');
    //帮助中心
    Route::get('/help/{type}', 'HelpController@index')->where('type','[1234]{1}');

});
