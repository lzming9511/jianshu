<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


//    public function stars(){
//        return $this->hasMany('App\Fan','star_id','id');
//        //Eloquent 会寻找Fan 模型的 Fan 字段 与  user的 id 字段的值相同的纪录。
//    }
//    public function fans(){
//        return $this->hasMany('App\Fan','fan_id','id');
//        //Eloquent 会寻找Fan 模型的 Fan_id 字段 与  user的 id 字段的值相同的纪录。
//    }
    public function fans()
    {
        return $this->hasMany(\App\Fan::class, 'star_id', 'id');
    }

    /*
     * 当前这个人是否被uid粉了
     */
    public function hasFan($uid)
    {
        return $this->fans()->where('fan_id', $uid)->count();
    }

    /*
     * 我粉的人
     */
    public function stars()
    {
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }
    public function posts(){
        return $this->hasMany('App\Post','user_id','id');
        //Eloquent 会寻找Post模型的 user_id 字段 与  user的 id 字段的值相同的纪录。
    }
//    /*
//     * 当前这个人是否被uid粉了
//     */
//    public function hasFan($uid)
//    {
//        $res=$this->fans();//->where('fan_id', $uid)->count();
//        return $res;
//
//    }
/* 我收到的通知
*/
    public function notices()
    {
        return $this->belongsToMany(\App\Notice::class, 'user_notice', 'user_id', 'notice_id')->withPivot(['user_id', 'notice_id']);
    }

    /*
     * 增加通知
     */
    public function addNotice($notice)
    {
        return $this->notices()->save($notice);
    }

    /*
     * 减少通知
     */
    public function deleteNotice($notice)
    {
        return $this->notices()->detach($notice);
    }




}
