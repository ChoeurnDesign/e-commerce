<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Events\GroupChatCreated;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\GroupChatUpdated;

class GroupChatController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Create a new group chat
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id'
        ]);
        
        // Create group chat
        $chat = Chat::create([
            'type' => 'group',
            'name' => $validated['name'],
            'created_by' => $user->id
        ]);
        
        // Add creator as participant
        $chat->participants()->create([
            'user_id' => $user->id,
            'is_admin' => true
        ]);
        
        // Add other participants
        foreach ($validated['participants'] as $participantId) {
            if ($participantId != $user->id) {
                $chat->participants()->create([
                    'user_id' => $participantId
                ]);
            }
        }
        
        // Load relationships
        $chat->load('participants.user');
        
        // Broadcast group creation
        broadcast(new GroupChatCreated($chat))->toOthers();
        
        return response()->json([
            'success' => true,
            'chat' => $chat,
            'redirect' => route('chat.conversation', $chat->id) // CHANGED FROM chat.show
        ]);
    }
    
    /**
     * Update group chat details
     */
    public function update(Request $request, Chat $chat)
    {
        $user = Auth::user();
        
        // Must be an admin of the group
        $participant = $chat->participants()->where('user_id', $user->id)->first();
        if (!$participant || !$participant->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|image|max:2048'
        ]);
        
        $updates = [];
        
        if (isset($validated['name'])) {
            $updates['name'] = $validated['name'];
        }
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('chat-groups', 'public');
            $updates['image'] = Storage::url($path);
        }
        
        $chat->update($updates);
        
        // Broadcast group update
        broadcast(new GroupChatUpdated($chat))->toOthers();
        
        return response()->json([
            'success' => true,
            'chat' => $chat->fresh()
        ]);
    }
}