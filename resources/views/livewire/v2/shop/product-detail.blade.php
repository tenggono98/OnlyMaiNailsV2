@push('meta')
  <title>{{ $product->name_service }} - OnlyMaiNails</title>
  <link rel="canonical" href="{{ route('shop.product', $product->slug) }}">
  <meta name="description" content="{{ $product->description ? Str::limit($product->description, 160) : 'Shop ' . $product->name_service . ' at OnlyMaiNails - Premium nail products and accessories.' }}">
  <meta name="keywords" content="{{ $product->name_service }}, nail products, {{ $product->sku }}, OnlyMaiNails">
  <meta property="og:title" content="{{ $product->name_service }} - OnlyMaiNails">
  <meta property="og:description" content="{{ $product->description ? Str::limit($product->description, 160) : 'Shop ' . $product->name_service . ' at OnlyMaiNails' }}">
  <meta property="og:type" content="product">
  <meta property="og:url" content="{{ request()->url() }}">
  @if($product->image_path)
    <meta property="og:image" content="{{ asset('storage/' . $product->image_path) }}">
  @endif
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $product->name_service }} - OnlyMaiNails">
  <meta name="twitter:description" content="{{ $product->description ? Str::limit($product->description, 160) : 'Shop ' . $product->name_service . ' at OnlyMaiNails' }}">
  @if($product->image_path)
    <meta name="twitter:image" content="{{ asset('storage/' . $product->image_path) }}">
  @endif
  
  <!-- Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "{{ $product->name_service }}",
    "description": "{{ $product->description }}",
    "sku": "{{ $product->sku }}",
    "brand": {
      "@type": "Brand",
      "name": "OnlyMaiNails"
    },
    @if($product->image_path)
    "image": "{{ asset('storage/' . $product->image_path) }}",
    @endif
    @if($product->total_reviews > 0)
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "{{ number_format($product->average_rating, 1) }}",
      "reviewCount": "{{ $product->total_reviews }}"
    },
    @endif
    "offers": {
      "@type": "Offer",
      "url": "{{ request()->url() }}",
      "priceCurrency": "USD",
      @php
        $activeVariants = $product->variants->where('status', true);
        $minPrice = $activeVariants->pluck('price')->filter(fn($v) => $v !== null)->min();
        $maxPrice = $activeVariants->pluck('price')->filter(fn($v) => $v !== null)->max();
      @endphp
      @if($minPrice === $maxPrice)
      "price": "{{ $minPrice }}",
      @else
      "price": "{{ $minPrice }}",
      "priceValidUntil": "{{ now()->addYear()->format('Y-m-d') }}",
      @endif
      "availability": "{{ $activeVariants->sum('stock') > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
    }
  }
  </script>
@endpush

