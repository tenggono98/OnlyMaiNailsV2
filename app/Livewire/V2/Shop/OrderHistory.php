<?php

namespace App\Livewire\V2\Shop;

use App\Models\TOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderHistory extends Component
{
    public $orders;

    public function render()
    {
        $this->orders = TOrder::with('items.variant')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();
        return view('livewire.v2.shop.order-history');
    }
}


