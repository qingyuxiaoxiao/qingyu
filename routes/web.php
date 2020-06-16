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
Route::get('/admin/logout','admin\Account@logout');
//后台验证码路由
Route::get('/admin/account/captcha','admin\Account@captcha');
//获取初始密码
Route::get('/admin/account/mima','admin\Account@mima')->middleware('auth');

Route::namespace('admin')->middleware(['auth','rights'])->group(function (){
    //后台首页
    Route::get('/admin/home/index','Home@index');
    Route::get('/admin/home/welcome','Home@welcome');
    //管理员路由组
    Route::get('/admin/admin/index','Admin@index');
    Route::get('/admin/admin/add','Admin@add');
    Route::post('/admin/admin/save','Admin@save');
    Route::get('/admin/admin/edit','Admin@edit');
    Route::post('/admin/admin/del','Admin@del');
    //菜单路由组
    Route::get('/admin/menus/index','Menus@index');
    Route::get('/admin/menus/add','Menus@add');
    Route::get('/admin/menus/edit','Menus@edit');
    Route::post('/admin/menus/save','Menus@save');
    Route::post('/admin/menus/del','Menus@del');
    //角色路由组
    Route::get('/admin/groups/index','Groups@index');
    Route::get('/admin/groups/add','Groups@add');
    Route::post('/admin/groups/save','Groups@save');
    Route::post('/admin/groups/del','Groups@del');

    //站点设置
    Route::get('/admin/setting/index','Setting@index');
    Route::post('/admin/setting/save','Setting@save');
});

