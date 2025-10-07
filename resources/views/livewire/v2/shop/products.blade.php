<div class="min-h-screen" data-aos="fade-up">
  <!-- Hero Section -->
  <div class="relative py-8" data-aos="fade-up">
    <div class="relative">
      <div class="text-center">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
          Our <span class="text-brand-accent-light">Shop</span>
        </h1>
        <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto">
          Discover our premium collection of nail products and accessories, carefully curated for the perfect manicure experience.
        </p>
      </div>
    </div>
  </div>

  <!-- Products Section -->
  <div class="py-8" data-aos="fade-up" data-aos-delay="60">
    <!-- Search Bar -->
    <div class="mb-6" data-aos="fade-up" data-aos-delay="70">
      <div class="relative max-w-md mx-auto">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <input wire:model.live.debounce.300ms="search" 
               type="text" 
               placeholder="Search products..." 
               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-brand-accent-light focus:border-brand-accent-light sm:text-sm">
      </div>
    </div>

    <!-- Filter/Sort Bar -->
    <div class="mb-8" data-aos="fade-up" data-aos-delay="80">
      <!-- Mobile Layout -->
      <div class="block sm:hidden space-y-4">
        <div class="flex items-center justify-between">
          <h2 class="text-xl font-semibold text-gray-900">Products</h2>
          <span class="px-2 py-1 bg-brand-accent-light text-gray-800 text-xs font-medium rounded-lg">
            {{ $products->total() }} items
          </span>
        </div>
        <div class="flex gap-2">
          <button wire:click="toggleFilters" 
                  class="flex-1 btn-primary-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filters
          </button>
          <div class="flex-1 relative">
            <select wire:model.live="sortBy" 
                    class="w-full select-primary-sm">
              <option value="newest">Newest</option>
              <option value="oldest">Oldest</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
              <option value="name_asc">Name: A to Z</option>
              <option value="name_desc">Name: Z to A</option>
              <option value="rating">Highest Rated</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Desktop Layout -->
      <div class="hidden sm:flex justify-between items-center gap-4">
        <div class="flex items-center gap-4">
          <h2 class="text-2xl font-semibold text-gray-900">Products</h2>
          <span class="px-3 py-1 bg-brand-accent-light text-gray-800 text-sm font-medium rounded-lg">
            {{ $products->total() }} items
          </span>
        </div>
        <div class="flex items-center gap-3">
          <button wire:click="toggleFilters" 
                  class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filters
          </button>
          <div class="relative">
            <select wire:model.live="sortBy" 
                    class="select-primary">
              <option value="newest">Newest First</option>
              <option value="oldest">Oldest First</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
              <option value="name_asc">Name: A to Z</option>
              <option value="name_desc">Name: Z to A</option>
              <option value="rating">Highest Rated</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters Panel -->
    @if($showFilters)
      <div class="mb-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm" data-aos="fade-up" data-aos-delay="90">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Price Range -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
            <div class="flex gap-2">
              <input wire:model.live.debounce.300ms="priceMin" 
                     type="number" 
                     placeholder="Min" 
                     class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-accent-light focus:border-brand-accent-light">
              <span class="flex items-center text-gray-500">to</span>
              <input wire:model.live.debounce.300ms="priceMax" 
                     type="number" 
                     placeholder="Max" 
                     class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-accent-light focus:border-brand-accent-light">
            </div>
          </div>

          <!-- Stock Status -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Availability</label>
            <label class="flex items-center">
              <input wire:model.live="inStockOnly" 
                     type="checkbox" 
                     class="h-4 w-4 text-brand-accent-light focus:ring-brand-accent-light border-gray-300 rounded">
              <span class="ml-2 text-sm text-gray-700">In Stock Only</span>
            </label>
          </div>

          <!-- Clear Filters -->
          <div class="flex items-end">
            <button wire:click="clearFilters" 
                    class="w-full btn-secondary">
              Clear All Filters
            </button>
          </div>
        </div>
      </div>
    @endif

    <!-- Products Grid: Skeleton while loading -->
    <div wire:loading class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6" aria-hidden="true">
      @for($i = 0; $i < 8; $i++)
        <div class="relative bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 animate-pulse">
          <div class="aspect-square bg-gray-200"></div>
          <div class="p-4 space-y-3">
            <div class="h-4 w-20 bg-gray-200 rounded"></div>
            <div class="h-5 w-3/4 bg-gray-200 rounded"></div>
            <div class="h-6 w-1/2 bg-gray-200 rounded"></div>
            <div class="flex items-center justify-between">
              <div class="h-4 w-24 bg-gray-200 rounded"></div>
              <div class="h-6 w-6 bg-gray-200 rounded"></div>
            </div>
          </div>
        </div>
      @endfor
    </div>

    <!-- Products Grid -->
    <div wire:loading.remove class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="100">
      @forelse($products as $p)
        <a href="{{ route('shop.product', $p->slug) }}" class="group relative bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-brand-accent-light hover:border-brand-accent-light" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 60, 360) }}">
          <!-- Product Image -->
          <div class="relative aspect-square overflow-hidden bg-gray-100">
            @if($p->image_path)
              <img src="{{ asset('storage/'.$p->image_path) }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                   alt="{{ $p->name_service }}" loading="lazy" decoding="async"/>
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
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-brand-accent-light text-gray-800">
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
            <div class="flex items-center justify-between mb-2">
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

              <!-- Options Count -->
              @if($activeVariants->count() > 1)
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                  {{ $activeVariants->count() }} options
                </span>
              @endif
            </div>

            <!-- Rating -->
            @if($p->total_reviews > 0)
              <div class="flex items-center gap-2 mb-3">
                <div class="flex items-center">
                  @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($p->average_rating))
                      <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                      </svg>
                    @else
                      <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                      </svg>
                    @endif
                  @endfor
                </div>
                <span class="text-sm text-gray-600">
                  {{ number_format($p->average_rating, 1) }} ({{ $p->total_reviews }})
                </span>
              </div>
            @else
              <div class="flex items-center gap-2 mb-3">
                <div class="flex items-center">
                  @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                  @endfor
                </div>
                <span class="text-sm text-gray-500">No reviews yet</span>
              </div>
            @endif

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
              <button class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 btn-primary-sm transform hover:scale-105">
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
          <div class="w-24 h-24 bg-brand-accent-light rounded-full flex items-center justify-center mb-6">
            <svg class="w-12 h-12 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">No Products Available</h3>
          <p class="text-gray-600 max-w-md">We're currently updating our product catalog. Check back soon for amazing new items!</p>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
      <div class="mt-12">
        {{ $products->links() }}
      </div>
    @endif
  </div>
</div>

