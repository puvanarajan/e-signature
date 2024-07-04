<?php

namespace App\Mail;

use App\Models\SharedDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

/**
 * Class SharedDocumentMail
 *
 * This mailable class handles the email sent for sharing a document.
 */
class SharedDocumentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public SharedDocument $sharedDocument;

    /**
     * Create a new message instance.
     *
     * @param SharedDocument $sharedDocument The shared document instance.
     */
    public function __construct(SharedDocument $sharedDocument)
    {
        $this->sharedDocument = $sharedDocument;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Shared Document Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sharedDocument',
            with: [
                'name' => $this->sharedDocument->user->name,
                'documentOwner' => $this->sharedDocument->document->user->name,
                'documentName' => $this->sharedDocument->document->file_name
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
        $document = $this->sharedDocument->document;

        return [
            Attachment::fromPath(Storage::path($document->file_path))
                ->as($document->file_original_name)
                ->withMime('application/pdf'),
        ];
    }
}
