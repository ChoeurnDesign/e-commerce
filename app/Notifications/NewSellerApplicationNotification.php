<?php

namespace App\Notifications;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewSellerApplicationNotification extends Notification
{
    use Queueable;

    public function __construct(public Seller $seller) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'       => 'new_seller_application',
            'message'    => "New seller application from {$this->seller->user->name} — store: \"{$this->seller->store_name}\".",
            'seller_id'  => $this->seller->id,
            'store_name' => $this->seller->store_name,
            'user_name'  => $this->seller->user->name,
            'url'        => route('admin.sellers.show', $this->seller->id),
        ];
    }
}
