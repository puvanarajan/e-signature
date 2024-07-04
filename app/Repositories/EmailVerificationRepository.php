<?php

namespace App\Repositories;

use App\Models\EmailVerification;
use App\Repositories\Interfaces\IEmailVerificationRepositoryInterface;
use Carbon\Carbon;

/**
 * Class EmailVerificationRepository
 *
 * This class provides the implementation for the EmailVerification repository.
 */
class EmailVerificationRepository extends BaseRepository implements IEmailVerificationRepositoryInterface
{

    /**
     * EmailVerificationRepository constructor.
     *
     * @param EmailVerification $emailVerification The EmailVerification model instance.
     */
    public function __construct(EmailVerification $emailVerification)
    {
        $this->model = $emailVerification;
    }

    /**
     * Verify the email using the email token.
     *
     * @param EmailVerification $emailToken The email token model instance.
     *
     * @return mixed
     */
    public function verifyEmail(EmailVerification $emailToken)
    {
        return $emailToken->user()->update([
           'email_verified_at' => Carbon::now()
        ]);
    }
}
