<div class="min-h-screen" data-aos="fade-up">
  <!-- Header Section -->
  <div class="mb-8" data-aos="fade-up">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Checkout</h1>
    <p class="mt-2 text-lg text-gray-600">Review your order and complete your purchase</p>
  </div>

  @if (session()->has('error'))
    <div class="mb-6 p-4 text-red-700 bg-red-50 border border-red-200 rounded-xl">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
        </svg>
        {{ session('error') }}
      </div>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="60">
    <!-- Order Summary -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl border border-[#fadde1] shadow-sm p-6" data-aos="fade-up" data-aos-delay="80">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>

        <div class="space-y-4">
          @foreach($items as $it)
            <div class="flex items-center gap-4 p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors" data-aos="fade-up" data-aos-delay="100">
              <!-- Product Image -->
              <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                @if(!empty($it['image_path']))
                  <img src="{{ asset('storage/'.$it['image_path']) }}"
                       class="w-full h-full object-cover"
                       alt="{{ $it['name'] }}"/>
                @else
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                @endif
              </div>

              <!-- Product Details -->
              <div class="flex-1">
                <h3 class="font-semibold text-gray-900">{{ $it['name'] }}</h3>
                @if(!empty($it['variant_name']))
                  <div class="text-sm text-gray-600">Variant: {{ $it['variant_name'] }}</div>
                @endif
                <div class="mt-1">
                  <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-[#fadde1] text-gray-800">
                    SKU: {{ $it['sku'] }}
                  </span>
                </div>
              </div>

              <!-- Price and Quantity -->
              <div class="text-right">
                <div class="text-sm text-gray-500">Qty: {{ $it['qty'] }}</div>
                <div class="text-sm text-gray-600">${{ number_format($it['price'],2) }} each</div>
                <div class="text-lg font-bold text-gray-900">${{ number_format($it['price'] * $it['qty'],2) }}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Order Details & Payment -->
    <div class="lg:col-span-1">
      <!-- Total Summary -->
      <div class="bg-white rounded-xl border border-[#fadde1] shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Total</h3>

        <div class="space-y-3">
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-medium">${{ number_format($total,2) }}</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Shipping</span>
            <span class="font-medium text-green-600">Free</span>
          </div>
          <div class="border-t border-gray-200 pt-3">
            <div class="flex justify-between">
              <span class="text-lg font-semibold text-gray-900">Total</span>
              <span class="text-xl font-bold text-gray-900">${{ number_format($total,2) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Notes Section -->
      <div class="bg-white rounded-xl border border-[#fadde1] shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="120">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Notes</h3>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Additional Information</label>
          <textarea wire:model.defer="notes"
                    class="w-full p-3 border border-[#fadde1] rounded-lg form-control resize-none"
                    rows="4"
                    placeholder="Any special instructions or notes for your order..."></textarea>
        </div>
      </div>

      <!-- Payment Information -->
      <div class="bg-white rounded-xl border border-[#fadde1] shadow-sm p-6 mb-6" data-aos="fade-up" data-aos-delay="140">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
        <div class="space-y-4">
          <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
              </svg>
              <div>
                <div class="text-sm font-medium text-blue-900">Payment on Delivery</div>
                <div class="text-xs text-blue-700">Pay when your order arrives</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="space-y-3" data-aos="fade-up" data-aos-delay="160">
        <button wire:click="placeOrder"
                class="w-full bg-[#fadde1] flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer font-medium">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Place Order
        </button>

        <a href="{{ route('shop.cart') }}"
           class="w-full bg-gray-100 flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-gray-300 hover:bg-transparent cursor-pointer font-medium text-gray-700">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Cart
        </a>
      </div>
    </div>
  </div>
</div>

