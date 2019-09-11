<?php


namespace App\Http\Repositories;


use App\Exceptions\InternalServerErrorException;
use App\Model\Comment;
use Illuminate\Database\QueryException;

class CommentRepository
{
    private $comment;

    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    /**
     * @param array $payload
     * @throws InternalServerErrorException
     */
    public function createComment (array $payload) {

        try {
            $this->comment->create($payload);
        }
        catch (QueryException $e) {
            throw new InternalServerErrorException(
                'Database Error', 'QueryException', $e->getMessage()
            );
        }
    }
}
