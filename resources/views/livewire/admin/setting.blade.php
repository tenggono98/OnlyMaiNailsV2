<div>
    <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
        <x-pages.admin.title-header-admin title="Settings" />
        
        <form wire:submit='save()'>
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Tax Input -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">%</span>
                            <div class="w-full">
                                <x-pages.inputs.text wire:model='tax' class="pl-8" />
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">If the tax amount is greater than 0, it will be automatically applied to every transaction.</p>
                    </div>

                    <!-- Deposit Input -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deposit</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                            <div class="w-full">
                                <x-pages.inputs.text wire:model='deposit' class="pl-8" />
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">The deposit amount that the customer needs to pay in advance to secure their order.</p>
                    </div>

                    <!-- Email Payment -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email Payment</label>
                        <x-pages.inputs.text wire:model='emailPayment' />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Email address where the customer can send the deposit and remaining payment.</p>
                    </div>

                    <!-- Deposit Time Limit -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deposit Time Limit</label>
                        <div class="relative">
                            <x-pages.inputs.text wire:model='limitDepositTime' />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">Hours</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Time limit for the customer to pay the deposit before the order is automatically canceled.</p>
                    </div>

                    <!-- Instagram -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instagram</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">@</span>
                            <div class="w-full">
                                <x-pages.inputs.text wire:model='instagram' class="pl-8" />
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Instagram handle for the business.</p>
                    </div>

                    <!-- Address -->
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <x-pages.inputs.text wire:model='address' />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Business address.</p>
                    </div>

                    <!-- Google Maps Embed Link -->
                    <div class="col-span-2 mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Google Maps Embed Link</label>
                        <x-pages.inputs.textarea wire:model='gmap_links' rows="3" />
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Embed link for Google Maps location.
                            <div class="mt-2 ml-4">
                                <p class="font-medium">To get the embed link:</p>
                                <ol class="ml-4 list-decimal">
                                    <li>Open Google Maps and search for the location you want to embed.</li>
                                    <li>Click on the "Share" button.</li>
                                    <li>Select the "Embed a map" tab.</li>
                                    <li>Copy the URL inside the src attribute of the iframe provided.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <x-pages.btn value='Save' action='submit' wire:click='$refresh' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" />
            </div>
        </form>
    </div>
</div>
