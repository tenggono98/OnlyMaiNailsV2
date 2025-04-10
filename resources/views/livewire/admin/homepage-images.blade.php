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
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 rounded-t-lg {{ $section === 'login' ? 'text-blue-600 border-b-2 border-blue-600' : 'hover:text-gray-600 hover:border-gray-300' }}"
                                wire:click="switchSection('login')">
                            Login Section
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Add Image Form -->
            <div class="mb-8 p-4 bg-white rounded-lg shadow">

                <h3 class="text-lg font-semibold mb-4">Add New Image</h3>
                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Image</label>
                        <input type="file" wire:model="newImage" accept="image/*"
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1 text-sm text-gray-500">
                            Recommended image size: 1920x1080px. Maximum file size: 2MB. Supported formats: JPG, PNG, WebP.
                        </p>
                        @error('newImage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

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

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Add Image
                    </button>
                </form>
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
</div>
