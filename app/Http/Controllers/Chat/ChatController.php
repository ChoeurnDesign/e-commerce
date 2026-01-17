<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Events\MessageRead;
use App\Events\NewChatMessage;
use App\Events\UserOnline;
use App\Events\UserTyping;
use App\Events\UserStoppedTyping;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function __construct()
    {
        // Controller-level middleware can be enabled if you prefer:
        // $this->middleware('auth');
    }

    public function index(Chat $chat = null)
    {
        $user = Auth::user();
        if (!$user) abort(403);

        // Update last active
        if (method_exists($user, 'updateLastActive')) {
            $user->updateLastActive();
        } else {
            $user->update(['last_active_at' => now()]);
        }

        try {
            if (class_exists(UserOnline::class)) {
                broadcast(new UserOnline($user))->toOthers();
            }
        } catch (\Throwable $e) {
            Log::warning('Broadcast UserOnline failed: ' . $e->getMessage());
        }

        $seller = $user;

        $chats = Chat::whereHas('participants', function ($q) use ($seller) {
            $q->where('user_id', $seller->id);
        })
        ->with(['lastMessage.sender', 'participants.user' => function ($q) {
            $q->select('id', 'name', 'profile_image', 'last_active_at');
        }])
        ->get();

        $currentChat = null;
        $messages = collect();

        if ($chat) {
            if (!$chat->participants()->where('user_id', $user->id)->exists()) {
                abort(403, 'You do not have access to this conversation');
            }

            $this->markChatAsRead($chat, $user->id);

            $chat->load(['participants.user' => function ($q) {
                $q->select('id', 'name', 'email', 'profile_image', 'last_active_at');
            }]);

            $messages = $chat->messages()
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->take(50)
                ->get();

            $currentChat = $chat;
        }

        return view('chat.index', compact('chats', 'currentChat', 'messages'));
    }

    private function markChatAsRead(Chat $chat, $userId)
    {
        $authUser = Auth::user();
        if ($authUser && isset($authUser->user_id) && !empty($authUser->user_id)) {
            $numericId = intval($authUser->user_id);
        } elseif ($authUser && isset($authUser->id)) {
            $numericId = intval($authUser->id);
        } else {
            $numericId = intval($userId);
        }

        Log::info("markChatAsRead: chat={$chat->id}, viewer={$numericId}");

        try {
            $participant = $chat->participants()->where('user_id', $numericId)->first();
            if ($participant) {
                $participant->last_read_at = now();
                $participant->save();
            }
        } catch (\Throwable $e) {
            Log::warning('Failed updating ChatParticipant.last_read_at: ' . $e->getMessage());
        }

        try {
            DB::table('chat_messages')
                ->where('chat_id', $chat->id)
                ->where('sender_id', '!=', $numericId)
                ->where(function ($q) {
                    $q->whereNull('is_read')->orWhere('is_read', false);
                })
                ->update(['is_read' => true]);
        } catch (\Throwable $e) {
            Log::warning('Skipping message-level is_read update: ' . $e->getMessage());
        }

        try {
            if (class_exists(MessageRead::class)) {
                broadcast(new MessageRead($chat->id, $numericId))->toOthers();
            }
        } catch (\Throwable $e) {
            Log::warning('Broadcast MessageRead failed: ' . $e->getMessage());
        }
    }

    public function conversation(Chat $chat)
    {
        return $this->index($chat);
    }

    public function startWithSeller(User $seller)
    {
        if (auth()->id() === $seller->id) {
            return redirect()->route('stores.show', $seller)
                ->with('error', 'You cannot start a chat with yourself.');
        }

        $chat = Chat::findOrCreatePrivateChat(auth()->id(), $seller->id);

        return redirect()->route('chat.conversation', $chat);
    }

    // If you prefer ChatMessageController handles POST messages keep that. This is a safe fallback.
    public function storeMessage(Request $request, Chat $chat)
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

        $createData = [
            'sender_id' => $user->id,
            'body' => $data['body'],
            'type' => $data['type'] ?? 'text',
            'is_read' => false,
        ];

        $message = $chat->messages()->create($createData);
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

    public function loadMoreMessages(Request $request, Chat $chat)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 403);

        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lastMessageId = $request->input('last_message_id');
        $limit = $request->input('limit', 20);

        $messages = $chat->messages()
            ->with('sender')
            ->where('id', '<', $lastMessageId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();

        return response()->json([
            'messages' => $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'body' => $message->body,
                    'created_at' => $message->created_at->toIso8601String(),
                    'type' => $message->type ?? 'text',
                    'sender_id' => $message->sender_id,
                    'sender_name' => $message->sender->name ?? 'Unknown',
                    'sender_avatar' => $message->sender->profile_image ?? null,
                    'is_read' => $message->is_read ?? false,
                ];
            }),
            'has_more' => $messages->count() == $limit
        ]);
    }

    public function updateTyping(Request $request, Chat $chat)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 403);

        if (method_exists($user, 'updateLastActive')) {
            $user->updateLastActive();
        } else {
            $user->update(['last_active_at' => now()]);
        }

        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            if (class_exists(UserTyping::class)) {
                broadcast(new UserTyping($chat->id, $user->id, $user->name))->toOthers();
            }
        } catch (\Throwable $e) {
            Log::warning('Broadcasting UserTyping failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    // <-- ADD stopTyping method below
    public function stopTyping(Request $request, Chat $chat)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 403);

        if (method_exists($user, 'updateLastActive')) {
            $user->updateLastActive();
        } else {
            $user->update(['last_active_at' => now()]);
        }

        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            if (class_exists(UserStoppedTyping::class)) {
                broadcast(new UserStoppedTyping($chat->id, $user->id, $user->name))->toOthers();
            }
        } catch (\Throwable $e) {
            Log::warning('Broadcast stopTyping failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true]);
    }

    public function markAsRead(Chat $chat)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 403);

        if (method_exists($user, 'updateLastActive')) {
            $user->updateLastActive();
        } else {
            $user->update(['last_active_at' => now()]);
        }

        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->markChatAsRead($chat, $user->id);

        return response()->json(['success' => true]);
    }

    public function getUserStatus(User $user)
    {
        $isOnline = method_exists($user, 'isOnline') ? $user->isOnline() : false;
        $statusText = method_exists($user, 'getActivityStatus') ? $user->getActivityStatus() : 'Offline';

        return response()->json([
            'is_online' => $isOnline,
            'status_text' => $statusText,
            'last_active_at' => $user->last_active_at?->toISOString(),
        ]);
    }

    public function getChatOnlineUsers(Chat $chat)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 403);

        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $onlineUsers = $chat->participants()
            ->with('user')
            ->get()
            ->filter(function ($participant) {
                return $participant->user && method_exists($participant->user, 'isOnline') && $participant->user->isOnline();
            })
            ->map(function ($participant) {
                return [
                    'id' => $participant->user->id,
                    'name' => $participant->user->name,
                    'status' => method_exists($participant->user, 'getActivityStatus') ? $participant->user->getActivityStatus() : 'Online',
                ];
            });

        return response()->json([
            'online_users' => $onlineUsers,
            'online_count' => $onlineUsers->count(),
        ]);
    }

    public function unreadCount(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['unread' => 0]);
        }

        try {
            $count = DB::table('chat_messages')
                ->join('chat_participants', 'chat_messages.chat_id', '=', 'chat_participants.chat_id')
                ->where('chat_participants.user_id', $user->id)
                ->where('chat_messages.sender_id', '!=', $user->id)
                ->where(function ($q) {
                    $q->whereNull('chat_messages.is_read')
                      ->orWhere('chat_messages.is_read', false);
                })
                ->where(function ($q) {
                    $q->whereNull('chat_participants.last_read_at')
                      ->orWhereColumn('chat_messages.created_at', '>', 'chat_participants.last_read_at');
                })
                ->count();
        } catch (\Throwable $e) {
            Log::warning("unreadCount failed: " . $e->getMessage());
            $count = 0;
        }

        return response()->json(['unread' => (int) $count]);
    }
}