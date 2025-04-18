<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class TransactionCompletion extends Mailable
{
    use Queueable, SerializesModels;

    public $order; 

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('取引完了のお知らせ')
        ->view('transaction-completion')
        ->with([
            'order' => $this->order
        ]);
    }
}
