<?php

namespace App\Livewire\Admin\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use App\Models\MProductStockAdjustment;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app-admin')]
class Stock extends Component
{
    use LivewireAlert;

    public $products;
    public $product_id;
    public $delta;
    public $reason;
    public $variant_id;

    public function render()
    {
        $this->products = MProduct::orderBy('name_service')->get();
        $adjustments = [];
        if ($this->product_id) {
            $adjustments = MProductStockAdjustment::with('variant')
                ->where('m_product_id', $this->product_id)
                ->orderByDesc('id')->limit(20)->get();
        }
        $variants = [];
        $selectedVariant = null;
        if ($this->product_id) {
            $variants = MProductVariant::where('m_product_id', $this->product_id)->orderBy('name')->get();
        }
        if ($this->variant_id) {
            $selectedVariant = MProductVariant::find($this->variant_id);
        }
        return view('livewire.admin.shop.stock', compact('adjustments','variants','selectedVariant'));
    }

    public function updatedProductId(): void
    {
        // Reset variant when product changes to trigger re-render and fresh options
        $this->variant_id = null;
    }

    public function adjust()
    {
        $this->validate([
            'product_id' => 'required|exists:m_products,id',
            'variant_id' => 'required|exists:m_product_variants,id',
            'delta' => 'required|integer|not_in:0',
            'reason' => 'nullable|string|max:255',
        ]);

        $variant = MProductVariant::where('m_product_id', $this->product_id)
            ->where('id', $this->variant_id)->first();
        if ($variant) {
            $variant->stock = max(0, (int)$variant->stock + (int)$this->delta);
            $variant->save();
        }

        MProductStockAdjustment::create([
            'm_product_id' => $this->product_id,
            'm_product_variant_id' => $this->variant_id,
            'delta' => (int)$this->delta,
            'reason' => $this->reason,
            'created_by' => Auth::id(),
        ]);

        $this->reset(['delta','reason','variant_id']);
        $this->alert('success', 'Stock adjusted');
    }
}


