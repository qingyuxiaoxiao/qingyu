<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
//后台登录路由
Route::get('/admin/login','admin\Account@login')->name('login');
Route::post('/admin/dologin','admin\Account@dologin');
//后台验证码路由
Route::get('/admin/account/captcha','admin\Account@captcha');
//获取初始密码
Route::get('/admin/account/mima','admin\Account@mima')->middleware('auth');

Route::namespace('admin')->middleware(['auth','rights'])->group(function (){
    //后台首页
    Route::get('/admin/home/index','Home@index');
    Route::get('/admin/home/welcome','Home@welcome');
    //管理员列表
    Route::get('/admin/admin/index','Admin@index');
    //管理员添加
    Route::get('/admin/admin/add','Admin@add');
    //执行管理添加
    Route::post('/admin/admin/save','Admin@save');
    //删除管理员
    Route::post('/admin/admin/del','Admin@del');
    Route::get('/admin/admin/edit/{id}','Admin@edit');
    Route::post('/admin/admin/update','Admin@update');
});

