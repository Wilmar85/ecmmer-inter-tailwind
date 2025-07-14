<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('¡Tu pedido ha sido recibido!')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Gracias por tu compra. Tu pedido #' . $this->order->order_number . ' ha sido recibido y está siendo procesado.')
            ->action('Ver pedido', url(route('orders.show', $this->order->id)))
            ->line('¡Gracias por confiar en nosotros!');
    }
}
