<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Http\JsonResponse;

/**
 * Class VerificationController
 *
 * This controller handles email verification.
 */
class VerificationController extends Controller
{
    /**
     * @var EmailVerificationService The email verification service instance.
     */
    private EmailVerificationService $emailVerificationService;

    /**
     * Create a new controller instance.
     *
     * @param EmailVerificationService $emailVerificationService The email verification service instance.
     */
    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * Handle an email verification request.
     *
     * @param EmailVerificationRequest $emailVerificationRequest The request instance containing email verification data.
     * @return JsonResponse The JSON response with verification result.
     */
    public function emailVerification(EmailVerificationRequest $emailVerificationRequest)
    {
        $verification = $this->emailVerificationService->verifyEmail($emailVerificationRequest);

        return $this->sendJsonResponse($verification->data, $verification->status, $verification->message);
    }
}
