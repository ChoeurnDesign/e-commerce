<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function participants()
    {
        return $this->hasMany(ChatParticipant::class);
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function getOtherUserForUser($userId)
    {
        if ($this->type !== 'private') {
            return null;
        }

        $otherParticipant = $this->participants()
            ->with(['user' => function($query) {
                $query->select('id', 'name', 'email', 'profile_image', 'last_active_at');
            }])
            ->where('user_id', '!=', $userId)
            ->first();
            
        return $otherParticipant?->user;
    }

    public static function findOrCreatePrivateChat($user1Id, $user2Id)
    {
        $chat = self::whereHas('participants', function ($query) use ($user1Id) {
            $query->where('user_id', $user1Id);
        })
        ->whereHas('participants', function ($query) use ($user2Id) {
            $query->where('user_id', $user2Id);
        })
        ->where('type', 'private')
        ->first();

        if ($chat) {
            return $chat;
        }

        // Remove 'created_by' from the fields
        $chat = self::create([
            'type' => 'private',
        ]);

        $chat->participants()->createMany([
            ['user_id' => $user1Id],
            ['user_id' => $user2Id],
        ]);

        return $chat->fresh(['participants.user']);
    }

    public function isGroup()
    {
        return $this->type === 'group';
    }

    public function isPrivate()
    {
        return $this->type === 'private';
    }

    public function getNameForUser($userId)
    {
        if ($this->isGroup()) {
            return $this->name ?? 'Group Chat';
        }

        $otherUser = $this->getOtherUserForUser($userId);
        
        if (!$otherUser) {
            return 'Unknown User';
        }

        if ($otherUser->isSeller() && $otherUser->seller && $otherUser->seller->store_name) {
            return $otherUser->seller->store_name;
        }
        
        return $otherUser->name;
    }

    public function getAvatarForUser($userId)
    {
        if ($this->isGroup()) {
            return $this->image ?? null;
        }

        $otherUser = $this->getOtherUserForUser($userId);
        
        return $otherUser ? ($otherUser->profile_image ?? null) : null;
    }

    public function getUnreadCountForUser($userId)
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        
        if (!$participant) {
            return 0;
        }

        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('created_at', '>', $participant->last_read_at ?? $participant->created_at)
            ->count();
    }

    public function markAsReadForUser($userId)
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        
        if ($participant) {
            $participant->update(['last_read_at' => now()]);
            return true;
        }
        
        return false;
    }

    public function hasParticipant($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    public function scopePrivate($query)
    {
        return $query->where('type', 'private');
    }

    public function scopeGroup($query)
    {
        return $query->where('type', 'group');
    }

    public function scopeOrderedByActivity($query)
    {
        return $query->orderByDesc(function ($subQuery) {
            $subQuery->select('created_at')
                ->from('chat_messages')
                ->whereColumn('chat_id', 'chats.id')
                ->latest()
                ->limit(1);
        });
    }

    public function getRecentMessages($limit = 50)
    {
        return $this->messages()
            ->with(['sender' => function($query) {
                $query->select('id', 'name', 'profile_image');
            }])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();
    }
}