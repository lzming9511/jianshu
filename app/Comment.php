<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseModel
{
    //
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
        //第二个参数comment表的外键
        //第三个参数user表的主键
    }
    public function post(){
        return $this->belongsTo('App\User','post_id','id');
        //第二个参数comment表的外键
        //第三个参数post表的主键
    }
}
