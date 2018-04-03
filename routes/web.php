<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;

Route::get('/ajax/addr', 'HomeController@addr');

Route::get('/admin/checkExam/{id}/{type}', 'HomeController@checkExam')->where('id','[0-9]+')->where('type','[012]{1}');

Route::post('/admin/checkExams', 'HomeController@checkExams');

Route::prefix('storage/app/aetherupload')->group(function(Router $router){
    $router->get('/{path}','FileController@index')->where('path','.*');
});

Auth::routes();
