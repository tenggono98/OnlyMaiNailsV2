<div>
    <div>
        {{-- Button to open the drawer --}}
        <button wire:click="toggleDrawer" class="px-4 py-2 bg-blue-500 text-white">
            Toggle Drawer
        </button>

        {{-- Drawer --}}
        <div class="fixed inset-0 z-40 bg-gray-500 bg-opacity-35" x-show="$wire.isOpen" x-cloak>
            <div class="fixed left-0 top-0 h-full w-3/5 bg-white z-40 shadow-xl transition-transform transform"
                x-show="$wire.isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full">
                <div class="p-4">
                    <button wire:click="toggleDrawer" class="px-4 py-2 bg-red-500 text-white">
                        Close Drawer
                    </button>
                    <p class="mt-4">This is the drawer content.</p>
                </div>
            </div>
        </div>
    </div>
</div>
