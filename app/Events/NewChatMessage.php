<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        // Eager load the sender relation to avoid N+1 queries
        $this->message = $message->load('sender');
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->message->chat_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id'          => $this->message->id,
            'body'        => $this->message->body,
            'created_at'  => $this->message->created_at->toIso8601String(),
            'sender_id'   => $this->message->sender_id,
            'sender_name' => $this->message->sender?->name ?? 'Unknown',
            'sender_avatar' => $this->message->sender?->profile_photo_url ?? null,
            'type'        => $this->message->type,
            'is_read'     => $this->message->is_read,
            'chat_id'     => $this->message->chat_id,
        ];
    }
}