<?php

namespace App\Events;

use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class RegistrationVerificationEvent
 *
 * This event is triggered when a user registers and needs email verification.
 */
class RegistrationVerificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User The user who has registered.
     */
    public User $user;

    /**
     * @var EmailVerification The email verification details.
     */
    public EmailVerification $emailVerification;

    /**
     * Create a new event instance.
     *
     * @param User $user The user who has registered.
     * @param EmailVerification $emailVerification The email verification details.
     */
    public function __construct(User $user, EmailVerification $emailVerification)
    {
        $this->user = $user;
        $this->emailVerification = $emailVerification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel> The channels to broadcast the event on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
