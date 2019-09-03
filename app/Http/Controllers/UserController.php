<?php

namespace App\Http\Controllers;

use App\Exceptions\BadGatewayException;
use App\Exceptions\InternalServerErrorException;
use App\Exceptions\UnprocessableEntityException;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * @throws UnprocessableEntityException
     * @throws InternalServerErrorException
     * @throws BadGatewayException
     */
    public function postCreateUser(Request $request) {

        $rules = [
            'username'  => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed'
        ];

        $this->validator($request->all(), $rules);

        $response = $this->userService->createUserAccount($request);

        switch ($response['status']) {
            case 200:
                return response()->json($response, 200);
            default:
                throw new BadGatewayException();

        }


    }
}
