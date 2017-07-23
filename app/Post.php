<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Post extends BaseModel
{
    /*
 $has~
1、外键保存在关联表中；
2、保存时自动更新关联表的记录；
3、删除主表记录时自动删除关联记录。
$belongsTo
1、外键放置在主表中；
2、保存时不会自动更新关联表的记录；
3、删除时也不会更新关联表的记录。
     * */

    //关联用户
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
        //Post 模型的 user_id 至 User 模型的 id
        //第二个参数post表的外键
        //第三个参数user的主键
    }
    public function comments(){
        return $this->hasMany('App\Comment','post_id','id')->orderBy('created_at','desc');
        //Eloquent 会寻找comments 模型的 post_id 字段 与  POST的 id 字段的值相同的纪录。
        //第二个参数comment表的外键post_id
        //第三个参数Post表的主键id
    }
    //和用户进行关联
    public function zan($user_id)
    {
        return $this->hasOne('App\Zan','post_id','id');
        //Eloquent 会寻找zan 模型的 post_id 字段 与  POST的 id 字段的值相同的纪录。
    }

    public function zans(){
        //Eloquent 会寻找zan 模型的 post_id 字段 与  POST的 id 字段的值相同的纪录。
        return $this->hasMany('App\Zan');
    }
    /*
     * 一篇文章有哪些主题
     */
    public function topics()
    {
        return $this->belongsToMany(\App\Topic::class, 'post_topics', 'post_id', 'topic_id')->withPivot(['topic_id', 'post_id']);
    }

    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'post_id');
    }

    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function($q) use ($topic_id) {
            $q->where("topic_id", $topic_id);
        });
    }


    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
    /*
     * 可以显示的文章
     */
    public function scopeAviable($query)
    {
        return $query->whereIn('status', [0, 1]);
    }

}
