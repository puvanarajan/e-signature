<?php

namespace App\Services\Auth;

use App\Classes\ServiceResponse;
use App\Enums\ErrorCode;
use App\Events\RegistrationVerificationEvent;
use App\Models\User;
use App\Repositories\EmailVerificationRepository;
use App\Services\Auth\Interfaces\IEmailVerificationServiceInterface;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\EmailVerificationRequest;

/**
 * Class EmailVerificationService
 *
 * This service handles the email verification-related operations.
 */
class EmailVerificationService extends BaseService implements IEmailVerificationServiceInterface
{
    private EmailVerificationRepository $emailVerificationRepository;

    /**
     * EmailVerificationService constructor.
     *
     * @param EmailVerificationRepository $emailVerificationRepository The email verification repository instance.
     */
    public function __construct(EmailVerificationRepository $emailVerificationRepository)
    {
        $this->emailVerificationRepository = $emailVerificationRepository;
    }

    /**
     * Generate an email verification token.
     *
     * @param User $user The user instance.
     * @return mixed The generated email token.
     */
    public function emailTokenGenerate(User $user)
    {
        $data = [
            'user_id' => $user->id,
            'email_token' => Str::random(100)
        ];
        $emailToken = $this->emailVerificationRepository->create($data);
        event(new RegistrationVerificationEvent($user, $emailToken));
        return $emailToken;
    }

    /**
     * Verify the email using the provided token.
     *
     * @param EmailVerificationRequest $emailVerificationRequest The email verification request instance.
     * @return ServiceResponse The service response.
     */
    public function verifyEmail(EmailVerificationRequest $emailVerificationRequest): ServiceResponse
    {
        $result = $this->emailVerificationRepository
            ->findByColumn('email_token', $emailVerificationRequest->get('token'));

        if (!$result->isEmpty()) {
            $emailToken = $result->first();

            if ($emailToken->user->email_verified_at) {
                return $this->prepareResult('',
                    false,
                    'Account already verified',
                    ErrorCode::ALREADY_VERIFIED->value);

            } else if (Carbon::now()->diffInHours($emailToken->created_at) > 24) {
                $this->emailVerificationRepository->deleteById($emailToken->id);
                return $this->prepareResult('',
                    false,
                    'The token already expired',
                    ErrorCode::TOKEN_EXPIRED->value);

            } else {

                $this->emailVerificationRepository->verifyEmail($emailToken);
                $this->emailVerificationRepository->deleteById($emailToken->id);
                return $this->prepareResult('',
                    true,
                    'The email address has been verified successfully');
            }
        } else {
            return $this->prepareResult('',
                false,
                'Invalid token',
                ErrorCode::INVALID_TOKEN->value);
        }
    }
}
