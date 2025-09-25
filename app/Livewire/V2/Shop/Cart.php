<?php

namespace App\Livewire\V2\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use Livewire\Component;

class Cart extends Component
{
    public $items = [];

    public function mount()
    {
        $this->items = session()->get('cart', []);
    }

    public function render()
    {
        $this->recalculate();
        return view('livewire.v2.shop.cart');
    }

    public function increment($index)
    {
        if (!isset($this->items[$index])) return;
        $this->items[$index]['qty'] = (int)$this->items[$index]['qty'] + 1;
        $this->sync();
    }

    public function decrement($index)
    {
        if (!isset($this->items[$index])) return;
        $this->items[$index]['qty'] = max(1, (int)$this->items[$index]['qty'] - 1);
        $this->sync();
    }

    public function remove($index)
    {
        if (isset($this->items[$index])) unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->sync();
    }

    private function recalculate(): void
    {
        foreach ($this->items as &$it) {
            $it['subtotal'] = (float)$it['price'] * (int)$it['qty'];
        }
    }

    private function sync(): void
    {
        $this->recalculate();
        session()->put('cart', $this->items);
    }
}


