<?php

namespace App\Livewire\Admin\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use App\Models\MProductVariantImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app-admin')]
class VariantImages extends Component
{
    use WithFileUploads;

    public $products;
    public $selectedProductId = null;

    public $variants;
    public $selectedVariantId = null;

    public $images = [];

    // Multiple images upload
    public $newImages = [];

    public function saveImages()
    {
        $this->validate([
            'selectedProductId' => 'required|integer|exists:m_products,id',
            'selectedVariantId' => 'required|integer|exists:m_product_variants,id',
            'newImages' => 'required|array',
            'newImages.*' => 'image|max:6144',
        ]);

        $variant = MProductVariant::where('m_product_id', $this->selectedProductId)->find($this->selectedVariantId);
        if (!$variant) return;

        // Append images preserving order
        $nextOrder = (int) MProductVariantImage::where('m_product_variant_id', $variant->id)->max('sort_order');

        foreach ($this->newImages as $file) {
            $nextOrder++;
            $path = $file->store('shop/variants', 'public');
            MProductVariantImage::create([
                'm_product_variant_id' => $variant->id,
                'image_path' => $path,
                'sort_order' => $nextOrder,
            ]);
        }

        $this->newImages = [];
        $this->refreshImages();
    }

    public function mount()
    {
        $this->products = MProduct::orderBy('name_service')->get();
        $this->variants = collect();
        $this->refreshImages();
    }

    public function updatedSelectedProductId()
    {
        $this->loadVariants();
        $this->selectedVariantId = null; // wait for explicit selection
        $this->refreshImages();
    }

    public function updatedSelectedVariantId()
    {
        $this->refreshImages();
    }

    private function loadVariants(): void
    {
        if ($this->selectedProductId) {
            $this->variants = MProductVariant::where('m_product_id', $this->selectedProductId)
                ->orderBy('name')->get();
        } else {
            $this->variants = collect();
        }
    }

    private function refreshImages(): void
    {
        if ($this->selectedVariantId) {
            $variant = MProductVariant::with('images')->find($this->selectedVariantId);
            $this->images = $variant ? $variant->images->toArray() : [];
        } else {
            $this->images = [];
        }
    }

    public function deleteImage($id)
    {
        $img = MProductVariantImage::find($id);
        if (!$img) return;
        Storage::disk('public')->delete($img->image_path);
        $img->delete();
        $this->refreshImages();
    }

    public function render()
    {
        return view('livewire.admin.shop.variant-images');
    }
}
