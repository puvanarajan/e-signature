<?php

namespace App\Events;

use App\Models\Document;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class DocumentShareEvent
 *
 * This event is triggered when a document is shared with specified emails.
 */
class DocumentShareEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Document The document being shared.
     */
    public Document $document;

    /**
     * @var array The emails with which the document is shared.
     */
    public array $emails;

    /**
     * Create a new event instance.
     *
     * @param mixed $document The document being shared.
     * @param array $emails The emails with which the document is shared.
     */
    public function __construct($document, array $emails)
    {
        $this->document = $document;
        $this->emails = $emails;
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