<div class="p-4">
  <!-- Breadcrumb -->
  <nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
      <li class="inline-flex items-center">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-brand-accent-light">
          <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
          </svg>
          Home
        </a>
      </li>
      <li>
        <div class="flex items-center">
          <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <a href="{{ route('shop.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-brand-accent-light md:ml-2">Shop</a>
        </div>
      </li>
      <li aria-current="page">
        <div class="flex items-center">
          <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
          <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name_service }}</span>
        </div>
      </li>
    </ol>
  </nav>
  <div class="grid grid-cols-1 gap-8 mt-6 md:grid-cols-2">
    <div>
      @php $mainImage = !empty($gallery) && isset($gallery[$activeImage]) ? $gallery[$activeImage] : null; @endphp
      @if($mainImage)
        <img src="{{ asset('storage/'.$mainImage) }}" class="w-full max-h-[500px] object-cover rounded-xl shadow-sm"/>
      @else
        <div class="w-full aspect-square bg-gray-100 rounded-xl flex items-center justify-center">
          <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
      @endif

      @if(count($gallery) > 1)
        <div class="mt-3 grid grid-cols-5 gap-2">
          @foreach($gallery as $idx => $g)
            <button type="button" wire:click="selectImage({{ $idx }})" class="aspect-square rounded-lg overflow-hidden border {{ $activeImage === $idx ? 'border-brand-accent-light ring-1 ring-brand-accent-light' : 'border-gray-200 hover:border-brand-accent-light' }}">
              <img src="{{ asset('storage/'.$g) }}" class="w-full h-full object-cover"/>
            </button>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h1 class="text-3xl font-semibold text-gray-900">{{ $product->name_service }}</h1>
      <div class="mt-2 flex items-center gap-4">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-brand-accent-light text-gray-800">
          SKU: {{ $product->sku }}
        </span>
        
        <!-- Rating Display -->
        @if($product->total_reviews > 0)
          <div class="flex items-center gap-2">
            <div class="flex items-center">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= round($product->average_rating))
                  <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                  </svg>
                @else
                  <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                  </svg>
                @endif
              @endfor
            </div>
            <span class="text-sm text-gray-600">
              {{ number_format($product->average_rating, 1) }} ({{ $product->total_reviews }} review{{ $product->total_reviews !== 1 ? 's' : '' }})
            </span>
          </div>
        @else
          <div class="flex items-center gap-2">
            <div class="flex items-center">
              @for($i = 1; $i <= 5; $i++)
                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
              @endfor
            </div>
            <span class="text-sm text-gray-500">No reviews yet</span>
          </div>
        @endif
      </div>
      @php
        $selected = $variants && $selectedVariantId ? $variants->firstWhere('id', $selectedVariantId) : null;
        $displayPrice = $selected ? ($selected->price ?? 0) : 0;
        $displayStock = $selected ? $selected->stock : 0;
      @endphp
      <div class="mt-4 text-3xl font-bold text-gray-900">${{ number_format($displayPrice,2) }}</div>
      <div class="mt-4 text-gray-600 leading-relaxed">{{ $product->description }}</div>
      <div class="mt-4 flex items-center gap-2">
        <span class="text-sm text-gray-500">Stock:</span>
        <span class="text-sm font-medium {{ $displayStock > 0 ? 'text-green-600' : 'text-red-600' }}">
          {{ $displayStock > 0 ? 'In Stock (' . $displayStock . ')' : 'Out of Stock' }}
        </span>
      </div>
      @if($variants && count($variants))
        <div class="mt-8">
          <h3 class="mb-4 text-xl font-semibold text-gray-900">Options</h3>
          <div class="space-y-3">
            @foreach($variants as $v)
              <div class="flex items-center justify-between p-4 border border-brand-accent-light rounded-xl {{ $selectedVariantId === $v->id ? 'ring-2 ring-brand-accent-light bg-brand-accent-light/10' : 'hover:bg-gray-50' }} transition-all">
                <div class="flex-1">
                  <div class="font-semibold text-gray-900">{{ $v->name }}</div>
                  <div class="text-sm text-gray-500">SKU: {{ $v->sku }}</div>
                </div>
                <div class="text-right mr-4">
                  <div class="text-lg font-bold text-gray-900">${{ number_format($v->price ?? 0,2) }}</div>
                  <div class="text-xs {{ $v->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $v->stock > 0 ? 'In Stock (' . $v->stock . ')' : 'Out of Stock' }}
                  </div>
                </div>
                <div>
                  <button type="button" wire:click="selectVariant({{ $v->id }})"
                          class="btn-primary-sm {{ $selectedVariantId === $v->id ? 'ring-2 ring-brand-accent-light' : '' }}">
                    {{ $selectedVariantId === $v->id ? 'Selected' : 'Select' }}
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
      <div class="flex items-center gap-4 mt-8">
        <div class="flex items-center gap-2">
          <label class="text-sm font-medium text-gray-700">Quantity:</label>
          <input type="number" min="1" wire:model.defer="qty" class="w-20 p-2 border border-brand-accent-light rounded-lg form-control" />
        </div>
        <button type="button" wire:click="addToCart"
                class="btn-primary {{ !$selectedVariantId ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ !$selectedVariantId ? 'disabled' : '' }}>
          Add to Cart
        </button>
        <a href="{{ route('shop.cart') }}"
           class="btn-secondary">
          View Cart
        </a>
      </div>
    </div>
  </div>

  <!-- Reviews Section -->
  <div class="mt-16">
    <!-- Mobile Layout: Form First -->
    <div class="block lg:hidden space-y-8">
      <div>
        @livewire('v2.shop.product-review-form', ['productId' => $product->id])
      </div>
      <div>
        @livewire('v2.shop.product-reviews', ['productId' => $product->id])
      </div>
    </div>

    <!-- Desktop Layout: Reviews First -->
    <div class="hidden lg:grid grid-cols-3 gap-8">
      <!-- Reviews List -->
      <div class="col-span-2">
        @livewire('v2.shop.product-reviews', ['productId' => $product->id])
      </div>
      
      <!-- Review Form -->
      <div class="col-span-1">
        @livewire('v2.shop.product-review-form', ['productId' => $product->id])
      </div>
    </div>
  </div>
</div>

