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
                            type='icon' action='submit' size="text-3xl" />
                    </div>
                </div>
            </form>
            {{-- Filter Zone --}}
            @if ($userType == 'admin')
                {{-- Action Zone --}}
                <div class="flex justify-end ">
                    <div>
                        <x-pages.btn value='New Admin'
                            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    '
                            type='icon' data-modal-target="add-admin-modal" data-modal-toggle="add-admin-modal"
                            wire:click='resetForm()' />
                    </div>
                </div>
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
                        <x-pages.table.notFound colspan='6' />
                    @endif
                </x-pages.table.table>
                {{-- Table User --}}
            @endif
        @endif
    </div>
    {{-- Modal Edit / Add Users (Admin) --}}
    <x-pages.modal.modal id='add-admin-modal' title="{{ $is_edit == false ? 'New Schedule' : 'Edit Schedule' }}"
        submitFunction='save()'>
    </x-pages.modal.modal>
    {{-- Modal Edit / Add Users (Admin) --}}
</div>
