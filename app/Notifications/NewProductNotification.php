<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProductNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $type; // 'new' or 'discount'

    public function __construct(Product $product, $type = 'new')
    {
        $this->product = $product;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = $this->type === 'discount'
            ? 'Discount! "' . $this->product->name . '" is now on sale!'
            : 'A new product "' . $this->product->name . '" has been added!';

        return [
            'message' => $message,
            'product_id' => $this->product->id,
            'product_slug' => $this->product->slug,
        ];
    }
}
