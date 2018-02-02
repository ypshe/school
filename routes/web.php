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

Route::get('/','HomeController@index');
Route::prefix('storage/uploads')->group(function(Router $router){
    $router->get('/video/{date}/{path}','FileController@index');
    $router->get('/images/{images}','FileController@index');
});
