<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerChatController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::user();
        $chats = Chat::whereHas('participants', function($q) use ($seller) {
            $q->where('user_id', $seller->id);
        })
        ->with(['lastMessage.sender', 'participants.user'])
        ->orderByDesc(function ($query) {
            $query->select('created_at')
                ->from('chat_messages')
                ->whereColumn('chat_id', 'chats.id')
                ->latest()
                ->limit(1);
        })
        ->get();

        $currentChat = null;
        $messages = collect();

        // Optionally handle currentChat selection (e.g., from route param)
        if ($request->chat_id) {
            $currentChat = Chat::find($request->chat_id);
            $messages = $currentChat ? $currentChat->getRecentMessages() : collect();
        } 

        return view('seller.chat.index', compact('chats', 'currentChat', 'messages'));
    }
}