<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'last_read_at',
        'is_admin',
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark all unread messages as read
     */
    public function markAsRead()
    {
        $this->update(['last_read_at' => now()]);
        
        // Get the other participant (the one who sent the messages)
        $otherParticipant = $this->chat->participants()
            ->where('user_id', '!=', $this->user_id)
            ->first();
        
        if ($otherParticipant) {
            // Mark messages from the other participant that were sent before now as read
            $this->chat->messages()
                ->where('sender_id', $otherParticipant->user_id) // Only messages from the other person
                ->where('is_read', false) // Only unread messages
                ->where('created_at', '<=', now()) // Only messages sent before now
                ->update(['is_read' => true]);
        }
            
        return $this;
    }

    /**
     * Get unread message count for this participant - FIXED THE LOGIC
     */
    public function getUnreadCountAttribute()
    {
        // Get the other participant
        $otherParticipant = $this->chat->participants()
            ->where('user_id', '!=', $this->user_id)
            ->first();
        
        if (!$otherParticipant) {
            return 0;
        }

        if (!$this->last_read_at) {
            // If never read, count all messages from the other participant
            return $this->chat->messages()
                ->where('sender_id', $otherParticipant->user_id)
                ->count();
        }

        // Count messages from the other participant that were created after last read
        return $this->chat->messages()
            ->where('sender_id', $otherParticipant->user_id)
            ->where('created_at', '>', $this->last_read_at)
            ->count();
    }

    /**
     * Get the last message this participant has read
     */
    public function getLastReadMessageAttribute()
    {
        if (!$this->last_read_at) {
            return null;
        }

        return $this->chat->messages()
            ->where('created_at', '<=', $this->last_read_at)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Check if this participant has read a specific message
     */
    public function hasReadMessage($messageId)
    {
        $message = ChatMessage::find($messageId);
        if (!$message || !$this->last_read_at) {
            return false;
        }

        // Only check read status for messages from other participants
        if ($message->sender_id === $this->user_id) {
            return true; // Your own messages are always considered "read"
        }

        return $message->created_at <= $this->last_read_at;
    }

    /**
     * Get the other participant in the chat (for 1-on-1 chats)
     */
    public function getOtherParticipantAttribute()
    {
        return $this->chat->participants()
            ->where('user_id', '!=', $this->user_id)
            ->first();
    }

    /**
     * Get the other user in the chat (for 1-on-1 chats)
     */
    public function getOtherUserAttribute()
    {
        $otherParticipant = $this->otherParticipant;
        return $otherParticipant ? $otherParticipant->user : null;
    }
}