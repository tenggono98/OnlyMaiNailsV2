<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="">
        @if ($userType == null)
            <x-pages.admin.title-header-admin title="Select Account Type" />
            <div class="mt-5">
                <div class="flex flex-wrap items-center gap-4 justify-normal">
                    <div class="flex-auto ">
                        <a href="{{ route('admin.users.type', ['type' => 'admin']) }}">
                            <button
                                class="w-full p-4 text-2xl text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-400">Admin</button>
                        </a>
                    </div>
                    <div class="flex-auto ">
                        <a href="{{ route('admin.users.type', ['type' => 'user']) }}">
                            <button
                                class="w-full p-4 text-2xl text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-400">User</button>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <x-pages.admin.title-header-admin title="Account {{ Str::ucfirst($userType) }}" />
            {{-- Filter Zone --}}
            <form wire:submit.prevent="search">
                <div class="flex flex-col gap-4 my-3 lg:flex lg:flex-row">
                    <div class="flex-auto ">
                        <x-pages.inputs.text placeholder='Search Name or Email' wire:model='searchNameOrEmailUser' />
                    </div>
                    <div class="flex-auto ">
                        <x-pages.inputs.select wire:model='searchStatusUser'>
                            <option value="">Select Status </option>
                            <option value="1">Active</option>
                            <option value="0">Unactive</option>
                        </x-pages.inputs.select>
                    </div>
                    <div class="flex items-center">
                        <x-pages.btn value=''
                            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                      </svg>
                      '
                            type='icon' action='submit' size="text-3xl"  />
                    </div>
                </div>
            </form>
            {{-- Filter Zone --}}
            {{-- Action Zone --}}
            <div class="flex justify-end ">
                <div>
                    <x-pages.btn value='New {{ ucfirst($userType) }}'
                        icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                '
                        type='icon' data-modal-target="add-modal" data-modal-toggle="add-modal"
                        wire:click='resetForm()' />
                </div>
            </div>
            {{-- Action Zone --}}
            @if ($userType == 'admin')
                {{-- Table Admin --}}
                <x-pages.table.table :header="['No', 'Name', 'Email', 'Status', 'Action']">
                    @if (count($users) > 0)
                        @foreach ($users as $row)
                            <x-pages.table.tr>
                                <x-pages.table.td>
                                    {{ $loop->iteration }}
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    {{ $row->name }}
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    {{ $row->email }}
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    @if ($row->status == 1)
                                        <x-pages.badge type='success' value='Active' />
                                    @elseif($row->status == 0)
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
                                                    wire:click="confirmDelete('{{ $row->name }}',{{ $row->id }})" />
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
                        <x-pages.table.notFound colspan='6' />
                    @endif
                </x-pages.table.table>
                {{-- Table Admin --}}
            @elseif($userType == 'user')
                {{-- Table User --}}
                <x-pages.table.table :header="['No', 'Name', 'Email', 'Order', 'Warning Notes', 'Status', 'Action']">
                    @if (count($users) > 0)
                        @foreach ($users as $row)
                            <x-pages.table.tr>
                                <x-pages.table.td>
                                    {{ $loop->iteration }}
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    {{ $row->name }}
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    {{ $row->email }}
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    <span class="font-semibold">{{ count($row->total_order) }}</span> Order
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    <span
                                        class="font-semibold text-red-400">{{ count($row->warningNotes ?? 0) }}</span>
                                    Notes
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    @if ($row->status == 1)
                                        <x-pages.badge type='success' value='Active' />
                                    @elseif($row->status == 0)
                                        <x-pages.badge type='danger' value='Deactivate' />
                                    @endif
                                </x-pages.table.td>
                                <x-pages.table.td>
                                    <div class="flex gap-2">
                                        <div class="">
                                            <x-pages.btn value="Notes" type="info" data-modal-target="warning-modal"
                                                data-modal-toggle="warning-modal"
                                                wire:click='viewWarningNotes({{ $row->id }})' />
                                        </div>
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
                                                    wire:click="confirmDelete('{{ $row->name }}',{{ $row->id }})" />
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
                        <x-pages.table.notFound colspan='7' />
                    @endif
                </x-pages.table.table>
                {{-- Table User --}}
            @endif
        @endif
    </div>
    {{-- Modal Edit / Add Users (Admin / User) --}}
    <x-pages.modal.modal id='add-modal'
        title="{{ $is_edit == false ? 'New ' . ucfirst($userType) : 'Edit ' . ucfirst($userType) }}"
        submitFunction='save()'>
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
            <div class="">
                <label for="">Fullname <span class="text-red-600">*</span></label>
                <x-pages.inputs.text placeholder='John Doe' wire:model='fullnameUser' />
            </div>
            <div class="">
                <label for="">Phone </label>
                <x-pages.inputs.text placeholder='+1' wire:model='phoneUser' />
            </div>
            <div class="">
                <label for="">Email <span class="text-red-600">*</span></label>
                <x-pages.inputs.text type='email' placeholder='jhondoe@gmail.com' wire:model='emailUser' />
            </div>
            <div class="">
                <label for="">Password <span class="text-red-600">*</span></label>
                <x-pages.inputs.text type='password' placeholder='' wire:model='passwordUser' />
                {!! ($is_edit == true) ? "<small class='text-xs'>Leave blank if you dont want to change the password</small>" : '' !!}
            </div>
            @if ($userType == 'user')
                <div class="lg:col-span-2">
                    <label for="">Instagram </label>
                    <x-pages.inputs.text type='text' placeholder='@' wire:model='igUser' class="w-full" />
                </div>
            @endif
        </div>
    </x-pages.modal.modal>
    {{-- Modal Edit / Add Users (Admin / User) --}}
    {{-- Modal warning notes --}}
    <x-pages.modal.modal id='warning-modal' title="Warning Notes for {{ $nameUserWarningNotes }}"
        submitFunction='saveNote()'>
        <p class="text-2xl">Notes Warning (<span>{{ count($userNotesWarning ?? []) }})</span></p>
        <div class="grid grid-cols-1 gap-3 overflow-y-scroll max-h-52">
            @if ( $userNotesWarning !== null && count($userNotesWarning) > 0 )
                @foreach ($userNotesWarning as $note)
                    <div class="p-3 border rounded-lg">
                        <div class="flex justify-between">
                            <div class="">
                                Created By <span class="font-semibold">{{ $note->account->name }}</span>
                            </div>
                            <div class="">
                                Created At <span class="font-semibold">{{ $note->created_at }}</span>
                            </div>
                        </div>

                        <p class="my-3">{{ $note->description_warning_note }}</p>

                        <div class="flex gap-3">
                            <div class="flex-auto">
                                    <x-pages.btn value="Edit" type="info" data-modal-target="add-modal"
                                        data-modal-toggle="add-modal" wire:click='editInlineNote({{ $row->id }})' />
                            </div>
                            <div class="flex-auto">
                                <x-pages.btn value="Delete" wire:confirm='Are you sure want to delete this note ?' type="danger"
                                     wire:click='DeleteInlineNote({{ $row->id }})' />
                        </div>

                        </div>
                    </div>
                @endforeach
            @else
                <h1 class="text-center"><span class="font-semibold">{{ $nameUserWarningNotes }}</span> has no warning notes for now</h1>
            @endif
        </div>



        <p>Adding Notes</p>
        <div class="my-2">
            <x-pages.inputs.textarea wire:model='descriptionWarningNote' />
        </div>
    </x-pages.modal.modal>
    {{-- Modal warning notes --}}
</div>
