<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatId;
    public $userId;
    public $userName;

    // Fix constructor to match your controller usage
    public function __construct($chatId, $userId, $userName = null)
    {
        $this->chatId = $chatId;
        $this->userId = $userId;
        $this->userName = $userName ?? \App\Models\User::find($userId)?->name ?? 'Unknown';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->chatId);
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id'   => $this->chatId,
            'user_id'   => $this->userId,
            'user_name' => $this->userName,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}