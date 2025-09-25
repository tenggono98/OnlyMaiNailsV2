<div class="p-6 bg-gray-50 min-h-screen">
  <x-pages.admin.title-header-admin title="Shop - Products" />

  <div class="grid grid-cols-1 gap-8 mt-6 xl:grid-cols-3">
    <!-- Product Form Section -->
    <div class="xl:col-span-1">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">
            {{ $is_edit ? 'Edit Product' : 'Create New Product' }}
          </h3>
          <p class="text-sm text-gray-600 mt-1">
            {{ $is_edit ? 'Update product information and variants' : 'Add a new product to your shop' }}
          </p>
        </div>

        <form wire:submit.prevent="save" class="p-6 space-y-6">
          <!-- Basic Information -->
          <div class="space-y-4">
            <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Basic Information</h4>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                <input type="text" wire:model.defer="sku"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                     placeholder="Enter product name" />
              @error('name_service') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <textarea wire:model.defer="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                        placeholder="Describe your product..."></textarea>
            </div>
          </div>

          <!-- Pricing & Inventory -->
          <div class="space-y-4">
            <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Pricing & Inventory</h4>

            <div class="rounded-lg bg-blue-50 border border-blue-200 p-3 text-sm text-blue-800">
              Pricing and stock are managed via variants. Manage variant images in <a href="{{ route('admin.shop.variant-images') }}" class="text-[#fadde1] underline">Variant Images</a>.
            </div>
          </div>

          <!-- Product Image -->
          <div class="space-y-4">
            <h4 class="text-sm font-medium text-gray-900 border-b border-gray-200 pb-2">Product Image</h4>

            <div class="space-y-3">
              <div class="flex items-center justify-center w-full">
                <label for="product-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
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

              @if ($image)
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-lg">
                  <img src="{{ $image->temporaryUrl() }}" class="object-cover w-24 h-24 rounded-lg shadow-sm" />
                  <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">{{ $image->getClientOriginalName() }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($image->getSize() / 1024, 1) }} KB</p>
                  </div>
                </div>
              @endif
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex space-x-3 pt-4">
            <button type="submit"
                    class="flex-1 px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium">
              {{ $is_edit ? 'Update Product' : 'Create Product' }}
            </button>
            <button type="button" wire:click="resetForm"
                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium">
              Reset
            </button>
          </div>
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
                    class="px-3 py-2 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors font-medium">
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
                            class="text-red-600 hover:text-red-700 transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                      </svg>
                    </button>
                  </div>

                  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">SKU</label>
                      <input type="text" wire:model.defer="variants.{{ $i }}.sku"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                             placeholder="Variant SKU" />
                    </div>
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">Name</label>
                      <input type="text" wire:model.defer="variants.{{ $i }}.name"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                             placeholder="Variant name" />
                    </div>
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">Price ($)</label>
                      <input type="number" step="0.01" wire:model.defer="variants.{{ $i }}.price"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                             placeholder="0.00" />
                    </div>
                    <div>
                      <label class="block text-xs font-medium text-gray-700 mb-1">Stock</label>
                      <input type="number" wire:model.defer="variants.{{ $i }}.stock"
                             class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
    </div>

    <!-- Products List Section -->
    <div class="xl:col-span-2">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Products</h3>
              <p class="text-sm text-gray-600 mt-1">{{ $products->count() }} products in your shop</p>
            </div>
            <div class="flex items-center space-x-3">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </div>
                <input type="text" placeholder="Search products..."
                       class="pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" />
              </div>
            </div>
          </div>
        </div>

        <div class="overflow-hidden">
          @if($products->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (min variant)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock (sum variants)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variants</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($products as $p)
                    <tr class="hover:bg-gray-50 transition-colors">
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
                                  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                          </button>
                          <button wire:click="delete({{ $p->id }})"
                                  wire:confirm="Are you sure you want to delete this product?"
                                  class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                          </button>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-center py-12">
              <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
              </svg>
              <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
              <p class="text-sm text-gray-500 mb-6">Get started by creating your first product</p>
              <button wire:click="resetForm"
                      class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Your First Product
              </button>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

