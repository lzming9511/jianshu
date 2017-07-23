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

Route::get('/', function () {
    return view('welcome');
});


//用户
//用户注册
Route::get('/register','\App\Http\Controllers\RegisterController@index');
//注册行为
Route::post('/register','\App\Http\Controllers\RegisterController@register');
//登入页面
Route::get('/login','\App\Http\Controllers\LoginController@index');
//登入行为
Route::post('/login','\App\Http\Controllers\LoginController@login');
//登出行为
Route::get('/logout','\App\Http\Controllers\LoginController@logout');

Route::group(['middleware' => 'auth:web'], function(){

    Route::get('/user/me','\App\Http\Controllers\UserController@show');
    //个人设置页面
    Route::get('/user/me/setting','\App\Http\Controllers\UserController@setting');
    //个人设置操作
    Route::post('/user/me/setting\'','\App\Http\Controllers\UserController@settingStore');

    //创建文章
    Route::get('/posts/create','\App\Http\Controllers\PostController@create');
    Route::post('/posts','\App\Http\Controllers\PostController@store');
    //文章列表
    Route::get('/posts','\App\Http\Controllers\PostController@index');
    //文章详细
    Route::get('/posts/{post}','\App\Http\Controllers\PostController@show');
    //编辑文章
    Route::get('/posts/{post}/edit','\App\Http\Controllers\PostController@edit');
    Route::put('/posts/{post}','\App\Http\Controllers\PostController@update');
    //删除文章
    Route::get('/posts/delete/{post}','\App\Http\Controllers\PostController@delete');
    //文章评论
    Route::post('/posts/comment', '\App\Http\Controllers\PostController@comment');
    Route::get('/posts/{post}/zan', '\App\Http\Controllers\PostController@zan');
    Route::get('/posts/{post}/unzan', '\App\Http\Controllers\PostController@unzan');
    //图片上传
    Route::post('/posts/image/upload','\App\Http\Controllers\PostController@imageUpload');
    /*********************User*********************************/
        // 个人设置
        //Route::get('/user/me/setting', '\App\Http\Controllers\UserController@setting');
        //Route::post('/user/me/setting', '\App\Http\Controllers\UserController@settingStore');
    // 个人主页
    Route::get('/user/{user}', '\App\Http\Controllers\UserController@show');
    Route::post('/user/{user}/fan', '\App\Http\Controllers\UserController@fan');
    Route::post('/user/{user}/unfan', '\App\Http\Controllers\UserController@unfan');
    // 专题
    Route::get('/topic/{topic}', '\App\Http\Controllers\TopicController@show');
    Route::get('/topic/{topic}/submit', '\App\Http\Controllers\TopicController@submit');
    // 通知
    Route::get('/notices', '\App\Http\Controllers\NoticeController@index');
});


include_once("admin.php");