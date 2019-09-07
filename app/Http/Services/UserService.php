<?php


namespace App\Http\Services;


use App\Exceptions\ForbiddenException;
use App\Exceptions\InternalServerErrorException;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $userRepository;
    private $passportService;

    public function __construct(UserRepository $userRepository, PassportService $passportService) {
        $this->userRepository = $userRepository;
        $this->passportService = $passportService;
    }

    public function register ($request) {

        $payload = [
            'username'  => $request['username'],
            'email'     => $request['email'],
            'password'  => Hash::make($request['password']),
        ];

        $outcomes = $this->userRepository->createUser($payload);

        if (!$outcomes) {
            throw new InternalServerErrorException(
                'Fail to register accounts. '
            );
        }

        return [
            'status'    => 200,
            'message'   => 'success'
        ];
    }

    /**
     * @throws ForbiddenException
     */
    public function login ($request) {

        $email = $request['email'];
        $password = $request['password'];

        $this->userRepository->authenticate($email, $password);

        $clientId = $request['client_id'];
        $clientSecret = $request['client_secret'];
        $scope = $request->has('scope', '');

        $oauth = $this->passportService->getAccessAndRefreshToken(
            $clientId, $clientSecret, $email, $password, $scope
        );

        return [
            'status'    => 200,
            'message'   => 'success',
            'data'  => $oauth
        ];
    }


}
