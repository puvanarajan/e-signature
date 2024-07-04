<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthenticationController
 *
 * This controller handles user authentication.
 */
class AuthenticationController extends Controller
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
     * Handle a login request.
     *
     * @param LoginRequest $loginRequest The request instance containing login credentials.
     * @return JsonResponse The JSON response with login result.
     */
    public function login(LoginRequest $loginRequest)
    {
        $response = $this->authService->login($loginRequest->get('email'), $loginRequest->get('password'));

        if ($response->status) {
            $token = $this->authService->createToken($loginRequest->get('email'));
            return $this->sendSuccessResponse(new LoginResource($token->data));
        } else {
            return $this->sendErrorResponse('',
                $response->message,
                JsonResponse::HTTP_BAD_REQUEST,
                $response->errorCode);
        }
    }
}
