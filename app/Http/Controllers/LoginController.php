<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
//登入页面
Route::get('/login','\App\Http\Controllers\LoginController@index');
//登入行为
Route::post('/login','\App\Http\Controllers\LoginController@login');
//登出行为
Route::get('/logout','\App\Http\Controllers\LoginController@logout');
    */
    public function index(){
        return view('login.index');
    }
    public  function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:30',
            'is_remember' => '',
        ]);

        $user = request(['email', 'password']);
        $remember = boolval(request('is_remember'));
        if (true == \Auth::attempt($user, $remember)) {
            return redirect('/posts');
        }

        return \Redirect::back()->withErrors("用户名密码错误");

    }
    public  function logout(){
        \Auth::logout();
        return redirect('/login');
    }
}
