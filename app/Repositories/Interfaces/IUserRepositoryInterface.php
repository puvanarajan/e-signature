<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

/**
 * Interface IUserRepositoryInterface
 *
 * This interface defines the methods for the User repository.
 */
interface IUserRepositoryInterface
{
    /**
     * Find a user by email.
     *
     * @param string $email The email to search for.
     *
     * @return User|null The User model instance or null if not found.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Create an access token for a user by email.
     *
     * @param string $email The email to search for.
     *
     * @return string The created access token.
     */
    public function createAccessToken(string $email): string;
}
