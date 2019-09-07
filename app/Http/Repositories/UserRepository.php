<?php


namespace App\Http\Repositories;


use App\Exceptions\ForbiddenException;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Create a new user with given payloads
     *
     * @param array $payload
     * @return boolean $outcomes
     */
    public function createUser (array $payload) {

        $outcomes = $this->user->create($payload);

        return $outcomes;
    }

    /**
     * Email and password authentication
     *
     * @param string $email
     * @param string $password
     *
     * @return Collection $existUser
     * @throws ForbiddenException
     */
    public function authenticate(string $email, string $password) {

        $existUser = $this->user->where('email', $email)
            ->firstOrFail();

        if (!$existUser) {
            throw new ForbiddenException('The given email address is invalid. ', 'InvalidEmailAddress');
        }


        $verifyPassword = Hash::check($password, $existUser['password']);

        if (!$verifyPassword) {
            throw new ForbiddenException('The given password is invalid. ', 'InvalidPassword');
        }

        return $existUser;
    }
}
