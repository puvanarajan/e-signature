<?php

namespace App\Events;

use App\Models\SharedDocument;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class DocumentSharedNotificationEvent
 *
 * This event is triggered when a document is shared, notifying relevant listeners.
 */
class DocumentSharedNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var SharedDocument The shared document instance.
     */
    public SharedDocument $sharedDocument;

    /**
     * Create a new event instance.
     *
     * @param SharedDocument $sharedDocument The shared document instance.
     */
    public function __construct(SharedDocument $sharedDocument)
    {
        $this->sharedDocument = $sharedDocument;
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
