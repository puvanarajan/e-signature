<?php

namespace App\Mail;

use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Class RegistrationVerificationMail
 *
 * This mailable class handles the email sent for registration verification.
 */
class RegistrationVerificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private User $user;
    private EmailVerification $emailVerification;

    /**
     * Create a new message instance.
     *
     * @param User $user The user instance.
     * @param EmailVerification $emailVerification The email verification instance.
     */
    public function __construct(User $user, EmailVerification $emailVerification)
    {
        $this->user = $user;
        $this->emailVerification = $emailVerification;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Verification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.emailVerification',
            with: [
                'name' => $this->user->name,
                'tokenUrl' => route('api.v1.auth.auth.emailVerification', ['token' => $this->emailVerification->email_token])
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
