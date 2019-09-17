<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id', 'content', 'images'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    public function comments() {
        return $this->hasMany('App\Model\Comment');
    }

    public function likes() {
        return $this->hasMany('App\Model\UserLikePosts');
    }

    public function users() {
        return $this->belongsTo('App\User', 'user_id');
    }
}