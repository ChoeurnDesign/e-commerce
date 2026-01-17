<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupChatCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Create a new event instance.
     *
     * @param Chat $chat
     * @return void
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast to all participants
        $channels = [];
        foreach ($this->chat->participants as $participant) {
            $channels[] = new PrivateChannel('user.' . $participant->user_id);
        }
        return $channels;
    }
    
    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->chat->id,
            'name' => $this->chat->name,
            'image' => $this->chat->image,
            'type' => $this->chat->type,
            'created_at' => $this->chat->created_at->toIso8601String(),
            'participants' => $this->chat->participants->map(function($participant) {
                return [
                    'id' => $participant->user_id,
                    'name' => $participant->user->name ?? 'Unknown',
                    'avatar' => $participant->user->profile_photo_url ?? null
                ];
            })
        ];
    }
    
    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'group.created';
    }
}