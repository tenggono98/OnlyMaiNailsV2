<?php

namespace App\Livewire\V2\Shop;

use App\Models\TOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderDetail extends Component
{
    public $order;

    public function mount($uuid)
    {
        $this->order = TOrder::with('items.variant', 'client')
            ->where('uuid', $uuid)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.v2.shop.order-detail');
    }
}
