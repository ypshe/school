<?php

Route::group(['middleware' =>'web','namespace' => 'Modules\Pc\Http\Controllers'], function()
{
    Route::get('/', 'IndexController@index');
    Route::get('/home', 'IndexController@index');
    //培训通告
    Route::get('/notice', 'NoticeController@index');
    Route::get('/notice/{id}', 'NoticeController@desc')->where('id','[0-9]+');
    //学时
    Route::get('/time/{cardId?}', 'StudyController@getStudyTime')->where('cardId','[0-9Xx]+');
    Route::get('/ajax/time/{pid}/{cardId}', 'StudyController@getTimeDesc')->where('pid','[0-9Xx]+')->where('cardId','[0-9Xx]+');
    //工作动态
    Route::get('/work', 'WorkController@index');
    Route::get('/work/{id}', 'WorkController@desc')->where('id','[0-9]+');
    //退出
    Route::get('/logout', 'IndexController@logout');
    //帮助中心
    Route::get('/help/{type}', 'HelpController@index')->where('type','[1234]{1}');
    //培训课程列表
//    Route::any('/study', 'StudyController@index');
    //单门专业培训课程列表
    Route::get('/study/{id?}', 'StudyController@index')->where('id','[0-9]+');
    //培训课程详情
    Route::get('/studyDesc/{id}', 'StudyController@desc')->where('id','[0-9]+');
    //设置登录才能看视频的中间件
    Route::group(['middleware' => 'auth'],function(){
        //用户是否完善个人信息中间件
        Route::group(['middleware' => 'video'],function() {
            //观看视频
            Route::get('/video/{vid}', 'StudyController@video')->where('vid', '[0-9]+');
            //观看课程的首个视频（课程页点击开始学习）
            Route::get('/videoFirst/{sid}', 'StudyController@videoFirst')->where('sid', '[0-9]+');
            //视频中题目弹出验证后错误题目操作
            Route::post('/ajax/userError', 'StudyController@userError');
            //视频学时计算
            Route::post('/ajax/userStudy', 'StudyController@userStudy');
        });
        //个人资料
        Route::get('/user', 'UserController@first');
        //用户个人中心
        Route::get('/user/index', 'UserController@index');
        //修改个人信息
        Route::post('/user/edit', 'UserController@edit');
        //错题库
        Route::get('/user/errorExam/{type?}', 'UserController@errorExam')->where('type','[2]{1}');
        //在线学习
        Route::get('/user/online_study', 'UserController@online_study');
        //在线考试
        Route::get('/user/online_exam','UserController@online_exam');
        //进入考试
        Route::get('/user/exam/{pid}','UserController@exam')->where('pid','[0-9]+');
        //提交试卷
        Route::post('/user/submitExam','UserController@submitExam');
        //查看试卷
        Route::get('/user/seeExam/{eid}','UserController@seeExam')->where('eid','[0-9]+');
        //在线练习
        Route::get('/user/online_test','UserController@online_test');
        //进入练习
        Route::get('/user/test/{pid}','UserController@test')->where('pid','[0-9]+');
        //提交练习
        Route::post('/user/submitTest','UserController@submitTest');
        //查看练习
        Route::get('/user/seeTest/{eid}','UserController@seeTest')->where('eid','[0-9]+');
        //提交留言
        Route::post('/user/addAsk', 'UserController@addAsk');
        //留言搜索
        Route::get('/user/ask/{search?}', 'UserController@ask');
        //修改密码
        Route::post('/user/updatePwd', 'UserController@updatePwd');
        //获取错题
        Route::get('/ajax/getExam/{type?}', 'UserController@getExam')->where('type','[2]{1}');
        //删除错题
        Route::get('/ajax/delExam', 'UserController@delExam');
        //错题详情
        Route::get('/ajax/askDesc/{id}', 'UserController@askDesc')->where('id','[0-9]+');
        //异常页面
        Route::get('/user/error', 'UserController@error');
        //教育档案
        Route::get('/user/archive/{search?}', 'UserController@archive');
        //考核情况
        Route::get('/user/res', 'UserController@res');
        //资料下载
        Route::get('/user/file', 'UserController@file');
        Route::get('/user/download/files/{filename}', 'UserController@downloadFile');
        //立即报名
        Route::get('/getStudy/{pid?}', 'getStudyController@index')->where('pid','[0-9]+');
        //确认报名
        Route::get('/getStudy/confirm/{pid}', 'getStudyController@confirm')->where('pid','[0-9]+');
        //删除错题
        Route::get('/ajax/delExam', 'UserController@delExam');
        //错题详情
    });

});
