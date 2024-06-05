<div>
    {{-- The best athlete wants his opponent at his best. --}}

    <div class="">
        <x-pages.admin.title-header-admin title="Service" />


        {{-- Fitlter Zone --}}
        <form wire:submit.prevent="search">
        <div class="flex gap-4 my-3">

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
            <div class="flex items-center">
                <x-pages.btn value="Find" action='submit'  />
            </div>


        </div>
        </form>

        {{-- Fitlter Zone --}}


        {{-- Action Zone --}}
        <div class="flex justify-end ">

            <div >
                <x-pages.btn value="Add" data-modal-target="add-modal" data-modal-toggle="add-modal" wire:click='resetForm()'   />
            </div>

        </div>
        {{-- Action Zone --}}



        {{-- Table Zone --}}
        <x-pages.table.table :header="['No','Category','Service Name','Price','Addons','status','Action']">
            @foreach ($service as $key => $row)
            <x-pages.table.tr>
                <x-pages.table.td>
                    {{ $key + 1 }}
                </x-pages.table.td>
                <x-pages.table.td>
                    {{ $row->category->name_service_categori }}
                </x-pages.table.td>
                <x-pages.table.td>
                    {{ $row->name_service }}
                </x-pages.table.td>
                <x-pages.table.td>
                    ${{ $row->price_service }}
                </x-pages.table.td>
                <x-pages.table.td>
                    @if($row->is_merge == true)
                    <x-pages.badge type='success' value='True' />
                @else
                    <x-pages.badge type='danger' value='False' />
                @endif
                </x-pages.table.td>
                <x-pages.table.td>
                    @if($row->status == true)
                        <x-pages.badge type='success' value='Active' />
                    @else
                        <x-pages.badge type='danger' value='Deactivate' />
                    @endif
                </x-pages.table.td>
                <x-pages.table.td>

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

                </x-pages.table.td>

            </x-pages.table.tr>

            @endforeach


        </x-pages.table.table>
        {{-- Table Zone --}}



    </div>


      {{-- Modal Zone --}}

      <x-pages.modal.modal  id='add-modal' title="{{ ($is_edit == false)?'New Service':'Edit Service' }}" submitFunction='save()' >


        <div class="grid grid-cols-2 gap-3">
            <div class="">
                <label for="">Service Category</label>
                <x-pages.inputs.select wire:model='serviceCategory'>
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
            <div class="pt-5">

                <x-pages.inputs.toggle id="serviceIsMerge" wire:model='isMerge'  label='Is Addons ?' :checked="$isMerge"  />
            </div>

        </div>

    </x-pages.modal.modal>

    {{-- Modal Zone --}}
</div>
