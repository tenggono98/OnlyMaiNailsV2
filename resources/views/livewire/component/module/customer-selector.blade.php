<div>
    {{-- Care about people's approval and you will be their prisoner. --}}


        <div class="relative mb-2">
            <input type="text" id="search" wire:model.live="searchTerm" class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg g-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search client...">
            @if($clientBook)
                <button wire:click="clearSelection" type="button" class="absolute top-0 right-0 px-4 py-1 mt-2 mr-2 text-white bg-red-500 rounded-md hover:bg-red-600 focus:outline-none">Cancel</button>
            @endif
        </div>

        @if($searchTerm !== '')
            @if($customers && count($customers) > 0)
                <ul class="overflow-y-auto bg-white border border-gray-200 rounded-md shadow-md list-group max-h-60">
                    @foreach($customers as $customer)
                        <li class="px-4 py-2 border-b border-gray-200 hover:bg-gray-100">
                            <a href="#" wire:click.prevent="selectCustomer({{ $customer->id }})" class="text-blue-600 hover:text-blue-800">
                                {{ $customer->name }} - {{ $customer->email }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

        @endif

        @if($clientBook)
            <div class="p-2 mt-2 text-green-700 bg-green-100 border border-green-400 rounded-md">
                Selected Customer: {{ $clientBook['name'] }}
            </div>
        @endif

</div>
