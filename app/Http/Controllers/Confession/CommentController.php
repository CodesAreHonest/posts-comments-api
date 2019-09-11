<?php

namespace App\Http\Controllers\Confession;

use App\Exceptions\BadGatewayException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Services\Confession\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    private $commentService;
    public function __construct(CommentService $commentService) {
        $this->commentService = $commentService;
    }

    /**
     * @throws UnprocessableEntityException
     * @throws InternalServerErrorException
     * @throws BadGatewayException
     */
    public function postCreateComment(Request $request) {

        $rules = [
            'post_id'   => 'required|exists:posts,id',
            'content'   => 'required|string',
            'image'     => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:3000',
        ];

        $this->validator($request->all(), $rules);

        $response = $this->commentService->createCommentOnPost($request);

        switch ($response['status']) {
            case 201:
                return response()->json($response, 201);
            default:
                throw new BadGatewayException();
        }
    }
}
