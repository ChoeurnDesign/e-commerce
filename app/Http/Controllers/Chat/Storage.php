<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage as FileStorage;

class Storage extends Controller
{
    /**
     * Store a file for chat
     */
    public function store(Request $request, Chat $chat)
    {
        $user = Auth::user();
        
        // Check if user is participant
        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'type' => 'required|string|in:image,document',
        ]);
        
        // Check file type
        $file = $request->file('file');
        $type = $validated['type'];
        
        if ($type === 'image' && !in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
            return response()->json(['error' => 'Invalid image format'], 400);
        }
        
        // Store file in the appropriate directory
        $directory = $type === 'image' ? 'chat-images' : 'chat-documents';
        $path = $file->store($directory, 'public');
        $url = FileStorage::url($path);
        
        // Create message with file info
        $message = new ChatMessage([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'body' => $url,
            'type' => $type,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'is_read' => false,
        ]);
        
        $message->save();
        
        // Load sender relationship
        $message->load('sender');
        
        // Broadcast to all participants
        broadcast(new \App\Events\NewChatMessage($message))->toOthers();
        
        return response()->json([
            'id' => $message->id,
            'body' => $message->body,
            'created_at' => $message->created_at,
            'type' => $message->type,
            'file_name' => $message->file_name,
            'file_size' => $message->file_size,
            'sender_id' => $message->sender_id,
            'sender_name' => $message->sender->name,
            'sender_avatar' => $message->sender->profile_photo_url ?? null,
            'is_read' => $message->is_read,
        ]);
    }
}