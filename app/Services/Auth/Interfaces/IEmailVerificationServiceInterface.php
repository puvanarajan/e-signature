<?php

namespace App\Services\Auth\Interfaces;

use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Classes\ServiceResponse;

/**
 * Interface IEmailVerificationServiceInterface
 *
 * This interface defines the methods for the email verification service.
 */
interface IEmailVerificationServiceInterface
{
    /**
     * Verify the email using the provided token.
     *
     * @param EmailVerificationRequest $emailVerificationRequest The email verification request instance.
     * @return ServiceResponse The service response.
     */
    public function verifyEmail(EmailVerificationRequest $emailVerificationRequest): ServiceResponse;
}
