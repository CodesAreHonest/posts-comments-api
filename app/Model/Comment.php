<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'post_id', 'user_id', 'content', 'images'
    ];

    public function post() {
        return $this->belongsTo('App\Model\Post', 'post_id');
    }
}
