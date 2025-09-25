<div class="min-h-screen">
  <!-- Hero Section -->
  <div class="relative py-8">
    <div class="relative">
      <div class="text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
          Our <span class="text-[#fadde1]">Shop</span>
        </h1>
        <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
          Discover our premium collection of nail products and accessories, carefully curated for the perfect manicure experience.
        </p>
      </div>
    </div>
  </div>

  <!-- Products Section -->
  <div class="py-8">
    <!-- Filter/Sort Bar -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div class="flex items-center gap-4">
        <h2 class="text-2xl font-semibold text-gray-900">Products</h2>
        <span class="px-3 py-1 bg-[#fadde1] text-gray-800 text-sm font-medium rounded-lg">
          {{ count($products) }} items
        </span>
      </div>
      <div class="flex items-center gap-3">
        <button class="bg-[#fadde1] flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
          </svg>
          Filter
        </button>
        <button class="bg-[#fadde1] flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
          </svg>
          Sort
        </button>
      </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      @forelse($products as $p)
        <a href="{{ route('shop.product', $p->id) }}" class="group relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-[#fadde1] hover:border-[#fadde1]">
          <!-- Product Image -->
          <div class="relative aspect-square overflow-hidden bg-gray-100">
            @if($p->image_path)
              <img src="{{ asset('storage/'.$p->image_path) }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                   alt="{{ $p->name_service }}"/>
            @else
              <div class="w-full h-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            @endif
          </div>

          <!-- Product Info -->
          <div class="p-4">
            <!-- SKU Badge -->
            <div class="mb-2">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-[#fadde1] text-gray-800">
                {{ $p->sku }}
              </span>
            </div>

            <!-- Product Name -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-gray-700 transition-colors">
              {{ $p->name_service }}
            </h3>

            <!-- Price -->
            @php
              $activeVariants = $p->variants->where('status', true);
              $minPrice = $activeVariants->pluck('price')->filter(fn($v) => $v !== null)->min();
              $maxPrice = $activeVariants->pluck('price')->filter(fn($v) => $v !== null)->max();
              $minPrice = $minPrice === null ? 0 : $minPrice;
              $maxPrice = $maxPrice === null ? 0 : $maxPrice;
            @endphp
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                @if($minPrice === $maxPrice)
                  <span class="text-2xl font-bold text-gray-900">
                    ${{ number_format($minPrice, 2) }}
                  </span>
                @else
                  <span class="text-2xl font-bold text-gray-900">
                    ${{ number_format($minPrice, 2) }} - ${{ number_format($maxPrice, 2) }}
                  </span>
                @endif
              </div>

              <!-- Variants Count -->
              @if($activeVariants->count() > 1)
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                  {{ $activeVariants->count() }} variants
                </span>
              @endif
            </div>

            <!-- Stock Status -->
            @php
              $totalStock = $activeVariants->sum('stock');
            @endphp
            <div class="mt-3 flex items-center justify-between">
              @if($totalStock > 0)
                <span class="inline-flex items-center text-xs text-green-600">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  In Stock
                </span>
              @else
                <span class="inline-flex items-center text-xs text-red-600">
                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                  </svg>
                  Out of Stock
                </span>
              @endif

              <!-- Add to Cart Button -->
              <button class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 p-2 bg-[#fadde1] text-gray-800 rounded-lg hover:border hover:border-[#fadde1] hover:bg-transparent transform hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                </svg>
              </button>
            </div>
          </div>
        </a>
      @empty
        <!-- Empty State -->
        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
          <div class="w-24 h-24 bg-[#fadde1] rounded-full flex items-center justify-center mb-6">
            <svg class="w-12 h-12 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">No Products Available</h3>
          <p class="text-gray-600 max-w-md">We're currently updating our product catalog. Check back soon for amazing new items!</p>
        </div>
      @endforelse
    </div>

    <!-- Load More Button -->
    @if(count($products) > 0)
      <div class="mt-12 text-center">
        <button class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer px-8 py-3 font-semibold">
          Load More Products
        </button>
      </div>
    @endif
  </div>
</div>

