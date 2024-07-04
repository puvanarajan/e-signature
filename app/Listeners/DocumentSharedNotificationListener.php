<?php

namespace App\Listeners;

use App\Events\DocumentSharedNotificationEvent;
use App\Mail\SharedDocumentMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

/**
 * Class DocumentSharedNotificationListener
 *
 * This listener handles the notification when a document is shared.
 */
class DocumentSharedNotificationListener implements ShouldQueue
{
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
     * @param DocumentSharedNotificationEvent $event The event instance.
     * @return void
     */
    public function handle(DocumentSharedNotificationEvent $event): void
    {
        $sharedDocument = $event->sharedDocument;

        Mail::to($sharedDocument->user->email)
            ->send(new SharedDocumentMail($sharedDocument));
    }
}
