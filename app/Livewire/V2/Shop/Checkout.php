<?php

namespace App\Livewire\V2\Shop;

use App\Models\TOrder;
use App\Models\TOrderItem;
use App\Models\MProduct;
use App\Models\MProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Checkout extends Component
{
    public $items = [];
    public $notes;

    public function mount()
    {
        $this->items = session()->get('cart', []);

        // Redirect to login if user is not authenticated
        if (!Auth::check()) {
            session()->put('checkout_redirect', true);
            return redirect()->route('user.login');
        }
    }

    public function render()
    {
        $total = collect($this->items)->sum(function($it){ return (float)$it['price'] * (int)$it['qty']; });
        return view('livewire.v2.shop.checkout', compact('total'));
    }

    public function placeOrder()
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to place an order.');
            return redirect()->route('user.login');
        }

        if (empty($this->items)) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        // Validate stock availability and rely on variant price/stock only
        $stockErrors = [];
        foreach ($this->items as $it) {
            if (!empty($it['variant_id'])) {
                $variant = MProductVariant::find($it['variant_id']);
                if (!$variant || (int)$variant->stock < (int)$it['qty']) {
                    $availableStock = $variant ? (int)$variant->stock : 0;
                    $stockErrors[] = "{$it['name']} - {$it['variant_name']}: Only {$availableStock} available, you requested {$it['qty']}";
                }
                // refresh price from variant to avoid tampering
                $it['price'] = (float)($variant->price ?? 0);
            } else {
                $stockErrors[] = "{$it['name']}: Variant is required";
            }
        }

        if (!empty($stockErrors)) {
            session()->flash('error', 'Insufficient stock: ' . implode('; ', $stockErrors));
            return;
        }

        // Recalculate total after normalizing prices from variants
        $total = collect($this->items)->sum(function($it){ return (float)$it['price'] * (int)$it['qty']; });

        // Generate collision-safe unique UUID for order
        do {
            $uuid = generateUUID(10);
        } while (\App\Models\TOrder::where('uuid', $uuid)->exists());

        $order = TOrder::create([
            'uuid' => $uuid,
            'user_id' => Auth::id(), // User is guaranteed to be authenticated at this point
            'status' => 'pending',
            'total_price' => $total,
            'notes' => $this->notes,
        ]);

        foreach ($this->items as $it) {
            TOrderItem::create([
                't_order_id' => $order->id,
                'm_product_id' => $it['product_id'],
                'm_product_variant_id' => $it['variant_id'] ?? null,
                'name' => $it['name'] . (!empty($it['variant_name']) ? ' - '.$it['variant_name'] : ''),
                'price' => $it['price'],
                'qty' => $it['qty'],
                'subtotal' => $it['price'] * $it['qty'],
            ]);

            // Decrement stock (variant overrides product)
            if (!empty($it['variant_id'])) {
                $variant = MProductVariant::find($it['variant_id']);
                if ($variant) {
                    $variant->stock = max(0, (int)$variant->stock - (int)$it['qty']);
                    $variant->save();
                }
            } else {
                $product = MProduct::find($it['product_id']);
                if ($product) {
                    $product->stock = max(0, (int)$product->stock - (int)$it['qty']);
                    $product->save();
                }
            }
        }

        // Email admins for payment confirmation (copy style from booking)
        try {
            $admin = \App\Models\User::where('role', '=', 'admin')->where('status', '=', true)->get();
            foreach ($admin as $item) {
                try {
                    Mail::raw("New shop order placed!\n\nOrder ID: " . $order->id . "\nTotal: $" . number_format($order->total_price,2) . "\nPlease confirm payment in Admin → Shop → Orders.", function($message) use ($item) {
                        $message->to($item->email)->subject('New Shop Order - Payment Confirmation');
                    });
                } catch (\Exception $e) {
                    \Log::error('Failed to send order email to admin: ' . $item->email);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send order emails to admins: ' . $e->getMessage());
        }

        session()->forget('cart');
        return redirect()->route('shop.order.thankyou', ['id' => $order->id]);
    }
}


