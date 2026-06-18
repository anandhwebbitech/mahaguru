<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderPlacedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $orderId;
    public Collection $orders;
    public float $total;

    public function __construct(string $orderId, Collection $orders)
    {
        $this->orderId = $orderId;
        $this->orders  = $orders;
        $this->total   = $orders->sum('total');
    }

    public function build()
    {
        return $this->subject('New Order Received - ' . $this->orderId)
            ->view('emails.order_placed_admin')
            ->with([
                'orderId'  => $this->orderId,
                'orders'   => $this->orders,
                'total'    => $this->total,
                'customer' => $this->orders->first()->user,
            ]);
    }
}