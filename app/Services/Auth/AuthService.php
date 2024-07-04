<?php

namespace App\Services\Auth;

use App\Classes\ServiceResponse;
use App\Enums\ErrorCode;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Repositories\UserRepository;
use App\Services\Auth\Interfaces\IAuthServiceInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 *
 * This service handles the authentication-related operations.
 */
class AuthService extends BaseService implements IAuthServiceInterface
{
    private UserRepository $userRepository;
    private EmailVerificationService $emailVerificationService;

    /**
     * AuthService constructor.
     *
     * @param UserRepository $userRepository The user repository instance.
     * @param EmailVerificationService $emailVerificationService The email verification service instance.
     */
    public function __construct(
        UserRepository           $userRepository,
        EmailVerificationService $emailVerificationService
    )
    {
        $this->userRepository = $userRepository;
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * Handle user registration.
     *
     * @param RegistrationRequest $registrationRequest The registration request instance.
     * @param bool $isSocialLogin Whether the registration is via social login.
     * @return ServiceResponse The service response.
     */
    public function registration(RegistrationRequest $registrationRequest, bool $isSocialLogin = false): ServiceResponse
    {
        $data = $registrationRequest->validated();
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);

        $this->emailVerificationService->emailTokenGenerate($user);

        return $this->prepareResult($user);
    }

    /**
     * Handle user login.
     *
     * @param string $username The username or email.
     * @param string $password The password.
     * @param bool $isSocialLogin Whether the login is via social login.
     * @return ServiceResponse The service response.
     */
    public function login($username, $password, bool $isSocialLogin = false): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($username);

        if (!$user) {
            return $this->prepareResult([],
                false,
                'User not found',
                ErrorCode::USER_NOT_FOUND->value);
        } else if ($user && $user->email_verified_at == null) {
            return $this->prepareResult([],
                false,
                'Unverified email address',
                ErrorCode::UNVERIFIED_EMAIL->value);
        } else if (!$user || !Hash::check($password, $user->password)) {
            return $this->prepareResult([],
                false,
                'Invalid username or password',
                ErrorCode::UNAUTHORIZED->value);
        } else {
            return $this->prepareResult($user,
                true,
                'Success');
        }
    }

    /**
     * Create an access token for the user.
     *
     * @param string $email The user's email.
     * @return ServiceResponse The service response with the token.
     */
    public function createToken(string $email): ServiceResponse
    {
        $token = $this->userRepository->createAccessToken($email);
        $user = $this->userRepository->findByEmail($email);

        return $this->prepareResult([
            'token' => $token,
            'user' => $user,
        ],
            true,
            'Success');
    }
}
