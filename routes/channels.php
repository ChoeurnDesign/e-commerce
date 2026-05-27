<?php

use Illuminate\Support\Facades\Broadcast;

// Authorize users to subscribe to a chat channel.
// A user may only join a chat they are a participant of.
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return $user->chats()->where('chats.id', $chatId)->exists();
});
