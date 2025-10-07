<div class="p-6 bg-gray-50 min-h-screen">
  <x-pages.admin.title-header-admin title="Shop - Products" />

  <div class="grid grid-cols-1 gap-8 mt-6 xl:grid-cols-3">
    <!-- Left: Step Navigation + Tips -->
    <div class="xl:col-span-1 space-y-6">
      <!-- Stepper / Tabs -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Product Setup</h3>
          <p class="text-sm text-gray-600 mt-1">Complete each step below</p>
        </div>
        <div class="p-4 space-y-2">
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border {{ !$is_edit ? 'border-blue-300 bg-blue-50 text-blue-900' : 'border-gray-200 hover:bg-gray-50' }}">
            1. Basic Information
          </button>
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">
            2. Product Image
          </button>
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">
            3. Variants
          </button>
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50">
            4. Variant Images
          </button>
        </div>
      </div>

      <!-- Sticky Tips -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h4 class="text-sm font-semibold text-gray-900">Helpful Tips</h4>
        </div>
        <div class="p-4 space-y-3 text-sm text-gray-700">
          <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-blue-800">
            Use a clear SKU pattern (e.g., BRAND-CAT-###) for easy tracking.
          </div>
          <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-blue-800">
            Product image: square, ≥800×800; larger source (≥1200×1200) recommended.
          </div>
          <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-blue-800">
            Add variants to manage price and stock per option.
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Form + List -->
    <div class="xl:col-span-2">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">
            {{ $is_edit ? 'Edit Product' : 'Create New Product' }}
          </h3>
          <p class="text-sm text-gray-600 mt-1">
            {{ $is_edit ? 'Update product information and variants' : 'Add a new product to your shop' }}
          </p>
        </div>

        <form id="product-form" wire:submit.prevent="save" class="p-6 space-y-10">
          <!-- Basic Information -->
          <div class="space-y-4">
            <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Basic Information</h4>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                <input type="text" wire:model.defer="sku"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="e.g., PROD-001" />
                @error('sku') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex items-center space-x-3">
                  <label class="inline-flex items-center">
                    <input type="checkbox" wire:model.defer="status"
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                  </label>
                </div>
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
              <input type="text" wire:model.defer="name_service"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                     placeholder="Enter product name" />
              @error('name_service') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <textarea wire:model.defer="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                        placeholder="Describe your product..."></textarea>
            </div>
          </div>

          <!-- Variants note -->
          <div class="space-y-3">
            <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Pricing & Inventory</h4>
            <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-sm text-blue-800">
              Pricing and stock are managed via variants. Manage variant images in <a href="{{ route('admin.shop.variant-images') }}" class="underline">Variant Images</a>.
            </div>
          </div>

          <!-- Product Image -->
          <div class="space-y-4">
            <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Product Image</h4>

            <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-sm text-blue-800">
              Recommended: square image, at least 800×800 px. Keep the subject centered. This image represents the product in listings.
            </div>

            <!-- Upload Options -->
            <div class="p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" wire:model="useCropper" value="true" class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Use Image Cropper (Recommended)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="useCropper" value="false" class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Direct Upload</span>
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Image Cropper allows you to crop and resize images to the perfect dimensions ({{ $outputWidth }}x{{ $outputHeight }}px)
                </p>
                <p class="text-xs text-gray-500 mt-1">Tip: Upload a larger image (≥ 1200×1200) for sharper results after cropping.</p>
            </div>

            @if($useCropper)
                <!-- Image Cropper Component -->
                <div class="space-y-4">
                    <livewire:component.image-cropper 
                        :crop-options="$cropOptions"
                        :output-width="$outputWidth"
                        :output-height="$outputHeight"
                        :output-format="'jpg'"
                        :output-quality="0.9"
                        wire:key="product-image-cropper-{{ $id_edit ?? 'new' }}"
                    />
                    
                    <!-- Show cropped image preview if available -->
                    @if($hasCroppedImage && $croppedImagePreview)
                        <x-ui.image-preview-single :src="$croppedImagePreview" title="Product Image Ready" subtitle="Cropped and ready to save" />
                    @endif
                </div>
            @else
                <!-- Direct Upload Form -->
                <div class="space-y-3">
                    <div class="flex items-center justify-center w-full">
                        <label for="product-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 2MB)</p>
                            </div>
                            <input id="product-image" type="file" wire:model="image" accept="image/*" class="hidden" />
                        </label>
                    </div>

                    @if ($image && !$hasCroppedImage)
                        <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg">
                            @if(is_string($image))
                                <!-- Show stored image -->
                                <img src="{{ asset('storage/' . $image) }}" class="object-cover w-24 h-24 rounded-lg shadow-sm" />
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Product Image</p>
                                    <p class="text-xs text-gray-500">Ready to save</p>
                                </div>
                            @else
                                <!-- Show uploaded file -->
                                <img src="{{ $image->temporaryUrl() }}" class="object-cover w-24 h-24 rounded-lg shadow-sm" />
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $image->getClientOriginalName() }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($image->getSize() / 1024, 1) }} KB</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
          </div>

          <!-- Action Buttons moved to bottom -->
        </form>
      </div>

      <!-- Product Variants Section -->
      <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="text-lg font-semibold text-gray-900">Product Variants</h4>
              <p class="text-sm text-gray-600 mt-1">Add different options for this product</p>
            </div>
            <button type="button" wire:click="addVariantRow"
                    class="px-3 py-2 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 font-medium">
              <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              Add Variant
            </button>
          </div>
        </div>

        <div class="p-6">
          @if(!empty($variants))
            <div class="space-y-4">
              @foreach($variants as $i => $v)
                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                  <div class="flex items-center justify-between mb-3">
                    <h5 class="text-sm font-medium text-gray-900">Variant {{ $i + 1 }}</h5>
                    <button type="button" wire:click="removeVariantRow({{ $i }})"
                            class="text-red-600 hover:text-red-700">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>

                  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">SKU</label>
                      <input type="text" wire:model.defer="variants.{{ $i }}.sku"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                             placeholder="Variant SKU" />
                    </div>
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">Name</label>
                      <input type="text" wire:model.defer="variants.{{ $i }}.name"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                             placeholder="Variant name" />
                    </div>
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">Price ($)</label>
                      <input type="number" step="0.01" wire:model.defer="variants.{{ $i }}.price"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                             placeholder="0.00" />
                    </div>
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">Stock</label>
                      <input type="number" wire:model.defer="variants.{{ $i }}.stock"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                             placeholder="0" min="0" />
                    </div>
                  </div>

                  <div class="mt-3">
                    <label class="inline-flex items-center">
                      <input type="checkbox" wire:model.defer="variants.{{ $i }}.status"
                             class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                      <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-8">
              <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
              </svg>
              <p class="text-sm text-gray-500">No variants added yet</p>
              <p class="text-xs text-gray-400 mt-1">Click "Add Variant" to create product options</p>
            </div>
          @endif
        </div>
      </div>

      <!-- Variant Images Manager (merged) -->
      <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h4 class="text-lg font-semibold text-gray-900">Variant Images</h4>
          <p class="text-sm text-gray-600 mt-1">Manage images for each variant without leaving this page</p>
        </div>
        <div class="p-6 space-y-4">
          @php
            $hasPersistedVariants = collect($variants ?? [])->filter(function($v){ return isset($v['id']); })->count();
          @endphp
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Variant</label>
            <select wire:model.live="selectedVariantId" wire:change="onSelectVariant" class="w-full border border-gray-300 rounded-lg p-2.5" {{ $hasPersistedVariants === 0 ? 'disabled' : '' }}>
              <option value="">-- Choose a variant --</option>
              @foreach($variants as $v)
                @if(isset($v['id']))
                  <option value="{{ $v['id'] }}">{{ $v['name'] }} ({{ $v['sku'] }})</option>
                @endif
              @endforeach
            </select>
            @if($hasPersistedVariants === 0)
              <p class="mt-2 text-xs text-gray-500">Save the product first, then return to upload variant images.</p>
            @endif
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 space-y-4">
              <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-sm text-blue-800">
                Variant images are shown on the product detail page gallery. Recommended: square 1:1, ≥600×600.
              </div>
              <form id="variant-images-form" wire:submit.prevent="saveVariantImages" class="space-y-3">
                <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 cursor-pointer {{ (!$selectedVariantId || $hasPersistedVariants === 0) ? 'opacity-50 cursor-not-allowed' : '' }}">
                  <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-sm text-gray-600"><span class="font-medium">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500">PNG, JPG up to 6MB each • Multiple files allowed</p>
                  </div>
                  <input id="variant-images-input" type="file" wire:model="variantNewImages" multiple class="hidden" accept="image/*" wire:key="variant-input-{{ $selectedVariantId ?? 'none' }}" {{ (!$selectedVariantId || $hasPersistedVariants === 0) ? 'disabled' : '' }} />
                </label>
                <x-ui.image-preview-multiple :files="$variantNewImages" title="Images Selected" clearEvent="$set('variantNewImages', [])" />
                <button type="submit" wire:loading.attr="disabled" wire:target="saveVariantImages" class="w-full bg-[#fadde1] rounded-lg px-4 py-2 font-medium hover:border hover:border-[#fadde1] hover:bg-transparent {{ (!$selectedVariantId || empty($variantNewImages) || $hasPersistedVariants === 0) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (!$selectedVariantId || empty($variantNewImages) || $hasPersistedVariants === 0) ? 'disabled' : '' }}>
                  <span wire:loading.remove wire:target="saveVariantImages">Upload</span>
                  <span wire:loading wire:target="saveVariantImages">Uploading...</span>
                </button>
              </form>
            </div>

            <div class="lg:col-span-2">
              <div class="bg-white rounded-xl border border-gray-200 p-5 relative">
                <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center z-10" wire:loading wire:target="saveVariantImages">
                  <div class="flex items-center gap-3 text-gray-700">
                    <svg class="animate-spin h-5 w-5 text-gray-700" viewBox="0 0 24 24"></svg>
                    <span class="text-sm">Processing...</span>
                  </div>
                </div>
                <div class="flex items-center justify-between mb-4">
                  <h5 class="text-lg font-semibold text-gray-900">Images</h5>
                  <span class="text-sm text-gray-500">{{ count($variantImages) }} image{{ count($variantImages) !== 1 ? 's' : '' }}</span>
                </div>
                @if(count($variantImages) === 0)
                  <div class="text-center py-16">
                    <svg class="w-14 h-14 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-gray-600">No images uploaded for this variant yet.</p>
                  </div>
                @else
                  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($variantImages as $img)
                      <div class="border rounded-lg overflow-hidden group">
                        <img src="{{ asset('storage/'.$img['image_path']) }}" class="w-full h-40 object-cover" />
                        <div class="p-2 flex items-center justify-between">
                          <span class="text-xs text-gray-500">#{{ $img['id'] }}</span>
                          <button wire:click="deleteVariantImage({{ $img['id'] }})" class="text-red-600 text-xs">Delete</button>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Final Actions -->
      <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 flex flex-col sm:flex-row gap-3 justify-end">
          <button type="button" wire:click="resetForm"
                  class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 font-medium">
            Reset
          </button>
          <button type="submit" form="product-form"
                  class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium">
            {{ $is_edit ? 'Update Product' : 'Create Product' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Products List Section -->
    <div class="xl:col-span-3">
      <x-ui.admin-table title="Products" :subtitle="$products->count().' products in your shop'" search :paginator="$products">
        <x-slot name="head">
          <tr>
            <x-ui.th width="40%">Product</x-ui.th>
            <x-ui.th>SKU</x-ui.th>
            <x-ui.th>Price (min variant)</x-ui.th>
            <x-ui.th>Stock (sum variants)</x-ui.th>
            <x-ui.th>Status</x-ui.th>
            <x-ui.th>Variants</x-ui.th>
            <x-ui.th align="right" width="140px">Actions</x-ui.th>
          </tr>
        </x-slot>
        @if($products->count() > 0)
          @foreach($products as $p)
            <tr class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-12 w-12">
                            @if($p->image_path)
                              <img src="{{ asset('storage/'.$p->image_path) }}"
                                   class="h-12 w-12 rounded-lg object-cover border border-gray-200"
                                   alt="{{ $p->name_service }}" />
                            @else
                              <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                              </div>
                            @endif
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $p->name_service }}</div>
                            @if($p->description)
                              <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($p->description, 50) }}</div>
                            @endif
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 font-mono">{{ $p->sku }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        @php
                          $activeVariants = $p->variants->where('status', true);
                          $minPrice = $activeVariants->pluck('price')->filter(fn($v) => $v !== null)->min();
                          $minPrice = $minPrice === null ? 0 : $minPrice;
                          $sumStock = (int) $activeVariants->sum('stock');
                        @endphp
                        <div class="text-sm font-medium text-gray-900">${{ number_format($minPrice, 2) }}</div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <span class="text-sm text-gray-900">{{ $sumStock }}</span>
                          @if($sumStock <= 5)
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                              Low Stock
                            </span>
                          @elseif($sumStock == 0)
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                              Out of Stock
                            </span>
                          @endif
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        @if($p->status)
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                              <circle cx="4" cy="4" r="3" />
                            </svg>
                            Active
                          </span>
                        @else
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                              <circle cx="4" cy="4" r="3" />
                            </svg>
                            Inactive
                          </span>
                        @endif
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ $p->variants->count() }} variant{{ $p->variants->count() !== 1 ? 's' : '' }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                          <button wire:click="edit({{ $p->id }})"
                                  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                          </button>
                          <button wire:click="delete({{ $p->id }})"
                                  wire:confirm="Are you sure you want to delete this product?"
                                  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                          </button>
                        </div>
                      </td>
                  </tr>
          @endforeach
        @else
          <tr>
            <td colspan="7" class="text-center py-12">
              <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
              </svg>
              <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
              <p class="text-sm text-gray-500 mb-6">Get started by creating your first product</p>
              <button wire:click="resetForm"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Your First Product
              </button>
            </td>
          </tr>
        @endif
      </x-ui.admin-table>
    </div>
  </div>
</div>

