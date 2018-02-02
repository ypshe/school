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
    $router->resource('exam', ExamController::class);

});

