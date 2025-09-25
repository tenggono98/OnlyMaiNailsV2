<?php

namespace App\Livewire\V2\Shop;

use App\Models\TOrder;
use Livewire\Component;

class OrderThankYou extends Component
{
    public $order;

    public function mount($id)
    {
        $this->order = TOrder::with('items.variant')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.v2.shop.order-thank-you');
    }
}


