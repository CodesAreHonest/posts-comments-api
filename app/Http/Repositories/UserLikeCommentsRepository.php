<?php


namespace App\Http\Repositories;


use App\Exceptions\InternalServerErrorException;
use App\Model\UserLikeComments;
use Illuminate\Database\QueryException;

class UserLikeCommentsRepository
{
    private $userLikeComments;

    public function __construct(UserLikeComments $userLikeComments) {
        $this->userLikeComments = $userLikeComments;
    }

    /**
     * @param  int $commentId
     * @param  int $userId
     * @throws InternalServerErrorException
     */
    public function likeComment (int $commentId, int $userId) {

        $params = [
            'comment_id'   => $commentId,
            'user_id'       => $userId
        ];

        try {
            $this->userLikeComments->create($params);
        }
        catch (QueryException $e) {
            throw new InternalServerErrorException(
                'Database Error', 'QueryException', $e->getMessage()
            );
        }
    }
}