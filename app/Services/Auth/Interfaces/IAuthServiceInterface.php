<?php

namespace App\Services\Auth\Interfaces;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Classes\ServiceResponse;

/**
 * Interface IAuthServiceInterface
 *
 * This interface defines the methods for the authentication service.
 */
interface IAuthServiceInterface
{
    /**
     * Handle user registration.
     *
     * @param RegistrationRequest $registrationRequest The registration request instance.
     * @return ServiceResponse The service response.
     */
    public function registration(RegistrationRequest $registrationRequest): ServiceResponse;

    /**
     * Handle user login.
     *
     * @param string $username The username or email.
     * @param string $password The password.
     * @param bool $isSocialLogin Whether the login is via social login.
     * @return ServiceResponse The service response.
     */
    public function login(string $username, string $password, bool $isSocialLogin = false): ServiceResponse;

    /**
     * Create an access token for the user.
     *
     * @param string $email The user's email.
     * @return ServiceResponse The service response with the token.
     */
    public function createToken(string $email): ServiceResponse;
}
