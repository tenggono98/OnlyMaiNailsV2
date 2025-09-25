<div class="min-h-screen">
  <div class="mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
      <a href="{{ route('shop.orders') }}" class="text-[#fadde1] hover:text-gray-700 transition-colors mb-4 inline-flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Orders
      </a>
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Details</h1>
      <p class="text-gray-600">Order #{{ $order->id }} placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Content -->
      <div class="lg:col-span-2 space-y-6">
        <!-- Order Status -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Status</h2>
          <div class="flex items-center gap-4">
            @php
              $statusColors = [
                'pending' => 'bg-yellow-100 text-yellow-800',
                'paid' => 'bg-blue-100 text-blue-800',
                'shipped' => 'bg-purple-100 text-purple-800',
                'completed' => 'bg-green-100 text-green-800',
                'cancelled' => 'bg-red-100 text-red-800'
              ];
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
              {{ ucfirst($order->status) }}
            </span>
            <div class="text-sm text-gray-600">
              @if($order->status === 'pending')
                Your order is being processed
              @elseif($order->status === 'paid')
                Payment confirmed, preparing your order
              @elseif($order->status === 'shipped')
                Your order is on the way
              @elseif($order->status === 'completed')
                Order delivered successfully
              @elseif($order->status === 'cancelled')
                Order has been cancelled
              @endif
            </div>
          </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
          <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Items</h2>
          <div class="space-y-4">
            @foreach($order->items as $item)
              <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                <!-- Product Image -->
                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>

                <!-- Product Details -->
                <div class="flex-1">
                  <h3 class="font-semibold text-gray-900">{{ $item->name }}</h3>
                  @if($item->variant)
                    <div class="text-sm text-gray-600">Variant: {{ $item->variant->name }}</div>
                    <div class="mt-1">
                      <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-[#fadde1] text-gray-800">
                        SKU: {{ $item->variant->sku }}
                      </span>
                    </div>
                  @endif
                </div>

                <!-- Quantity and Price -->
                <div class="text-right">
                  <div class="text-sm text-gray-500">Qty: {{ $item->qty }}</div>
                  <div class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</div>
                  <div class="text-lg font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Order Notes -->
        @if($order->notes)
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Notes</h2>
            <div class="bg-gray-50 rounded-lg p-4">
              <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
          </div>
        @endif
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Order Summary -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
          <div class="space-y-3">
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Subtotal</span>
              <span class="text-gray-900">${{ number_format($order->total_price, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Shipping</span>
              <span class="text-gray-900">Free</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Tax</span>
              <span class="text-gray-900">$0.00</span>
            </div>
            <div class="border-t border-gray-200 pt-3">
              <div class="flex justify-between">
                <span class="text-lg font-semibold text-gray-900">Total</span>
                <span class="text-lg font-bold text-gray-900">${{ number_format($order->total_price, 2) }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Information -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Information</h2>
          <div class="space-y-3 text-sm">
            <div>
              <span class="text-gray-600">Order Number:</span>
              <div class="font-semibold text-gray-900">#{{ $order->id }}</div>
            </div>
            <div>
              <span class="text-gray-600">Order Date:</span>
              <div class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
            </div>
            <div>
              <span class="text-gray-600">Order Time:</span>
              <div class="font-semibold text-gray-900">{{ $order->created_at->format('g:i A') }}</div>
            </div>
            <div>
              <span class="text-gray-600">Items:</span>
              <div class="font-semibold text-gray-900">{{ count($order->items) }} item{{ count($order->items) !== 1 ? 's' : '' }}</div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Actions</h2>
          <div class="space-y-3">
            @if($order->status === 'pending')
              <button class="w-full bg-red-100 flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-red-300 hover:bg-transparent cursor-pointer font-medium text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancel Order
              </button>
            @endif

            <a href="{{ route('shop.index') }}"
               class="w-full bg-[#fadde1] flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer font-medium">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
              </svg>
              Continue Shopping
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
