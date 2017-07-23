<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    public function posts()
    {
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }
}
