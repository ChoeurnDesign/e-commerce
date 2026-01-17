<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ChatMessage extends Model
{
    use HasFactory, SoftDeletes;

    // Explicit table name (helpful if migration/table name differs)
    protected $table = 'chat_messages';

    // temporary: allow mass assignment while debugging
    protected $guarded = [];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // If you have appends, make sure they don't throw when relations are missing.
    // Remove or keep only safe ones. (Optional)
    protected $appends = []; // removed is_read_status here to avoid potential accessor issues

    // Set defaults to avoid DB errors when 'type' or other fields are missing
    protected $attributes = [
        'type' => 'text',
        'is_read' => false,
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update(['is_read' => true]);
            return true;
        }
        return false;
    }

    public function isRead()
    {
        return (bool) $this->is_read;
    }

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isDocument()
    {
        return $this->type === 'document';
    }

    public function isText()
    {
        return $this->type === 'text';
    }

    public function getFileExtensionAttribute()
    {
        if ($this->file_name) {
            $parts = explode('.', $this->file_name);
            return end($parts);
        }
        return null;
    }

    public function getHumanReadableFileSizeAttribute()
    {
        if (!$this->file_size) return null;
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Count unread chat messages for a given user.
     */
    public static function unreadCountForUser(int $userId): int
    {
        return (int) DB::table('chat_messages')
            ->join('chat_participants', 'chat_messages.chat_id', '=', 'chat_participants.chat_id')
            ->where('chat_participants.user_id', $userId)
            ->where('chat_messages.sender_id', '!=', $userId)
            ->where(function ($q) {
                $q->whereNull('chat_messages.is_read')
                  ->orWhere('chat_messages.is_read', false);
            })
            ->where(function ($q) {
                $q->whereNull('chat_participants.last_read_at')
                  ->orWhereColumn('chat_messages.created_at', '>', 'chat_participants.last_read_at');
            })
            ->count();
    }
}