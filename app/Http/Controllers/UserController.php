<?php

namespace App\Http\Controllers;


use App\User;

class UserController extends Controller
{
    public function show(User $user){
        // 这个人的文章
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
        // 这个人的关注／粉丝／文章
        $user = User::withCount(['stars', 'fans', 'posts'])->find($user->id);

        $fans = $user->fans()->get();
        $stars = $user->stars()->get();

        $fusers=User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();



        $susers=User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();


        return view("user/show", compact('user', 'posts', 'fans', 'stars','fusers','susers'));
//        $user=User::withCount(['stars','fans','posts'])->find($user->id);
//        $posts=$user->posts()->orderBy('created_at','desc')->take(10)->get();
//
//        $stars=$user->stars();
//        $res=$stars->pluck('star_id');
//        $suers=User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();
//
//        $fans=$user->fans;
//        $suers=User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();
//
//        return view('user.show',compact('user','posts','susers','fusers'));
    }

    public function fan(User $user)
    {
        $me = \Auth::user();
        \App\Fan::firstOrCreate(['fan_id' => $me->id,'star_id'=>$user->id]);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    public function unfan(User $user)
    {
        $me = \Auth::user();
        \App\Fan::where('fan_id', $me->id)->where('star_id', $user->id)->delete();
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
