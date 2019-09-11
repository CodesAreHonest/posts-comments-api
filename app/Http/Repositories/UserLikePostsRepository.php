<?php


namespace App\Http\Repositories;


use App\Exceptions\InternalServerErrorException;
use App\Model\UserLikePosts;
use Illuminate\Database\QueryException;

class UserLikePostsRepository
{
    private $userLikePosts;

    public function __construct(UserLikePosts $userLikePosts) {
        $this->userLikePosts = $userLikePosts;
    }

    /**
     * @throws InternalServerErrorException
     */
    public function likePost (int $postId, int $userId) {

        $params = [
            'post_id'   => $postId,
            'user_id'   => $userId
        ];

        try {
            $this->userLikePosts->create($params);
        }
        catch (QueryException $e) {
            throw new InternalServerErrorException(
                'Database Error', 'QueryException', $e->getMessage()
            );
        }
    }
}