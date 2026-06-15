<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $statusStr = ucfirst(str_replace('_', ' ', $this->order->status));
        return $this->subject("Your GOS MOMO Order #{$this->order->order_number} is {$statusStr}")
                    ->view('emails.order_status');
    }
}
