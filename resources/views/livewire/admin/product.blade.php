<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <x-pages.admin.title-header-admin title="Product" />


    {{-- Filter Zone --}}
    <form  wire:submit.prevent="search">
        <div class="flex flex-col gap-4 my-3 lg:flex lg:flex-row">

            <div class="flex-auto ">
                <x-pages.inputs.select  wire:model='searchStatus'>
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="deactivate">Deactivate</option>
                </x-pages.inputs.select>
            </div>

        </div>

    </form>
    {{-- Filter Zone --}}

    {{-- Action Zone --}}
    {{-- Action Zone --}}

    {{-- Table Zone --}}
    {{-- Table Zone --}}
</div>
