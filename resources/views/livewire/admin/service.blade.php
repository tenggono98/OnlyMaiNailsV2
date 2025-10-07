<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="">
        <x-pages.admin.title-header-admin title="Service" />
        {{-- Fitlter Zone --}}
        <form wire:submit.prevent="search">
            <div class="flex flex-col gap-4 my-3 lg:flex lg:flex-row">
                <div class="flex-auto">
                    <x-pages.inputs.search placeholder='Search Service Name' wire:model='searchName'/>
                </div>
                <div class="flex-auto">
                    <x-pages.inputs.select wire:model='searchCategory'>
                            <option value="">Select Category</option>
                        @foreach ($category as $item )
                            <option value="{{ $item->id }}">{{ $item->name_service_categori }}</option>
                        @endforeach
                    </x-pages.inputs.select>
                </div>
                <div class="flex-auto">
                    <x-pages.inputs.select wire:model='searchStatus'>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="deactivate">Deactivate</option>
                    </x-pages.inputs.select>
                </div>
                <div class="flex ">
                    <x-pages.btn
                    value=''
                    icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                      </svg>
                      '
                      type='icon'
                    action='submit'
                    size="text-3xl"  />
                </div>
            </div>
        </form>
        {{-- Fitlter Zone --}}
        {{-- Action Zone --}}
        <div class="flex justify-end ">
            <div >
                <x-pages.btn
                value='New Service'
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                  '
                type='icon'
                data-modal-target="add-modal"
                data-modal-toggle="add-modal"
                wire:click='resetForm()'   />
            </div>
        </div>
        {{-- Action Zone --}}
        {{-- Table Zone --}}
        <x-ui.admin-table title="Services" :subtitle="count($service).' total'" :paginator="$service">
            <x-slot name="head">
                <tr>
                    <x-ui.th>No</x-ui.th>
                    <x-ui.th>Category</x-ui.th>
                    <x-ui.th>Service Name</x-ui.th>
                    <x-ui.th>Price</x-ui.th>
                    <x-ui.th>Addons</x-ui.th>
                    <x-ui.th>Sort</x-ui.th>
                    <x-ui.th>Status</x-ui.th>
                    <x-ui.th>Action</x-ui.th>
                </tr>
            </x-slot>
            @if(count($service) > 0)
                @foreach ($service as $key => $row)
                    <tr>
                        <td class="px-6 py-4">{{ $key + 1 }}</td>
                        <td class="px-6 py-4">{{ $row->category->name_service_categori }}</td>
                        <td class="px-6 py-4">{{ $row->name_service }}</td>
                        <td class="px-6 py-4">{{ getSettingWeb('Currency') }} {{ $row->price_service }}</td>
                        <td class="px-6 py-4">
                            @if($row->is_merge == true)
                                <x-pages.badge type='success' value='True' />
                            @else
                                <x-pages.badge type='danger' value='False' />
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $row->order }}</td>
                        <td class="px-6 py-4">
                            @if($row->status == true)
                                <x-pages.badge type='success' value='Active' />
                            @else
                                <x-pages.badge type='danger' value='Deactivate' />
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <div class="">
                                    <x-pages.btn value="Edit" type="info" data-modal-target="add-modal" data-modal-toggle="add-modal" wire:click='edit({{ $row->id }})' />
                                </div>
                                @if($row->status == false)
                                    <div class="">
                                        <x-pages.btn value="Active" type="success" wire:click='toggleStatus({{ $row->id }})' />
                                    </div>
                                    <div class="">
                                        <x-pages.btn value="Delete" type="danger" wire:click="confirmDelete('{{ $row->name_service }}',{{ $row->id }})" />
                                    </div>
                                @else
                                    <div class="">
                                        <x-pages.btn value="Disable" type="danger" wire:click='toggleStatus({{ $row->id }})' />
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan='8' class="px-6 py-8 text-center">No data found</td></tr>
            @endif
        </x-ui.admin-table>
        {{-- Table Zone --}}
    </div>
      {{-- Modal Zone --}}
      <x-pages.modal.modal  id='add-modal' title="{{ ($is_edit == false)?'New Service':'Edit Service' }}" submitFunction='save()' >
        <div class="grid grid-cols-2 gap-3">
            <div class="">
                <label for="">Service Category</label>
                <x-pages.inputs.select wire:model='serviceCategory' wire:change='serviceOrderCategory()'>
                    <option value="">Select Category</option>
                    @foreach ($category as $item)
                        <option value="{{ $item->id }}">{{ $item->name_service_categori }}</option>
                    @endforeach
                </x-pages.inputs.select>
               <x-pages.inputs.error error='serviceCategory' />
            </div>
            <div class="">
                <label for="">Service Name</label>
                <x-pages.inputs.text wire:model='serviceName'/>
                <x-pages.inputs.error error='serviceName' />
            </div>
            <div class="">
                <label for="">Service Price</label>
                <x-pages.inputs.currency wire:model='servicePrice' />
                <x-pages.inputs.error error='servicePrice' />
            </div>
            <div class="">
                <label for="">Order After</label>
                <x-pages.inputs.text wire:model='serviceOrder' type='number' min='0' />
                <x-pages.inputs.error error='serviceOrder' />
            </div>
            <div class="pt-5">
                <x-pages.inputs.toggle id="serviceIsMerge" wire:model='isMerge'  label='Is Addons ?' :checked="$isMerge"  />
            </div>
        </div>
    </x-pages.modal.modal>
    {{-- Modal Zone --}}
</div>
