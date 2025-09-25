<?php

namespace App\Livewire\V2\Shop;

use App\Models\MProduct;
use Livewire\Component;

class Products extends Component
{
    public $products;

    public function render()
    {
        $this->products = MProduct::where('status', true)->orderByDesc('id')->get();
        return view('livewire.v2.shop.products');
    }
}


