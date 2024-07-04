<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\Auth\RegistrationResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class RegistrationController
 *
 * This controller handles user registration.
 */
class RegistrationController extends Controller
{
    /**
     * @var AuthService The authentication service instance.
     */
    private AuthService $authService;

    /**
     * Create a new controller instance.
     *
     * @param AuthService $authService The authentication service instance.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle a registration request.
     *
     * @param RegistrationRequest $registrationRequest The request instance containing registration data.
     * @return JsonResponse The JSON response with registration result.
     */
    public function register(RegistrationRequest $registrationRequest): JsonResponse
    {
        $response = $this->authService->registration($registrationRequest);
        $user = $response->data;
        return $this->sendSuccessResponse(new RegistrationResource($user));
    }
}
