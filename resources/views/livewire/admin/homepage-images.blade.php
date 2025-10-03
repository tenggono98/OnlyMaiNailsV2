<div>
    <div class="px-4">
        <x-pages.admin.title-header-admin title="Homepage Images" />

        <div class="mt-5">
            <!-- Section Tabs -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 rounded-t-lg {{ $section === 'header' ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}"
                                wire:click="switchSection('header')">
                            Header Section
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 rounded-t-lg {{ $section === 'promo' ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}"
                                wire:click="switchSection('promo')">
                            Promo Section
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Add Image Form -->
            <div class="mb-8 p-4 bg-white rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Add New Image</h3>
                
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
                            wire:key="image-cropper-{{ $section }}-{{ now()->timestamp }}"
                        />
                        
                        <!-- Show cropped image preview if available -->
                        @if($croppedImagePreview)
                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-green-800">Image Cropped Successfully!</h4>
                                        <p class="text-sm text-green-700">Your image has been cropped and is ready to be saved.</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img src="{{ $croppedImagePreview }}" alt="Cropped preview" class="w-16 h-16 object-cover rounded">
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Form Fields -->
                        <form wire:submit.prevent="save" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Alt Text</label>
                                    <input type="text" wire:model="altText" 
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('altText') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Display Order</label>
                                    <input type="number" wire:model="displayOrder" min="1"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('displayOrder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Add Image
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Direct Upload Form -->
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                            <input type="file" wire:model="newImage" accept="image/*" 
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">
                                Recommended image size: {{ $outputWidth }}x{{ $outputHeight }}px. Maximum file size: 64MB. Supported formats: JPG, PNG, WebP.
                            </p>
                            @error('newImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Alt Text</label>
                                <input type="text" wire:model="altText" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('altText') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Display Order</label>
                                <input type="number" wire:model="displayOrder" min="1"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('displayOrder') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Add Image
                        </button>
                    </form>
                @endif
            </div>

            <!-- Images List -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Alt Text</th>
                            <th scope="col" class="px-6 py-3">Order</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($images as $image)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-24 h-24 object-cover" alt="{{ $image->alt_text }}">
                            </td>
                            <td class="px-6 py-4">{{ $image->alt_text }}</td>
                            <td class="px-6 py-4">{{ $image->display_order }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $image->id }})"
                                    class="font-medium {{ $image->status ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $image->status ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="delete({{ $image->id }})"
                                    wire:confirm="Are you sure you want to delete this image?"
                                    class="font-medium text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr class="bg-white border-b">
                            <td colspan="5" class="px-6 py-4 text-center">No images found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    @if($isProcessingImage)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
             x-data="{ show: @entangle('isProcessingImage') }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="bg-white rounded-xl shadow-2xl p-8 text-center max-w-md mx-4">
                <!-- Loading Animation -->
                <div class="relative mb-6">
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-gray-200 mx-auto"></div>
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-600 border-t-transparent absolute top-0 left-1/2 transform -translate-x-1/2"></div>
                </div>
                
                <!-- Loading Content -->
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $processingMessage }}</h3>
                    <p class="text-gray-600 text-sm">This may take a few moments depending on image size</p>
                    
                    <!-- Progress Steps -->
                    <div class="mt-6 space-y-2">
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                            <span>Processing image...</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-400">
                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                            <span>Optimizing for web...</span>
                        </div>
                        <div class="flex items-center justify-center space-x-2 text-sm text-gray-400">
                            <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                            <span>Saving to database...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>