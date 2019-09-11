<?php


namespace App\Http\Services\Confession;


use App\Exceptions\InternalServerErrorException;
use App\Http\Repositories\PostRepository;
use App\Http\Repositories\UserLikePostsRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Storage\FileService;
use Illuminate\Http\Request;

class PostService extends BaseService
{
    private $fileService;
    private $diskName = 'posts';
    private $postRepository;
    private $userLikePostRepository;

    public function __construct(PostRepository $postRepository,
                                FileService $fileService,
                                UserLikePostsRepository $userLikePostRepository
    ){
        $this->fileService = $fileService;
        $this->postRepository = $postRepository;
        $this->userLikePostRepository = $userLikePostRepository;
    }

    /**
     * @param Request $request
     * @throws InternalServerErrorException
     * @return array
     */
    public function createPost ($request) {

        $processedContent = $this->processContent($request['content']);

        $imageArray = [];

        if ($request->file('first-image')) {
            $firstImage  = $request->file('first-image');
            $firstImageUrl = $this->fileService->storeFile($this->diskName, $firstImage);

            if ($firstImageUrl) {
                $imageArray['first-image'] = $firstImageUrl;
            }
        }

        if ($request->file('second-image')) {
            $secondImage  = $request->file('second-image');
            $secondImageUrl = $this->fileService->storeFile($this->diskName, $secondImage);

            if ($secondImageUrl) {
                $imageArray['second-image'] = $secondImageUrl;
            }
        }

        if ($request->file('third-image')) {
            $thirdImage  = $request->file('third-image');
            $thirdImageUrl = $this->fileService->storeFile($this->diskName, $thirdImage);

            if ($thirdImageUrl) {
                $imageArray['third-image'] = $thirdImageUrl;
            }
        }

        $payload = [
            'user_id'   => $request['user_sub'],
            'content'   => $processedContent,
            'images'    => json_encode($imageArray)
        ];

        $this->postRepository->createPost($payload);

        return [
            'status'    => 201,
            'message'   => 'Post created success',
        ];
    }

    /**
     * @params Request $request
     * @throws InternalServerErrorException
     */
    public function userLikePost ($request) {

        $postId = $request['post_id'];
        $userId = $request['user_sub'];

        $this->userLikePostRepository->likePost($postId, $userId);

        return [
            'status'    => 201,
            'message'   => 'Liked submitted on the post successfully.'
        ];
    }
}
