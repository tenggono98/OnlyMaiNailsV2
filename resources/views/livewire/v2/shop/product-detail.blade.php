<div class="p-4">
  <a href="{{ route('shop.index') }}" class="text-[#fadde1] hover:text-gray-700 transition-colors">&larr; Back to Shop</a>
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
            <button type="button" wire:click="selectImage({{ $idx }})" class="aspect-square rounded-lg overflow-hidden border {{ $activeImage === $idx ? 'border-[#fadde1] ring-1 ring-[#fadde1]' : 'border-gray-200 hover:border-[#fadde1]' }}">
              <img src="{{ asset('storage/'.$g) }}" class="w-full h-full object-cover"/>
            </button>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h1 class="text-3xl font-semibold text-gray-900">{{ $product->name_service }}</h1>
      <div class="mt-2">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-[#fadde1] text-gray-800">
          SKU: {{ $product->sku }}
        </span>
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
              <div class="flex items-center justify-between p-4 border border-[#fadde1] rounded-xl {{ $selectedVariantId === $v->id ? 'ring-2 ring-[#fadde1] bg-[#fadde1]/10' : 'hover:bg-gray-50' }} transition-all">
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
                          class="bg-[#fadde1] flex gap-2 justify-center rounded-lg p-2 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer text-sm font-medium {{ $selectedVariantId === $v->id ? 'ring-2 ring-[#fadde1]' : '' }}">
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
          <input type="number" min="1" wire:model.defer="qty" class="w-20 p-2 border border-[#fadde1] rounded-lg form-control" />
        </div>
        <button type="button" wire:click="addToCart"
                class="bg-[#fadde1] flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer font-medium {{ !$selectedVariantId ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ !$selectedVariantId ? 'disabled' : '' }}>
          Add to Cart
        </button>
        <a href="{{ route('shop.cart') }}"
           class="bg-gray-100 flex gap-2 justify-center rounded-lg p-3 hover:border hover:border-gray-300 hover:bg-transparent cursor-pointer font-medium text-gray-700">
          View Cart
        </a>
      </div>
    </div>
  </div>
</div>

