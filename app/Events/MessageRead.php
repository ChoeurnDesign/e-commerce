<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $userId;
    public $readAt;

    public function __construct($chatId, $userId)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->readAt = now()->toIso8601String();
    }

    public function broadcastOn()
    {
        // Change from PrivateChannel to Channel for presence broadcasting
        return new Channel('chat.' . $this->chatId);
    }
    
    public function broadcastWith()
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
            'read_at' => $this->readAt,
        ];
    }
    
    /**
     * Get the broadcast event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.read';
    }
}