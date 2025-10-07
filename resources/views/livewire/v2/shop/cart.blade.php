<div class="min-h-screen" data-aos="fade-up">
  <!-- Header Section -->
  <div class="mb-8" data-aos="fade-up">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">Your Cart</h1>
    <p class="mt-2 text-lg text-gray-600">Review your items and proceed to checkout</p>
  </div>

  @if(count($items) > 0)
    <!-- Cart Items -->
    <div class="space-y-4 mb-8" data-aos="fade-up" data-aos-delay="60">
      @foreach($items as $i => $it)
        <div class="bg-white rounded-xl border border-brand-accent-light shadow-sm hover:shadow-md transition-shadow duration-200" data-aos="fade-up" data-aos-delay="{{ min($i * 60, 360) }}">
          <div class="p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
              <!-- Product Info -->
              <div class="flex-1">
                <div class="flex items-start gap-4">
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
                    <h3 class="text-lg font-semibold text-gray-900">{{ $it['name'] }}</h3>
                    @if (!empty($it['variant_name']))
                      <div class="mt-1 text-sm text-gray-600">{{ $it['variant_name'] }}</div>
                    @endif
                    <div class="mt-1">
                      <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium bg-brand-accent-light text-gray-800">
                        SKU: {{ $it['sku'] }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Price and Controls -->
              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <!-- Price -->
                <div class="text-right">
                  <div class="text-lg font-bold text-gray-900">${{ number_format($it['price'],2) }}</div>
                  <div class="text-sm text-gray-500">per item</div>
                </div>

                <!-- Quantity Controls -->
                <div class="flex items-center">
                  <button wire:click="decrement({{ $i }})"
                          class="w-10 h-10 flex items-center justify-center bg-brand-accent-light border border-brand-accent-light rounded-l-lg hover:bg-transparent hover:border-brand-accent-light transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                  </button>
                  <div class="w-16 h-10 flex items-center justify-center border-t border-b border-brand-accent-light bg-white text-center font-medium">
                    {{ $it['qty'] }}
                  </div>
                  <button wire:click="increment({{ $i }})"
                          class="w-10 h-10 flex items-center justify-center bg-brand-accent-light border border-brand-accent-light rounded-r-lg hover:bg-transparent hover:border-brand-accent-light transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                  </button>
                </div>

                <!-- Subtotal -->
                <div class="text-right">
                  <div class="text-xl font-bold text-gray-900">${{ number_format($it['subtotal'],2) }}</div>
                  <div class="text-sm text-gray-500">subtotal</div>
                </div>

                <!-- Remove Button -->
                <button wire:click="remove({{ $i }})"
                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Cart Summary -->
    <div class="bg-white rounded-xl border border-brand-accent-light shadow-sm p-6 mb-8" data-aos="fade-up" data-aos-delay="80">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>
        <span class="text-sm text-gray-500">{{ count($items) }} item{{ count($items) > 1 ? 's' : '' }}</span>
      </div>

      <div class="space-y-3">
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Subtotal</span>
          <span class="font-medium">${{ number_format(collect($items)->sum('subtotal'), 2) }}</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-600">Shipping</span>
          <span class="font-medium text-green-600">Free</span>
        </div>
        <div class="border-t border-gray-200 pt-3">
          <div class="flex justify-between">
            <span class="text-lg font-semibold text-gray-900">Total</span>
            <span class="text-xl font-bold text-gray-900">${{ number_format(collect($items)->sum('subtotal'), 2) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="100">
      <a href="{{ route('shop.index') }}"
         class="flex-1 btn-secondary">
        Continue Shopping
      </a>
      @auth
        <a href="{{ route('shop.checkout') }}"
           class="flex-1 btn-primary">
          Proceed to Checkout
        </a>
      @else
        <a href="{{ route('user.login') }}"
           class="flex-1 btn-primary">
          Login to Checkout
        </a>
      @endauth
    </div>

  @else
    <!-- Empty Cart State -->
    <div class="text-center py-16" data-aos="fade-up">
      <div class="w-24 h-24 bg-brand-accent-light rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-12 h-12 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
        </svg>
      </div>
      <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
      <p class="text-gray-600 mb-6">Looks like you haven't added any items to your cart yet.</p>
      <a href="{{ route('shop.index') }}"
         class="btn-primary inline-flex">
        Start Shopping
      </a>
    </div>
  @endif
</div>

