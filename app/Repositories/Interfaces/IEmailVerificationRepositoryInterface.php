<?php

namespace App\Repositories\Interfaces;

use App\Models\EmailVerification;

/**
 * Interface IEmailVerificationRepositoryInterface
 *
 * This interface defines the methods for the EmailVerification repository.
 */
interface IEmailVerificationRepositoryInterface
{
    /**
     * Verify the email using the email token.
     *
     * @param EmailVerification $emailToken The email token model instance.
     *
     * @return mixed
     */
    public function verifyEmail(EmailVerification $emailToken);
}
