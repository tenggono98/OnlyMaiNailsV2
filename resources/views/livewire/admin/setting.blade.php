<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="">
        <x-pages.admin.title-header-admin title="Setting" />
        <form wire:submit='save()'>
            <div class="mt-5">
                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div class="items-center gap-3 ">
                        <label>Tax</label>
                        <div class="flex items-center gap-3 ">
                            <p class="px-2 py-4">%</p>
                            <div class="flex-auto">
                                <x-pages.inputs.text wire:model='tax' />
                            </div>
                        </div>
                        <small>If the tax amount is greater than 0, it will be automatically applied to every
                            transaction.</small>
                    </div>
                    <div class="items-center gap-3 ">
                        <label>Deposit</label>
                        <div class="flex items-center gap-3 ">
                            <p class="px-2 py-4">$</p>
                            <div class="flex-auto">
                                <x-pages.inputs.text wire:model='deposit' />
                            </div>
                        </div>
                        <small>The deposit amount that the customer needs to pay in advance to secure their
                            order.</small>
                    </div>
                    <div class="items-center gap-3 ">
                        <label>Email Payment</label>
                        <x-pages.inputs.text wire:model='emailPayment' />
                        <small>Email address where the customer can send the deposit and remaining payment.</small>
                    </div>
                    <div class="items-center gap-3 ">
                        <label>Deposit Time Limit</label>
                        <div class="flex items-center gap-3 ">
                            <p class="py-4 ">Hours</p>
                            <div class="flex-auto">
                                <x-pages.inputs.text wire:model='limitDepositTime' />
                            </div>
                        </div>
                        <small>Time limit for the customer to pay the deposit before the order is automatically
                            canceled.</small>
                    </div>

                    <div class="items-center gap-3 ">
                        <label>Instagram</label>
                        <div class="flex items-center gap-3 ">
                            <p class="px-2 py-4">@</p>
                            <div class="flex-auto">
                                <x-pages.inputs.text wire:model='instagram' />
                            </div>
                        </div>
                        <small>Instagram handle for the business.</small>
                    </div>
                    <div class="items-center gap-3 ">
                        <label>Address</label>
                        <div class="flex items-center gap-3 ">
                            <div class="flex-auto">
                                <x-pages.inputs.text wire:model='address' />
                            </div>
                        </div>
                        <small>Business address.</small>
                    </div>
                    <div class="items-center gap-3 col-span-2 ">
                        <label>Google Maps Embed Link</label>
                        <div class="flex items-center gap-3 ">
                            <div class="flex-auto">
                                <x-pages.inputs.textarea wire:model='gmap_links' />
                            </div>
                        </div>
                        <small class="px-3">Embed link for Google Maps location.
                            To get the embed link, follow these steps:
                            <ol class="px-4">
                                <li>Open Google Maps and search for the location you want to embed.</li>
                                <li>Click on the "Share" button.</li>
                                <li>Select the "Embed a map" tab.</li>
                                <li>Copy the URL inside the src attribute of the iframe provided.</li>
                            </ol>
                        </small>
                    </div>
                </div>
            </div>
    </div>
    <div class="my-5">
        <x-pages.btn value='Save' action='submit' wire:click='$refresh' />
    </div>
    </form>


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Settings Promotion Banner</h4>
        </div>
        <div class="card-body">
            <small class="mb-4 block">Recommended banner image size: 1024 x 144 pixels</small>

            <form wire:submit.prevent="saveBanner">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h5>Current Banners</h5>
                        <button type="button" class="btn btn-primary" wire:click="$toggle('showAddBanner')">
                            Add New Banner
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Image</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                <tr>
                                    <td class="px-4 py-2">
                                        <img src="{{ $banner->image_url }}" alt="Banner" class="h-16">
                                    </td>
                                    <td class="px-4 py-2">
                                        <button type="button" class="btn btn-danger" 
                                            wire:click="deleteBanner({{ $banner->id }})"
                                            wire:confirm="Are you sure you want to delete this banner?">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-2 text-center">No banners found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($showAddBanner)
                    <div class="p-4 border rounded">
                        <h6>Add New Banner</h6>
                        <input type="file" wire:model="bannerImage" accept="image/*" class="mt-2">
                        @error('bannerImage') <span class="text-red-500">{{ $message }}</span> @enderror
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Upload Banner</button>
                            <button type="button" class="btn btn-secondary" wire:click="$toggle('showAddBanner')">Cancel</button>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>



</div>
