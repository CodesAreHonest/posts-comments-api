<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLikePosts extends Model
{
    protected $table = 'user_like_post';

    protected $fillable = [
        'user_id', 'post_id'
    ];
}
