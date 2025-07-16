<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $previousStatus;
    public $newStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, string $previousStatus, string $newStatus)
    {
        $this->order = $order;
        $this->previousStatus = $previousStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Actualización de Estado de Pedido #'.$this->order->id)
                    ->markdown('emails.orders.status-updated');
    }
}
