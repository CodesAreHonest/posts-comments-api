<?php

namespace App\Http\Controllers;

use App\Exceptions\UnprocessableEntityException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @throws UnprocessableEntityException
     */
    public function postCreateUser(Request $request) {

        $rules = [
            'username'  => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed'
        ];

        $this->validator($request->all(), $rules);
    }
}
