<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id', 'content', 'images'
    ];

    public function comments() {
        return $this->hasMany('App\Model\Comment');
    }

    public function likePosts() {
        return $this->hasMany('App\Model\UserLikePosts');
    }

    public function likeComments() {
        return $this->hasManyThrough(
            'App\Model\UserLikeComments', 'App\Model\Comment',
            'post_id', 'comment_id','id', 'id'
        );
    }
}
