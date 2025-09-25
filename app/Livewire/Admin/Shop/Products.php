<?php

namespace App\Livewire\Admin\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app-admin')]
class Products extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $products;
    public $variants = [];

    // Form fields
    #[Validate('required|string|max:64')]
    public $sku;
    #[Validate('required|string|max:255')]
    public $name_service;
    public $description;
    public $price_service = 0; // base price obsolete
    public $stock = 0; // base stock obsolete
    public $status = true;
    public $image;
    public $id_edit;
    public $is_edit = false;

    public function render()
    {
        $this->products = MProduct::with('variants')->orderByDesc('id')->get();
        return view('livewire.admin.shop.products');
    }

    public function resetForm()
    {
        $this->reset(['sku','name_service','description','price_service','stock','status','image','id_edit','is_edit']);
        $this->variants = [];
    }

    public function save()
    {
        $this->validate([
            'sku' => 'required|string|max:64',
            'name_service' => 'required|string|max:255',
            'description' => 'nullable|string',
            // price/stock are handled by variants; keep optional
        ]);

        // Validate variant SKUs for uniqueness
        $variantSkus = [];
        foreach ($this->variants as $index => $v) {
            if (!empty($v['sku'])) {
                if (in_array($v['sku'], $variantSkus)) {
                    $this->addError('variants.' . $index . '.sku', 'SKU must be unique within this product.');
                    return;
                }
                $variantSkus[] = $v['sku'];

                // Check if SKU already exists in database
                $existingVariant = MProductVariant::where('sku', $v['sku'])->first();
                if ($existingVariant && (!$this->is_edit || $existingVariant->m_product_id != $this->id_edit)) {
                    $this->addError('variants.' . $index . '.sku', 'This SKU is already in use.');
                    return;
                }
            }
        }

        // Ensure at least one active variant
        $hasActiveVariant = collect($this->variants)->contains(function($v){
            return !empty($v['name']) && (isset($v['status']) ? (bool)$v['status'] : true) && (isset($v['price']) && $v['price'] !== null);
        });
        if (!$hasActiveVariant) {
            $this->alert('error', 'Please add at least one active variant with a price.');
            return;
        }

        $data = [
            'sku' => $this->sku,
            'name_service' => $this->name_service,
            'description' => $this->description,
            'price_service' => 0,
            'stock' => 0,
            'status' => (bool) $this->status,
        ];

        if ($this->image) {
            $path = $this->image->store('products', 'public');
            $data['image_path'] = $path;
        }

        if ($this->is_edit) {
            $product = MProduct::find($this->id_edit);
            if (!$product) {
                $this->alert('error', 'Product not found');
                return;
            }
            if ($this->image && $product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->update($data);
            // Replace variants
            MProductVariant::where('m_product_id', $product->id)->delete();
            foreach ($this->variants as $v) {
                if (!empty($v['name'])) {
                    $baseSku = $v['sku'] ?? ($this->sku.'-'.strtoupper(generateUUID(4)));
                    $uniqueSku = $this->generateUniqueSku($baseSku);

                    MProductVariant::create([
                        'm_product_id' => $product->id,
                        'sku' => $uniqueSku,
                        'name' => $v['name'],
                        'price' => $v['price'] ?? null,
                        'stock' => $v['stock'] ?? 0,
                        'status' => isset($v['status']) ? (bool)$v['status'] : true,
                    ]);
                }
            }
            $this->alert('success', 'Product updated');
        } else {
            $product = MProduct::create($data);
            foreach ($this->variants as $v) {
                if (!empty($v['name'])) {
                    $baseSku = $v['sku'] ?? ($this->sku.'-'.strtoupper(generateUUID(4)));
                    $uniqueSku = $this->generateUniqueSku($baseSku);

                    MProductVariant::create([
                        'm_product_id' => $product->id,
                        'sku' => $uniqueSku,
                        'name' => $v['name'],
                        'price' => $v['price'] ?? null,
                        'stock' => $v['stock'] ?? 0,
                        'status' => isset($v['status']) ? (bool)$v['status'] : true,
                    ]);
                }
            }
            $this->alert('success', 'Product created');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $product = MProduct::find($id);
        if (!$product) {
            $this->alert('error', 'Product not found');
            return;
        }
        $this->is_edit = true;
        $this->id_edit = $product->id;
        $this->sku = $product->sku;
        $this->name_service = $product->name_service;
        $this->description = $product->description;
        $this->price_service = 0;
        $this->stock = 0;
        $this->status = $product->status;
        $this->variants = method_exists($product, 'variants') ? $product->variants()->get(['sku','name','price','stock','status'])->toArray() : [];
    }

    public function addVariantRow()
    {
        $this->variants[] = ['sku' => '', 'name' => '', 'price' => null, 'stock' => 0, 'status' => true];
    }

    public function removeVariantRow($index)
    {
        if (isset($this->variants[$index])) unset($this->variants[$index]);
        $this->variants = array_values($this->variants);
    }

    public function delete($id)
    {
        $product = MProduct::find($id);
        if ($product) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $product->delete();
            $this->alert('success', 'Product deleted');
        }
    }

    private function generateUniqueSku($baseSku)
    {
        $originalSku = $baseSku;
        $counter = 1;
        while (MProductVariant::where('sku', $baseSku)->exists()) {
            $baseSku = $originalSku . '-' . $counter;
            $counter++;
        }
        return $baseSku;
    }
}


