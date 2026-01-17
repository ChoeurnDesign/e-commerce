<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserAddedToChat;
use App\Events\UserRemovedFromChat;
use App\Events\UserLeftChat;

class ChatParticipantController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Add user to chat (for group chats)
     */
    public function store(Request $request, Chat $chat)
    {
        $user = Auth::user();
        
        // Only chat participants can add others
        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Only group chats can add participants
        if ($chat->type !== 'group') {
            return response()->json(['error' => 'Cannot add participants to private chat'], 400);
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        
        $targetUser = User::find($validated['user_id']);
        
        // Check if already a participant
        if ($chat->participants()->where('user_id', $targetUser->id)->exists()) {
            return response()->json(['error' => 'User is already in this chat'], 400);
        }
        
        // Add user to chat
        $chat->participants()->create([
            'user_id' => $targetUser->id
        ]);
        
        // Broadcast user added event
        broadcast(new UserAddedToChat($chat->id, $targetUser))->toOthers();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Remove user from chat
     */
    public function destroy(Chat $chat, User $participant)
    {
        $user = Auth::user();
        
        // Only chat participants can remove others
        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Cannot remove from private chat
        if ($chat->type !== 'group') {
            return response()->json(['error' => 'Cannot remove participants from private chat'], 400);
        }
        
        // Remove the participant
        $chat->participants()->where('user_id', $participant->id)->delete();
        
        // Broadcast user removed event
        broadcast(new UserRemovedFromChat($chat->id, $participant->id))->toOthers();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Leave a chat
     */
    public function leave(Chat $chat)
    {
        $user = Auth::user();
        
        // Check if actually in chat
        if (!$chat->participants()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Not a member of this chat'], 400);
        }
        
        // Remove self
        $chat->participants()->where('user_id', $user->id)->delete();
        
        // Broadcast leave event
        broadcast(new UserLeftChat($chat->id, $user->id))->toOthers();
        
        return response()->json(['success' => true]);
    }
}