<?php
if (strpos(\Jenssegers\Agent\Facades\Agent::getUserAgent(), 'MicroMessenger') !== false){
    $middleware=['web','wechat.oauth:default,snsapi_userinfo'];
}else{
    $middleware=['web'];
}

Route::group(['middleware' =>$middleware, 'prefix' => 'wap', 'namespace' => 'Modules\Mobile\Http\Controllers'], function()
{
    Route::get('/login/wx', 'LoginController@wx');
    //登录页面
    Route::get('/login', 'LoginController@index');
    //注册页面
    Route::get('/register', 'RegisterController@index');

    Route::post('/register', 'RegisterController@add');

    //提交登录
    Route::post('/attemptLogin', 'LoginController@attemptLogin');
    //错误页面
    Route::get('/error', 'IndexController@error');

    Route::group(['middleware' => 'authWap'],function(){
        Route::get('/', 'IndexController@index');
        //搜索页面
        Route::get('/search', 'IndexController@search');
        //课程详情页
        //专业课程列表
        Route::get('/study/{type?}/{info?}', 'StudyController@index')->where('type','[12]{1}');
        //清空搜索历史
        Route::get('/delSearch', 'StudyController@delSearch');
        //课程详情页
        Route::get('/studyDesc/{id}', 'StudyController@studyDesc')->where('id','[0-9]+');
        //专业列表
        Route::get('/pro', 'StudyController@pro');
        //通过名单
        Route::get('/paste', 'getStudyController@paste');
        //培训通告
        Route::get('/notice', 'NoticeController@index');
        Route::get('/notice/{id}', 'NoticeController@desc')->where('id','[0-9]+');
        //帮助中心
        Route::get('/help/{type}', 'HelpController@index')->where('type','[1234]{1}');
        Route::get('/logout', 'LoginController@logout');

        //工作动态
        Route::get('/work', 'WorkController@index');
        Route::get('/work/{id}', 'WorkController@desc')->where('id','[0-9]+');
        //获取学时
        Route::get('/getStudyTime/{cardId?}', 'StudyController@getStudyTime')->where('cardId','[0-9]+');
        Route::group(['prefix'=>'user'],function() {
            //解除微信绑定
            Route::get('/loseWx', 'UserController@loseWx');
            //个人中心
            Route::get('/', 'UserController@index');
            //个人设置
            Route::get('/set', 'UserController@set');
            //个人资料
            Route::get('/index', 'UserController@first');
            //我要留言
            Route::get('/ask', 'UserController@ask');
            //修改密码
            Route::get('/changePwd', 'UserController@changePwd');
            //提交修改密码
            Route::post('/submitPwd', 'UserController@submitPwd');
            //资料库
            Route::get('/file', 'UserController@file');
            //在线学习
            Route::get('/online_study', 'UserController@online_study');
            //在线练习列表
            Route::get('/online_test', 'UserController@online_test');
            //练习历史
            Route::get('/test_history', 'UserController@test_history');
            //查看练习
            Route::get('/seeTest/{eid}', 'UserController@seeTest')->where('eid','[0-9]+');
            //在线练习试题
            Route::get('/test/{eid}', 'UserController@test')->where('eid','[0-9]+');
            //在线考试列表
            Route::get('/online_exam', 'UserController@online_exam');
            //考试历史
            Route::get('/exam_history', 'UserController@exam_history');
            //查看考试试卷
            Route::get('/seeExam/{eid}', 'UserController@seeExam')->where('eid','[0-9]+');
            //在线考试试题
            Route::get('/exam/{eid}', 'UserController@exam')->where('eid','[0-9]+');
            //教育档案
            Route::get('/archive', 'UserController@archive');
            //考核情况
            Route::get('/res', 'UserController@res');
            //错题库
            Route::get('/errorExam/{type？}', 'UserController@errorExam')->where('type','[12]{1}');
            Route::get('/delError/{type}/{id}', 'UserController@delErrorExam')->where('type','[12]{1}')->where('id','[0-9]+');
        });
        Route::group(['middleware' => 'video'],function() {
            //观看视频
            Route::get('/video/{vid}/{status?}', 'StudyController@video')->where('vid', '[0-9]+');
            //观看课程的首个视频（课程页点击开始学习）
            Route::get('/videoFirst/{sid}/{status?}', 'StudyController@videoFirst')->where('sid', '[0-9]+');
            //视频中题目弹出验证后错误题目操作
            Route::post('/ajax/userError', 'StudyController@userError');
            //视频学时计算
            Route::post('/ajax/userStudy', 'StudyController@userStudy');
        });
        //参加培训
        Route::get('/getStudy/{pid？}', 'getStudyController@index')->where('pid','[0-9]+');
        Route::get('/confirmStudy/{pid}', 'getStudyController@confirm')->where('pid','[0-9]+');
    });
});
//ajax加载
Route::group(['middleware' => $middleware,'namespace' => 'Modules\Mobile\Http\Controllers'],function(){
    Route::get('/ajax/wap/study', 'StudyController@ajaxGetStudy');
    Route::get('/ajax/wap/notice', 'NoticeController@ajaxGetData');
    Route::get('/ajax/wap/work', 'WorkController@ajaxGetData');
    Route::group(['middleware' => 'authWap'],function(){
        Route::post('/ajax/user/addAsk', 'UserController@ajaxAddAsk');
        Route::get('/ajax/wap/test', 'UserController@ajaxGetTest');
        Route::get('/ajax/wap/getError/{type}/{id}', 'UserController@ajaxGetError')->where('type','[12]{1}')->where('id','[0-9]+');
        //提交练习试卷
        Route::post('/ajax/wap/user/submitTest', 'UserController@submitTest');
        //提交考试试卷
        Route::post('/ajax/wap/user/submitExam', 'UserController@submitExam');
        //ajax修改头像
        Route::post('/ajax/wap/user/changPic', 'UserController@changPic');
        //ajax修改用户信息
        Route::post('/ajax/wap/user/changData', 'UserController@changData');

    });
});