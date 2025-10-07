<div class="p-6 {{ $embedded ? '' : 'bg-gray-50 min-h-screen' }}">
  @unless($embedded)
    <x-pages.admin.title-header-admin title="Shop - Variant Images" />
  @endunless

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <!-- Left: Step Navigation + Selectors -->
    <div class="lg:col-span-1 space-y-6">
      <!-- Stepper / Tabs -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 {{ $embedded ? 'hidden' : '' }}">
        <div class="px-5 py-4 border-b border-gray-200">
          <h3 class="text-lg font-semibold text-gray-900">Variant Images Setup</h3>
          <p class="text-sm text-gray-600 mt-1">Follow steps to upload images</p>
        </div>
        <div class="p-4 space-y-2">
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border border-blue-300 bg-blue-50 text-blue-900">
            1. Select Product
          </button>
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border {{ $selectedProductId ? 'border-blue-300 bg-blue-50 text-blue-900' : 'border-gray-200 hover:bg-gray-50' }}">
            2. Select Variant
          </button>
          <button type="button" class="w-full text-left px-3 py-2 rounded-lg border {{ ($selectedProductId && $selectedVariantId) ? 'border-blue-300 bg-blue-50 text-blue-900' : 'border-gray-200 hover:bg-gray-50' }}">
            3. Upload Images
          </button>
        </div>
      </div>
      @unless($embedded)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
          <h3 class="text-lg font-semibold text-gray-900 mb-3">Select Product</h3>
          <select wire:model.live="selectedProductId" class="w-full border border-gray-300 rounded-lg p-2.5">
            <option value="">-- Choose a product --</option>
            @foreach($products as $p)
              <option value="{{ $p->id }}">{{ $p->name_service }} ({{ $p->sku }})</option>
            @endforeach
          </select>
        </div>
      @endunless

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
        <div class="mb-3 rounded-lg bg-blue-50 border border-blue-200 p-3 text-sm text-blue-800">
          Variant images are shown on the product detail page gallery. Recommended: square images (1:1), at least 600×600 px. Keep the subject centered.
        </div>
        
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
            <p class="text-xs text-gray-500 mt-1">Tip: Upload multiple images; you can crop each before saving.</p>
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
                    wire:key="variant-image-cropper-{{ $selectedVariantId ?? 'none' }}"
                />
                
                <!-- Show cropped images preview if available -->
                @if(!empty($croppedImages))
                    <x-ui.image-preview-multiple :files="$croppedImages" title="Cropped Images Ready" clearEvent="clearAllCroppedImages" />
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

          <x-ui.image-preview-multiple :files="$newImages" title="Images Selected" clearEvent="$set('newImages', [])" />

          <button type="button" wire:click.prevent="saveImages" wire:loading.attr="disabled" class="w-full bg-[#fadde1] rounded-lg px-4 py-2 font-medium hover:border hover:border-[#fadde1] hover:bg-transparent {{ (!$selectedProductId || !$selectedVariantId) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (!$selectedProductId || !$selectedVariantId) ? 'disabled' : '' }}>
            <span wire:loading.remove wire:target="saveImages">Upload</span>
            <span wire:loading wire:target="saveImages">Uploading...</span>
          </button>
          @error('newImages') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
          @error('newImages.*') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>
        @endif
      </div>
    </div>

    <!-- Right: Images Grid (Admin Table) -->
    <div class="lg:col-span-2">
      <div class="relative" wire:loading.class="opacity-60" wire:target="saveImages saveAllCroppedImages deleteImage">
        <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center z-10" wire:loading wire:target="saveImages saveAllCroppedImages deleteImage">
          <div class="flex items-center gap-3 text-gray-700">
            <svg class="animate-spin h-5 w-5 text-gray-700" viewBox="0 0 24 24"></svg>
            <span class="text-sm">Processing...</span>
          </div>
        </div>
        <x-ui.admin-table :title="'Images'" :subtitle="count($images).' image'.(count($images)!==1?'s':'')" :paginator="$images">
          <x-slot name="head">
            <tr>
              <x-ui.th>#</x-ui.th>
              <x-ui.th>Preview</x-ui.th>
              <x-ui.th align="right">Actions</x-ui.th>
            </tr>
          </x-slot>
          @forelse($images as $img)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 text-xs text-gray-500">#{{ $img['id'] }}</td>
              <td class="px-6 py-4">
                <img src="{{ asset('storage/'.$img['image_path']) }}" class="w-24 h-24 object-cover rounded" />
              </td>
              <td class="px-6 py-4 text-right">
                <button wire:click="deleteImage({{ $img['id'] }})" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Delete</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">No images uploaded for this variant yet.</td>
            </tr>
          @endforelse
        </x-ui.admin-table>
      </div>
    </div>
  </div>
</div>
