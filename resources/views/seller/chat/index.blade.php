@extends('layouts.seller')

@section('content')
    <x-chat.chat-layout 
        :chats="$chats" 
        :currentChat="$currentChat ?? null" 
        :isSellerDashboard="true"
    >
        @php
            // Calculate lastSentId and lastSentMessageTs for the current chat (if any)
            $lastSentMessage = isset($currentChat) && $currentChat 
                ? ($messages->last(function ($message) {
                    return $message->sender_id === auth()->id();
                }) ?? null)
                : null;
            $lastSentId = $lastSentMessage ? $lastSentMessage->id : null;
            $lastSentMessageTs = $lastSentMessage ? $lastSentMessage->created_at->toIso8601String() : null;
        @endphp

        @include('chat._conversation', [
            'currentChat' => $currentChat,
            'lastSentId' => $lastSentId,
            'lastSentMessageTs' => $lastSentMessageTs,
            'messages' => $messages ?? [],
            'isSellerDashboard' => true,
        ])
    </x-chat.chat-layout>
@endsection