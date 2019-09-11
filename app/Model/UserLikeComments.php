<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLikeComments extends Model
{
    protected $table = 'user_like_comment';

    protected $fillable = [
        'user_id', 'comment_id'
    ];
}
