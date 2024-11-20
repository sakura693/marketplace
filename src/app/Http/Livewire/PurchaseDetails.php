<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PurchaseDetails extends Component
{
    /*支払方法リストを格納*/
    public $item;
    public $user;
    public $payment_methods; 

    /*selectedPaymentMethodをプロパティとして定義*/
    public $selectedPaymentMethod; 

    /*支払方法のリストをコンポーネントに渡す*/
    public function mount($item, $user, $payment_methods){
        $this->item = $item;
        $this->user = $user;
        $this->payment_methods = $payment_methods;
        
        /*初期値を設定*/
        $this ->selectedPaymentMethod = null; 
    }

    public function render()
    {
        return view('livewire.purchase-details');
    }
}
