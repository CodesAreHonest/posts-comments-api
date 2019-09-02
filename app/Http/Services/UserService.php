<?php


namespace App\Http\Services;


use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Crypt;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createUserAccount ($request) {

        $payload = [
            'username'  => $request['username'],
            'email'     => $request['email'],
            'password'  => Crypt::encrypt($request['username']),
        ];

        $outcomes = $this->userRepository->createUser($payload);


    }
}
