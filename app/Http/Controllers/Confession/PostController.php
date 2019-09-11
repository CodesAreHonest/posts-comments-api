<?php

namespace App\Http\Controllers\Confession;

use App\Exceptions\BadGatewayException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Services\Confession\PostService;
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
}
