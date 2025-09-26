<div class="p-6 bg-gray-50 min-h-screen">
  <x-pages.admin.title-header-admin title="Shop - Variant Images" />

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <!-- Left: Product & Variant Selector + Uploader -->
    <div class="lg:col-span-1 space-y-6">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Select Product</h3>
        <select wire:model.live="selectedProductId" class="w-full border border-gray-300 rounded-lg p-2.5">
          <option value="">-- Choose a product --</option>
          @foreach($products as $p)
            <option value="{{ $p->id }}">{{ $p->name_service }} ({{ $p->sku }})</option>
          @endforeach
        </select>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Select Variant</h3>
        <select wire:model.live="selectedVariantId" class="w-full border border-gray-300 rounded-lg p-2.5" {{ !$selectedProductId ? 'disabled' : '' }}>
          <option value="">-- Choose a variant --</option>
          @if($variants && $variants->count())
            @foreach($variants as $v)
              <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->sku }})</option>
            @endforeach
          @endif
        </select>
      </div>

      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <h3 class="text-lg font-semibold text-gray-900 mb-3">Upload Images</h3>
        
        <!-- Upload Options -->
        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
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
                    wire:key="variant-image-cropper-{{ now()->timestamp }}"
                />
                
                <!-- Show cropped images preview if available -->
                @if(!empty($croppedImages))
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-medium text-green-800">Cropped Images Ready ({{ count($croppedImages) }})</h4>
                            <button type="button" wire:click="clearAllCroppedImages" 
                                    class="text-xs text-red-600 hover:text-red-800">
                                Clear All
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($croppedImages as $index => $croppedImage)
                                <div class="relative border rounded-lg overflow-hidden">
                                    <img src="{{ $croppedImage['preview'] }}" alt="Cropped preview" class="w-full h-20 object-cover">
                                    <button type="button" wire:click="removeCroppedImage({{ $index }})" 
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" wire:click="clearAllCroppedImages" 
                            class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Clear All
                    </button>
                    <button type="button" wire:click="saveAllCroppedImages" 
                            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            {{ empty($croppedImages) ? 'disabled' : '' }}>
                        Save All Images ({{ count($croppedImages) }})
                    </button>
                </div>
            </div>
        @else
            <!-- Direct Upload Form -->
            <div class="space-y-3">
          <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 cursor-pointer {{ (!$selectedProductId || !$selectedVariantId) ? 'opacity-50 cursor-not-allowed' : '' }}">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
              </svg>
              <p class="text-sm text-gray-600"><span class="font-medium">Click to upload</span> or drag and drop</p>
              <p class="text-xs text-gray-500">PNG, JPG up to 6MB each • Multiple files allowed</p>
            </div>
            <input type="file" wire:model="newImages" multiple class="hidden" accept="image/*" {{ (!$selectedProductId || !$selectedVariantId) ? 'disabled' : '' }} />
          </label>

          @if(!empty($newImages))
            <div class="grid grid-cols-3 gap-2">
              @foreach($newImages as $tmp)
                <div class="border rounded-lg overflow-hidden">
                  <img src="{{ $tmp->temporaryUrl() }}" class="w-full h-20 object-cover" />
                </div>
              @endforeach
            </div>
          @endif

          <button type="button" wire:click.prevent="saveImages" wire:loading.attr="disabled" class="w-full bg-[#fadde1] rounded-lg px-4 py-2 font-medium hover:border hover:border-[#fadde1] hover:bg-transparent {{ (!$selectedProductId || !$selectedVariantId) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (!$selectedProductId || !$selectedVariantId) ? 'disabled' : '' }}>
            <span wire:loading.remove>Upload</span>
            <span wire:loading>Uploading...</span>
          </button>
          @error('newImages') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
          @error('newImages.*') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>
        @endif
      </div>
    </div>

    <!-- Right: Images Grid -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Images</h3>
          <span class="text-sm text-gray-500">{{ count($images) }} image{{ count($images) !== 1 ? 's' : '' }}</span>
        </div>
        @if(count($images) === 0)
          <div class="text-center py-16">
            <svg class="w-14 h-14 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <p class="text-gray-600">No images uploaded for this variant yet.</p>
          </div>
        @else
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($images as $img)
              <div class="border rounded-lg overflow-hidden group">
                <img src="{{ asset('storage/'.$img['image_path']) }}" class="w-full h-40 object-cover" />
                <div class="p-2 flex items-center justify-between">
                  <span class="text-xs text-gray-500">#{{ $img['id'] }}</span>
                  <button wire:click="deleteImage({{ $img['id'] }})" class="text-red-600 text-xs">Delete</button>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
