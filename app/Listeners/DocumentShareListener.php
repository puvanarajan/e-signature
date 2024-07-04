<?php

namespace App\Listeners;

use App\Events\DocumentShareEvent;
use App\Services\Document\SharedDocumentService;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class DocumentShareListener
 *
 * This listener handles the sharing of documents when the DocumentShareEvent is fired.
 */
class DocumentShareListener implements ShouldQueue
{
    private SharedDocumentService $sharedDocumentService;

    /**
     * Create the event listener.
     *
     * @param SharedDocumentService $sharedDocumentService The service for sharing documents.
     */
    public function __construct(SharedDocumentService $sharedDocumentService)
    {
        $this->sharedDocumentService = $sharedDocumentService;
    }

    /**
     * Handle the event.
     *
     * @param DocumentShareEvent $event The event instance containing the document and emails.
     * @return void
     */
    public function handle(DocumentShareEvent $event): void
    {
        $document = $event->document;
        $emails = $event->emails;

        foreach ($emails as $email) {
            $this->sharedDocumentService->shareDocument($document, $email);
        }
    }
}
