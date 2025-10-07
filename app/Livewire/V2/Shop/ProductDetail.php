<?php

namespace App\Livewire\V2\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use Livewire\Component;

class ProductDetail extends Component
{
    public $product;
    public $variants;
    public $selectedVariantId = null;
    public $qty = 1;
    public $gallery = [];
    public $activeImage = 0;

    public function mount($slug)
    {
        $this->product = MProduct::where('slug', $slug)->firstOrFail();
        $this->product->load(['variants.images', 'reviews']);
        $this->variants = $this->product->variants;
        if ($this->variants && $this->variants->count() > 0) {
            $this->selectedVariantId = $this->variants->first()->id;
        }
        $this->refreshGallery();
    }

    public function selectVariant($id)
    {
        $this->selectedVariantId = $id;
        $this->refreshGallery();
    }

    private function refreshGallery(): void
    {
        $selected = $this->variants && $this->selectedVariantId ? $this->variants->firstWhere('id', $this->selectedVariantId) : null;
        $variantImages = $selected ? $selected->images->pluck('image_path')->all() : [];
        if (!empty($variantImages)) {
            $this->gallery = $variantImages;
        } else {
            $this->gallery = $this->product->image_path ? [$this->product->image_path] : [];
        }
        $this->activeImage = 0;
    }

    public function selectImage($index): void
    {
        if ($index >= 0 && $index < count($this->gallery)) {
            $this->activeImage = (int)$index;
        }
    }

    public function addToCart()
    {
        $selected = $this->variants && $this->selectedVariantId ? $this->variants->firstWhere('id', $this->selectedVariantId) : null;
        $price = $selected ? ($selected->price ?? 0) : 0; // variants are source of truth
        $name = $this->product->name_service;
        $variantName = $selected ? $selected->name : null;
        $sku = $selected ? $selected->sku : $this->product->sku;
        $imagePath = $selected && $selected->images->count() > 0 ? $selected->images->first()->image_path : $this->product->image_path;

        $cart = session()->get('cart', []);
        $cart[] = [
            'product_id' => $this->product->id,
            'variant_id' => $selected->id ?? null,
            'name' => $name,
            'variant_name' => $variantName,
            'sku' => $sku,
            'price' => (float)$price,
            'qty' => max(1, (int)$this->qty),
            'image_path' => $imagePath,
        ];
        session()->put('cart', $cart);
        return redirect()->route('shop.cart');
    }

    public function render()
    {
        return view('livewire.v2.shop.product-detail');
    }
}


