<?php

namespace App\Http\Controllers\Confession;

use App\Exceptions\BadGatewayException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Services\Confession\PostService;
use App\Model\Comment;
use App\Model\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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

    public function getLists (Request $request) {

        $post = Post::with([
            'likes' => function ($q) {
                $q->join('users', 'user_like_post.user_id', '=', 'users.id')
                    ->select([
                        DB::raw('user_like_post.post_id post_id'),
                        DB::raw('users.email email'),
                        DB::raw('users.username username'),
                        DB::raw('user_like_post.created_at created_at'),
                        DB::raw('user_like_post.updated_at updated_at'),
                    ])
                    ->orderBy('user_like_post.created_at', 'asc');
            }
        ])->latest()->get();

        $comments = new Comment();

        $columns = [
            DB::raw('comments.id id'),
            DB::raw('comments.user_id user_id'),
            DB::raw('users.email email'),
            DB::raw('users.username username'),
            DB::raw('comments.content content'),
            DB::raw('comments.images images'),
            DB::raw('comments.created_at created_at'),
            DB::raw('comments.updated_at updated_at'),
        ];

        foreach ($post as $key => $value) {
            $post[$key]['comments'] = $comments->join('users', 'users.id', '=', 'comments.user_id')
                ->select($columns)
                ->where('post_id', $value['id'])->with([
                    'likes' => function ($q) {
                        $q->join('users', 'user_like_comment.user_id', '=', 'users.id')
                            ->select([
                                DB::raw('user_like_comment.comment_id comment_id'),
                                DB::raw('users.email email'),
                                DB::raw('users.username username'),
                                DB::raw('user_like_comment.created_at created_at'),
                                DB::raw('user_like_comment.updated_at updated_at'),
                            ])
                            ->orderBy('user_like_comment.created_at', 'asc');
                    }
                ])->get();
        }

        $returnParams = [
            'status'  => 200,
            'message'   => 'success',
            'data'  => $post
        ];

        return response()->json($returnParams, 200);
    }
}
