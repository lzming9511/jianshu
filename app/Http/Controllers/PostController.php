<?php

namespace App\Http\Controllers;

use App\Comment;
use \App\Post;
use App\Zan;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /*
 Route::get('/posts/{post}','\App\Http\Controllers\PostController@show');
//创建文章
Route::get('/posts/create','\App\Http\Controllers\PostController@create');
Route::post('/posts','\App\Http\Controllers\PostController@store');
//编辑文章
Route::get('/posts/{post}/edit','\App\Http\Controllers\PostController@edit');
Route::put('/posts/{post}','\App\Http\Controllers\PostController@update');
//删除文章
Route::get('/posts/delete','\App\Http\Controllers\PostController@delete');
     *
     * */
    public function index(){
        $posts=Post::aviable()->orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(6);
        //dd($posts);
        $posts->load('user');
        //dd($posts);
        return view('post/index',compact('posts'));
    }

    public function show(Post $post){
        return view('post/show',compact('post'));
    }

    public function create(){
        return view('post/create');
    }

    public function store(){
        $this->validate(request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);

        $user_id=\Auth::id();
        $params=array_merge(request(['title','content']),compact('user_id'));
        $post=Post::create($params);
        return redirect('/posts');
    }

    public function edit(Post $post){

        return view('post/edit', compact('post'));
    }
    public function update(Post $post){
        $this->validate(request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);
        $this->authorize('update',$post);

        $user_id=\Auth::id();
        $params=array_merge(request(['title','content']),compact('user_id'));
        $post=Post::create($params);
        return redirect('/posts');
    }
    public function delete(Post $post){
        $this->authorize('delete',$post);
        $post->delete();
        return redirect('/posts');
    }

    public function comment(){
        $this->validate(request(),[
            'content'=>'required|string|min:10',
        ]);
        $user_id=\Auth::id();
        $params=array_merge(request(['content','post_id']),compact('user_id'));
        Comment::create($params);
        return back();

    }
    public  function zan(Post $post){
        //$user_id=\Auth::id();
        $params=[
            'user_id'=>\Auth::id(),
            'post_id'=>$post->id,
        ];
        //$post_id=$post->id;
        Zan::firstOrCreate($params);
        return back();
    }

    public function unzan(Post $post){
        $post->zan(\Auth::id())->delete();
        return back();
    }

    public function imageUpload(){
//        $path=$request->file('wangEditorH5File');//->move('image');
//        return ;
//        //$path = $request->file('wangEditorH5File')->storePublicly(md5(\Auth::id() . time()));
//        //return asset('storage/'. $path);
        $file = $_FILES['wangEditorH5File'];//得到传输的数据
        $upload_path = "image/"; //上传文件的存放路径
//开始移动文件到相应的文件夹
        if(move_uploaded_file($file['tmp_name'],$upload_path.$file['name'])){
            $path=$file['name'];
            return asset('/image/'. $path);
        }
        return 'upload error';
    }
}
