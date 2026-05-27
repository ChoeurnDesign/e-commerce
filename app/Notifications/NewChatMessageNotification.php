<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    public function __construct(protected ChatMessage $message) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $senderName = $this->message->sender->name ?? 'Someone';

        return [
            'type'        => 'chat_message',
            'message'     => "{$senderName} sent you a message",
            'preview'     => Str::limit($this->message->body, 60),
            'chat_id'     => $this->message->chat_id,
            'sender_id'   => $this->message->sender_id,
            'sender_name' => $senderName,
            'url'         => route('chat.conversation', $this->message->chat_id),
        ];
    }
}
