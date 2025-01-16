<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Retrieve a user by their ID.
     *
     * @param int $id The ID of the user to retrieve.
     * 
     * @return User|null The user instance if found, or null if not.
     */
    public function getUser(int $id): User
    {
        return User::find($id);
    }

    /**
     * Register a new user with the provided data.
     *
     * @param array $data The data for the new user (e.g., name, email, password).
     * @return User The created user instance.
     */
    public function register(array $data): User
    {
        return User::create($data);
    }
}
