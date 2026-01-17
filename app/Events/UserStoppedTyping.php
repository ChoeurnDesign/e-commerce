<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserStoppedTyping implements ShouldBroadcast
{
    use SerializesModels;

    public int $chat_id;
    public int $user_id;
    public string $user_name;

    public function __construct(int $chat_id, int $user_id, string $user_name)
    {
        $this->chat_id = $chat_id;
        $this->user_id = $user_id;
        $this->user_name = $user_name;
    }

    public function broadcastOn(): Channel
    {
        return new Channel("chat.{$this->chat_id}");
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
        ];
    }

    public function broadcastAs(): string
    {
        return 'UserStoppedTyping';
    }
}