<?php

namespace App\Http\Controllers;

class RegisterController extends Controller
{
    //
    /*
     //用户注册
Route::get('/register','\App\Http\Controllers\RegisterController@index');
//注册行为
Route::post('/register','\App\Http\Controllers\RegisterController@register');
     *  */
    public function index(){
        return view('register.index');
    }

    public  function register(){
        $res=request();
        $this->validate(request(),[
            'name' => 'required|min:3|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:5|confirmed',
        ]);
        $name=request('name');
        $email=request('email');
        $password=bcrypt(request('password'));
        $data=compact('name','email','password');

        $user = \App\User::create(compact('name', 'email', 'password'));
        return redirect('/login');
    }
}
