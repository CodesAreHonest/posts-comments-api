<?php


namespace App\Http\Repositories;


use App\Exceptions\InternalServerErrorException;
use App\Model\Post;
use Illuminate\Database\QueryException;

class PostRepository
{
    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    /**
     * @param array $payload
     * @return boolean $outcomes
     * @throws InternalServerErrorException
     */
    public function createPost (array $payload) {

        try {
            $this->post->create($payload);
        }
        catch (QueryException $e) {
            throw new InternalServerErrorException(
                'Database Error', 'QueryException', $e->getMessage()
            );
        }

    }
}
