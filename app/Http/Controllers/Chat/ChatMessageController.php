<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Events\NewChatMessage;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // Store a text message
    public function store(Request $request, Chat $chat)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 403);

        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'body' => 'required|string|max:2000',
            'type' => 'nullable|string',
        ]);

        // Create message
        $message = $chat->messages()->create([
            'sender_id' => $user->id,
            'body' => $data['body'],
            'type' => $data['type'] ?? 'text',
            'is_read' => false,
        ]);

        $message->load('sender');

        try {
            if (class_exists(NewChatMessage::class)) {
                broadcast(new NewChatMessage($message))->toOthers();
            }
        } catch (\Throwable $e) {
            Log::warning('Broadcast NewChatMessage failed: ' . $e->getMessage());
        }

        return response()->json([
            'id' => $message->id,
            'chat_id' => $message->chat_id,
            'body' => $message->body,
            'created_at' => $message->created_at->toIso8601String(),
            'sender_id' => $message->sender_id,
            'sender_name' => $message->sender->name ?? null,
            'sender_avatar' => $message->sender->profile_image ?? $message->sender->profile_photo_url ?? null,
            'type' => $message->type,
            'is_read' => $message->is_read ?? false,
        ], 201);
    }

    public function storeImage(Request $request, Chat $chat)
    {
        // Implement file upload, validation & creation logic if you use images.
        return response()->json(['error' => 'Not implemented'], 501);
    }

    public function destroy(ChatMessage $message)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['message' => 'Unauthorized'], 403);

        if ($message->sender_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $message->delete();

        try {
            event(new \App\Events\MessageDeleted($message));
        } catch (\Throwable $e) {
            Log::warning('Broadcast MessageDeleted failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }
}