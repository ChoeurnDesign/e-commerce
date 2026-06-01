<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    protected Order  $order;
    protected string $status;

    public function __construct(Order $order, string $status)
    {
        $this->order  = $order;
        $this->status = $status;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $messages = [
            'processing' => 'Your order is now being processed.',
            'confirmed'  => 'Your order has been confirmed by the seller.',
            'shipped'    => 'Great news! Your order has been shipped.',
            'delivered'  => 'Your order has been marked as delivered. Please confirm receipt.',
            'completed'  => 'Your order is complete. Thank you for shopping with us!',
            'cancelled'  => 'Your order has been cancelled.',
        ];

        $message = $messages[$this->status]
            ?? "Your order status has been updated to \"{$this->status}\".";

        return [
            'title'        => "Order #{$this->order->order_number}",
            'message'      => $message,
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'status'       => $this->status,
            'url'          => route('orders.show', $this->order->order_number),
        ];
    }
}
