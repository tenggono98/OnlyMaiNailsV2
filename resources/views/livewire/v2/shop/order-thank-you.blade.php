<div class="min-h-screen" data-aos="fade-up">
  <div class="max-w-4xl mx-auto px-4 py-16" data-aos="fade-up">
    <!-- Success Header -->
    <div class="text-center mb-12" data-aos="zoom-in">
      <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <h1 class="text-4xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        Thank you for your order! We've received your order and will process it shortly.
      </p>
    </div>

    <!-- Order Details Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8" data-aos="fade-up" data-aos-delay="80">
      <div class="border-b border-gray-200 pb-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Order Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <span class="text-gray-500">Order Number:</span>
            <div class="font-semibold text-gray-900">#{{ $order->id }}</div>
          </div>
          <div>
            <span class="text-gray-500">Order Date:</span>
            <div class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
          </div>
          <div>
            <span class="text-gray-500">Total Amount:</span>
            <div class="font-semibold text-gray-900">${{ number_format($order->total_price, 2) }}</div>
          </div>
        </div>
      </div>

      <!-- Order Items -->
      @if($order->items && count($order->items) > 0)
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Items Ordered</h3>
          <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
            @foreach($order->items as $item)
              <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-lg">
                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-900">{{ $item->name }}</h4>
                  <div class="text-sm text-gray-600">Quantity: {{ $item->qty }}</div>
                  <div class="text-sm text-gray-600">Price: ${{ number_format($item->price, 2) }} each</div>
                </div>
                <div class="text-right">
                  <div class="text-lg font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Order Status -->
      <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex items-center gap-3">
          <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
          <div>
            <div class="font-semibold text-gray-900">Order Status: {{ ucfirst($order->status) }}</div>
            <div class="text-sm text-gray-600">We'll notify you once your order is processed</div>
          </div>
        </div>
      </div>

      <!-- Notes -->
      @if($order->notes)
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Order Notes</h3>
          <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-700">{{ $order->notes }}</p>
          </div>
        </div>
      @endif
    </div>

    <!-- Next Steps -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8" data-aos="fade-up" data-aos-delay="120">
      <h2 class="text-2xl font-semibold text-gray-900 mb-4">What's Next?</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 bg-[#fadde1] rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-1">Payment Confirmation</h3>
            <p class="text-sm text-gray-600">Our team will confirm your payment and process your order</p>
          </div>
        </div>
        <div class="flex items-start gap-4">
          <div class="w-10 h-10 bg-[#fadde1] rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-1">Order Updates</h3>
            <p class="text-sm text-gray-600">You'll receive email updates about your order status</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="140">
      <a href="{{ route('shop.index') }}"
         class="btn-order">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
        </svg>
        Continue Shopping
      </a>
      @auth
        <a href="{{ route('shop.orders') }}"
           class="btn-secondary">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.801 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"></path>
          </svg>
          View My Orders
        </a>
      @endauth
    </div>
  </div>
</div>

