<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id', 'user_id', 'content', 'images'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    public function post() {
        return $this->belongsTo('App\Model\Post', 'post_id');
    }

    public function likes() {
        return $this->hasMany('App\Model\UserLikeComments');
    }
}