<?php


namespace App\Http\Repositories;


use App\User;

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
}
