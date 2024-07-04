<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepositoryInterface;

/**
 * Class UserRepository
 *
 * This class provides the implementation for the User repository.
 */
class UserRepository extends BaseRepository implements IUserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $user The User model instance.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Find a user by email.
     *
     * @param string $email The email to search for.
     *
     * @return User|null The User model instance or null if not found.
     */
    public function findByEmail(string $email): ?User
    {
        return $this->findByColumn('email', $email)
            ->first();
    }

    /**
     * Create an access token for a user by email.
     *
     * @param string $email The email to search for.
     *
     * @return string The created access token.
     */
    public function createAccessToken(string $email): string
    {
        $user = $this->findByEmail($email);
        $token = $user->createToken('accessToken')->accessToken;

        return $token;
    }
}
