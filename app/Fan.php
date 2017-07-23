<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Fan extends BaseModel
{
    //
    public function fuser(){
        return $this->hasOne('App\User','id','fan_id');
    }
    public function suser(){
        return $this->hasOne('App\User','id','star_id');
    }
}
