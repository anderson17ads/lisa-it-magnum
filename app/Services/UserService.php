<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    /**
     * @var UserRepository The repository responsible for user-related data operations.
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository The repository used for interacting with user data.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve a user by their ID.
     *
     * @param int $id The ID of the user to retrieve.
     * 
     * @return User The user instance corresponding to the given ID.
     */
    public function getUser(int $id): User
    {
        return $this->userRepository->getUser($id);
    }
    
    /**
     * Register a new user with the provided data.
     *
     * @param array $data The data for the new user (e.g., name, email, password).
     * 
     * @return User The created user instance.
     */
    public function register(array $data): User
    {
        return $this->userRepository->register($data);
    }
}
