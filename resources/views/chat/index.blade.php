    <x-app-layout>
        <x-chat.chat-layout :chats="$chats" :currentChat="$currentChat ?? null">
            @include('chat._conversation', [
                'currentChat' => $currentChat,
                'lastSentId' => $lastSentId ?? null,
                'lastSentMessageTs' => $lastSentMessageTs ?? null,
                'messages' => $messages ?? [],
                'isSellerDashboard' => false,
            ])
        </x-chat.chat-layout>
    </x-app-layout>