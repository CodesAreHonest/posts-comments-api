<?php

namespace App\Http\Controllers\Confession;

use App\Exceptions\BadGatewayException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Services\Confession\PostService;
use App\Model\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    /**
     * @throws UnprocessableEntityException
     * @throws BadGatewayException
     * @throws InternalServerErrorException
     */
    public function postCreatePost (Request $request) {

        $rules = [
            'content'   => 'required|string',
            'first-image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:3000',
            'second-image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:3000',
            'third-image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:3000',
        ];

        $this->validator($request->all(), $rules);

        $response = $this->postService->createPost($request);

        switch ($response['status']) {
            case 201:
                return response()->json($response, 201);
            default:
                throw new BadGatewayException();
        }
    }

    /**
     * @throws UnprocessableEntityException
     * @throws BadGatewayException
     * @throws InternalServerErrorException
     */
    public function postUserLikePost (Request $request) {

        $rules = [
            'post_id'   => 'required|exists:posts,id'
        ];

        $this->validator($request->all(), $rules);

        $response = $this->postService->userLikePost($request);

        switch ($response['status']) {
            case 201:
                return response()->json($response, 201);
            default:
                throw new BadGatewayException();
        }
    }

    public function getSample (Request $request) {
        $content = "{
  \"status\": 200,
  \"message\": \"success\",
  \"posts\": [
    {
      \"username\": \"yinghua\",
      \"created_at\": \"2019-09-21 12:00:00\",
      \"content\": \"Today is awesome\",
      \"image\": {
        \"first-image\": \"xxx.jpg\",
        \"second-image\": \"xxx.jpg\",
        \"third-image\": \"xxx.jpg\"
      },
      \"like\": {
        \"count\": 2,
        \"user\": [
          {
            \"username\": \"YinghuaChai\",
            \"firstName\": \"Chai\",
            \"lastName\": \"Yinghua\",
            \"created_at\": \"2019-09-21 12:00:00\"
          }
        ]
      },
      \"comment\": [
        {
          \"username\": \"yinghua\",
          \"created_at\": \"2019-09-21 12:00:00\",
          \"content\": \"Today is awesome too\",
          \"image\": {
            \"first-image\": \"xxx.jpg\"
          },
          \"like\": {
            \"count\": 2,
            \"user\": [
              {
                \"username\": \"YinghuaChai\",
                \"firstName\": \"Chai\",
                \"lastName\": \"Yinghua\",
                \"created_at\": \"2019-09-21 12:00:00\"
              }
            ]
          }
        }
      ]
    }
  ]
}";
        return response()->json (json_decode($content), 200);
    }

    public function getLists (Request $request) {

        $post = Post::with('comments')->with('likeComments')->get();

        $user = User::with('posts')->with('comments')
            ->with('likeComments')->with('likePosts')
            ->get();

        $onePost = Post::find(2);

        return response()->json($post, 200);


    }
}
