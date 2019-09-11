<?php


namespace App\Http\Services\Confession;


use App\Exceptions\InternalServerErrorException;
use App\Http\Repositories\CommentRepository;
use App\Http\Repositories\UserLikeCommentsRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Storage\FileService;
use Illuminate\Http\Request;

class CommentService extends BaseService
{
    private $commentRepository;
    private $fileService;
    private $diskName = 'comments';
    private $userLikeCommentRepository;

    public function __construct(FileService $fileService,
                                CommentRepository $commentRepository,
                                UserLikeCommentsRepository $userLikeCommentRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->fileService = $fileService;
        $this->userLikeCommentRepository = $userLikeCommentRepository;
    }

    /**
     * @param Request $request
     * @throws InternalServerErrorException
     * @return array
     */
    public function createCommentOnPost ($request) {

        // strip HTML and trim content
        $processedContent = $this->processContent($request['content']);

        $fileImageUrl = [];

        if ($request->file('image')) {
            $firstImage  = $request->file('image');
            $firstImageUrl = $this->fileService->storeFile($this->diskName, $firstImage);
            $fileImageUrl['image']  = $firstImageUrl;
        }

        $payload = [
            'user_id'   => $request['user_sub'],
            'post_id'   => $request['post_id'],
            'content'   => $processedContent,
            'images'    => json_encode($fileImageUrl)
        ];

        $this->commentRepository->createComment($payload);

        return [
            'status'    => 201,
            'message'   => 'Comment created success. '
        ];
    }

    /**
     * @param Request $request
     * @return array
     * @throws InternalServerErrorException
     */
    public function userLikeComments ($request) {

        $commentId = $request['comment_id'];
        $userId = $request['user_sub'];

        $this->userLikeCommentRepository->likeComment($commentId, $userId);

        return [
            'status'    => 201,
            'message'   => 'Liked submitted on the comment successfully.'
        ];
    }

}
