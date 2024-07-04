<?php

namespace App\Listeners;

use App\Events\RegistrationVerificationEvent;
use App\Mail\RegistrationVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

/**
 * Class RegistrationVerificationListener
 *
 * This listener handles the registration verification process by sending a verification email.
 */
class RegistrationVerificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RegistrationVerificationEvent $event The event instance containing the user and email verification details.
     * @return void
     */
    public function handle(RegistrationVerificationEvent $event): void
    {
        $user = $event->user;
        $emailVerification = $event->emailVerification;

        Mail::to($user->email)
            ->send(new RegistrationVerificationMail($user, $emailVerification));
    }
}
