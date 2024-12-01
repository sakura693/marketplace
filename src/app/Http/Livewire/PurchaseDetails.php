<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PurchaseDetails extends Component
{
    public $item;
    public $user;
    public $payment_methods; 
    public $selectedPaymentMethod;

    public function mount($item, $user, $payment_methods){
        $this->item = $item;
        $this->user = $user;
        $this->payment_methods = $payment_methods;

        $this ->selectedPaymentMethod = null; 
    }

    public function render()
    {
        return view('livewire.purchase-details');
    }
}
