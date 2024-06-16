<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <x-pages.admin.title-header-admin title="Schedule" />



        {{-- Filter Zone --}}
        <form  wire:submit.prevent="search">
            <div class="flex flex-col gap-4 my-3 lg:flex lg:flex-row">



                @livewire('component.module.date-picker-range')



                <div class="flex-auto ">
                    <x-pages.inputs.select  wire:model='searchStatus'>
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="deactivate">Deactivate</option>
                    </x-pages.inputs.select>
                </div>


                <div class="flex items-center">
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
        {{-- Filter Zone --}}

        {{-- Action Zone --}}
        <div class="flex justify-end">

            <div>
                <x-pages.btn
                value='New Schedule'
                icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                  '
                type='icon'
                data-modal-target="add-modal"
                data-modal-toggle="add-modal"
                wire:click='resetForm()' />
            </div>


        </div>
        {{-- Action Zone --}}

        {{-- Table Zone --}}
        <x-pages.table.table :header="['No', 'Date', 'Time', 'status', 'Action']">
            @if (count($TScheduleData) > 0)
                @foreach ($TScheduleData as $key => $row)
                    <x-pages.table.tr>
                        <x-pages.table.td>
                            {{ $loop->iteration }}
                        </x-pages.table.td>
                        <x-pages.table.td class="text-nowrap">
                            {{ Carbon\Carbon::parse($row->date_schedule)->format('l , d F Y') }}
                        </x-pages.table.td>
                        <x-pages.table.td>

                            <ul class="flex gap-2">
                                @foreach ($row->times as $time)
                                    <li
                                        class="p-2 border rounded-lg {{ $time->is_book ? 'bg-green-500 text-white' : '' }} text-nowrap">
                                        {{ Carbon\Carbon::parse($time->time)->format('h:i A') }}</li>
                                @endforeach
                            </ul>

                        </x-pages.table.td>
                        <x-pages.table.td>
                            @if ($row->status == true)
                                <x-pages.badge type='success' value='Active' />
                            @else
                                <x-pages.badge type='danger' value='Deactivate' />
                            @endif
                        </x-pages.table.td>
                        <x-pages.table.td>

                            <div class="flex gap-2">
                                <div class="">
                                    <x-pages.btn value="Edit" type="info" data-modal-target="add-modal"
                                        data-modal-toggle="add-modal" wire:click='edit({{ $row->id }})' />
                                </div>
                                @if ($row->status == false)
                                    <div class="">
                                        <x-pages.btn value="Active" type="success"
                                            wire:click='toggleStatus({{ $row->id }})' />
                                    </div>
                                    <div class="">
                                        <x-pages.btn value="Delete" type="danger"
                                            wire:click="confirmDelete('{{ $row->name_service }}',{{ $row->id }})" />
                                    </div>
                                @else
                                    <div class="">
                                        <x-pages.btn value="Disable" type="danger"
                                            wire:click='toggleStatus({{ $row->id }})' />
                                    </div>
                                @endif


                            </div>

                        </x-pages.table.td>


                    </x-pages.table.tr>
                @endforeach
            @else
                <x-pages.table.notFound colspan='5' />


            @endif


        </x-pages.table.table>

        {{-- {{ $TScheduleData->links() }} --}}





        {{-- Table Zone --}}



    <x-pages.modal.modal id='add-modal' title="{{ $is_edit == false ? 'New Schedule' : 'Edit Schedule' }}"
        submitFunction='save()'>


        <div class="">
            <label for="">Date</label>
            @php
                $min_date =\Carbon\Carbon::today()->format('Y-m-d');
            @endphp
            <x-pages.inputs.text placeholder="" type='date' min='{{ $min_date}}' wire:model='scheduleDate' />
            <x-pages.inputs.error error='scheduleDate' />
        </div>

        <div class="container p-3 border rounded-lg">
            <label for="">Time</label>

            <div class="my-3">
                <x-pages.btn value="Add Time" wire:click='addTimeModal' />
            </div>


            <div class="flex flex-col gap-4 my-3">
                @for ($i = 0; $i < $timeCount; $i++)
                    <div class="flex w-full gap-3">
                        <div class="flex-auto">
                            <x-pages.inputs.text placeholder="" type='time'
                                wire:model.live='timeArray.{{ $i }}' />
                        </div>
                        <div class="flex items-center justify-center min-h-full">
                            <svg xmlns="http://www.w3.org/2000/svg" wire:click='deleteTimeModal({{ $i }})'
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="size-6 stroke-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>

                        </div>
                    </div>
                @endfor
                <x-pages.inputs.error error='timeArray' />


            </div>

        </div>




    </x-pages.modal.modal>

</div>
