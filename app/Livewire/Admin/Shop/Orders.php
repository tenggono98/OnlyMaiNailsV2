<?php

namespace App\Livewire\Admin\Shop;

use App\Models\MProduct;
use App\Models\MProductVariant;
use App\Models\TOrder;
use App\Models\TOrderItem;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app-admin')]
class Orders extends Component
{
    use LivewireAlert;

    public $orders;
    public $status;
    public $user_id;
    public $items = [];
    public $notes;
    public $id_edit;
    public $is_edit = false;
    public $selected_product_id;
    public $variants = [];

    public function render()
    {
        $this->orders = TOrder::with('client','items.variant')->orderByDesc('id')->get();
        $products = MProduct::where('status', true)->orderBy('name_service')->get();

        // Load variants for selected product
        if ($this->selected_product_id) {
            $this->variants = MProductVariant::where('m_product_id', $this->selected_product_id)
                ->where('status', true)
                ->orderBy('name')
                ->get();
        } else {
            $this->variants = collect();
        }

        return view('livewire.admin.shop.orders', compact('products'));
    }

    public function updatedSelectedProductId()
    {
        $this->variants = collect();
    }

    public function addItem($variantId)
    {
        $variant = MProductVariant::find($variantId);
        if (!$variant) return;

        $this->items[] = [
            'm_product_id' => $variant->m_product_id,
            'm_product_variant_id' => $variant->id,
            'name' => $variant->product->name_service,
            'variant_name' => $variant->name,
            'variant_sku' => $variant->sku,
            'price' => (float)$variant->price,
            'qty' => 1,
            'subtotal' => (float)$variant->price,
        ];
    }

    public function updateQty($index, $qty)
    {
        if (!isset($this->items[$index])) return;
        $this->items[$index]['qty'] = max(1, (int)$qty);
        $this->items[$index]['subtotal'] = $this->items[$index]['qty'] * $this->items[$index]['price'];
    }

    public function removeItem($index)
    {
        if (isset($this->items[$index])) unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function resetForm()
    {
        $this->reset(['status','user_id','items','notes','id_edit','is_edit','selected_product_id','variants']);
    }

    public function save()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
            'items' => 'required|array|min:1',
        ]);

        $total = collect($this->items)->sum('subtotal');

        if ($this->is_edit) {
            $order = TOrder::find($this->id_edit);
            if (!$order) {
                $this->alert('error','Order not found');
                return;
            }
            $order->update([
                'user_id' => $this->user_id,
                'status' => $this->status,
                'total_price' => $total,
                'notes' => $this->notes,
                'updated_by' => Auth::id(),
            ]);
            TOrderItem::where('t_order_id', $order->id)->delete();
        } else {
            $order = TOrder::create([
                'uuid' => generateUUID(10),
                'user_id' => $this->user_id,
                'status' => $this->status,
                'total_price' => $total,
                'notes' => $this->notes,
                'created_by' => Auth::id(),
            ]);
        }

        foreach ($this->items as $it) {
            TOrderItem::create([
                't_order_id' => $order->id,
                'm_product_id' => $it['m_product_id'],
                'm_product_variant_id' => $it['m_product_variant_id'] ?? null,
                'name' => $it['name'] . (!empty($it['variant_name']) ? ' - ' . $it['variant_name'] : ''),
                'price' => $it['price'],
                'qty' => $it['qty'],
                'subtotal' => $it['subtotal'],
            ]);
        }

        $this->alert('success', 'Order saved');
        $this->resetForm();
    }

    public function edit($id)
    {
        $order = TOrder::with('items.variant')->find($id);
        if (!$order) return;
        $this->is_edit = true;
        $this->id_edit = $order->id;
        $this->user_id = $order->user_id;
        $this->status = $order->status;
        $this->notes = $order->notes;
        $this->items = $order->items->map(function($i){
            return [
                'm_product_id' => $i->m_product_id,
                'm_product_variant_id' => $i->m_product_variant_id,
                'name' => $i->name,
                'variant_name' => optional($i->variant)->name,
                'variant_sku' => optional($i->variant)->sku,
                'price' => (float)$i->price,
                'qty' => (int)$i->qty,
                'subtotal' => (float)$i->subtotal,
            ];
        })->toArray();
    }

    public function delete($id)
    {
        $order = TOrder::find($id);
        if ($order) {
            $order->delete();
            $this->alert('success','Order deleted');
        }
    }
}


