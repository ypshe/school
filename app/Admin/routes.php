<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();
Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/api/addr', 'HomeController@addr');
    $router->get('/api/section', 'HomeController@section');
    $router->get('/api/getStudy', 'HomeController@getStudy');
    $router->get('/api/getVideo', 'HomeController@getVideo');
    //学生管理
    $router->resource('student', UserController::class);
    //专业管理
    $router->resource('profession', ProfessionController::class);
    //课程管理
    $router->resource('study', StudyController::class);
    //视频管理
    $router->resource('video', VideoController::class);
    //视频中问题管理
    $router->resource('video', VideoController::class);
    //教师管理
    $router->resource('teacher', TeacherController::class);
    //题库管理
    //单选
    $router->resource('exam', ExamController::class);
    //多选
    $router->resource('exam_choose', Exam_chooseController::class);
    //多选
    $router->resource('judge', JudgeController::class);
    //通知公告管理
    $router->resource('notice', NoticeController::class);
    //工作动态管理
    $router->resource('work', WorkController::class);
    //广告位管理
    $router->resource('banner', BannerController::class);
    //留言管理
    $router->resource('ask', AskController::class);
    //资料管理
    $router->resource('file', FileController::class);
    Route::get('/download/files/{filename}', 'FileController@downloadFile');
    //学生成绩
    $router->resource('examLog', ExamLogController::class);
    //帮助中心
    $router->resource('help', HelpController::class);

});

