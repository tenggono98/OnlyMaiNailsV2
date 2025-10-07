<div class="min-h-screen" data-aos="fade-up">
  <div class="mx-auto px-4 py-6" data-aos="fade-up">
    <!-- Header -->
    <div class="mb-8" data-aos="fade-up">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">My Orders</h1>
      <p class="text-gray-600">Track and manage your order history</p>
    </div>

    @forelse($orders as $order)
      <!-- Order Card -->
      <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-6 overflow-hidden" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 60, 360) }}">
        <!-- Order Header -->
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
              </div>
              <div class="flex items-center gap-2">
                @php
                  $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'paid' => 'bg-blue-100 text-blue-800',
                    'shipped' => 'bg-purple-100 text-purple-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800'
                  ];
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                  {{ ucfirst($order->status) }}
                </span>
              </div>
            </div>
            <div class="text-right">
              <div class="text-2xl font-bold text-gray-900">${{ number_format($order->total_price, 2) }}</div>
              <div class="text-sm text-gray-600">{{ count($order->items) }} item{{ count($order->items) !== 1 ? 's' : '' }}</div>
            </div>
          </div>
        </div>

        <!-- Order Items Preview -->
        <div class="p-4">
          <div class="space-y-3 mb-6">
            @foreach($order->items->take(3) as $item)
              <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                  <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div class="flex-1">
                  <h4 class="font-medium text-gray-900">{{ $item->name }}</h4>
                  <div class="text-sm text-gray-600">Quantity: {{ $item->qty }} × ${{ number_format($item->price, 2) }}</div>
                </div>
                <div class="text-right">
                  <div class="font-semibold text-gray-900">${{ number_format($item->subtotal, 2) }}</div>
                </div>
              </div>
            @endforeach

            @if(count($order->items) > 3)
              <div class="text-center py-2">
                <span class="text-sm text-gray-500">+{{ count($order->items) - 3 }} more item{{ count($order->items) - 3 !== 1 ? 's' : '' }}</span>
              </div>
            @endif
          </div>

          <!-- Order Actions -->
          <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
            <a href="{{ route('shop.order.detail', $order->uuid) }}"
               class="flex-1 btn-order">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              View Details
            </a>

            @if($order->status === 'pending')
              <button class="flex-1 btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancel Order
              </button>
            @endif
          </div>
        </div>
      </div>
    @empty
      <!-- Empty State -->
      <div class="text-center py-14">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
          <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h3>
        <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your orders here.</p>
        <a href="{{ route('shop.index') }}"
           class="btn-order inline-flex">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          Start Shopping
        </a>
      </div>
    @endforelse
  </div>
</div>

