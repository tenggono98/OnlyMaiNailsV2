<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <x-pages.admin.title-header-admin title="Review" />
    {{-- Filter Zone --}}
    {{-- Filter Zone --}}
    {{-- Action Zone --}}
    {{-- Action Zone --}}
    {{-- Table Zone --}}
    <x-pages.table.table :header="['No', 'User', 'Booking Code', 'Time & Date', 'Comment', 'Status', 'Action']">
        @if (count($review) > 0)
            @foreach ($review as $row)
                <x-pages.table.tr>
                    <x-pages.table.td>
                        {{ $loop->iteration }}
                    </x-pages.table.td>
                    <x-pages.table.td>
                        {{ $row->user->name ?? '' }}
                    </x-pages.table.td>
                    <x-pages.table.td>
                        {{ $row->booking->code_booking ?? '' }}
                    </x-pages.table.td>
                    <x-pages.table.td>
                        {{ Carbon\Carbon::parse($row->created_at)->format('l, d-m-Y h:i A') ?? '' }}
                    </x-pages.table.td>
                    <x-pages.table.td>
                        <small class="text-wrap">{{ $row->description_review ?? '' }}</small>
                    </x-pages.table.td>
                    <x-pages.table.td>
                        @if ($row->is_show_review == true)
                            <x-pages.badge type='success' value='Show' />
                        @else
                            <x-pages.badge type='danger' value='Hidden' />
                        @endif
                    </x-pages.table.td>
                    <x-pages.table.td>
                        <div class="flex gap-2">
                            @if ($row->is_show_review == false)
                                <div class="">
                                    <x-pages.btn value="Show" type="success"
                                        wire:click='toggleShow({{ $row->id }})' />
                                </div>
                            @else
                                <div class="">
                                    <x-pages.btn value="Hidden" type="danger"
                                        wire:click='toggleShow({{ $row->id }})' />
                                </div>
                            @endif
                            <div class="">
                                {{-- <x-pages.btn value="Edit" type="info" data-modal-target="add-modal"
                            data-modal-toggle="add-modal" wire:click='edit({{ $row->id }})' /> --}}
                            </div>
                            @if ($row->status == false)
                                <div class="">
                                    <x-pages.btn value="Active" type="success"
                                        wire:click='toggleStatus({{ $row->id }})' />
                                </div>
                                <div class="">
                                    <x-pages.btn value="Delete" type="danger"
                                        wire:click="confirmDelete('{{ $row->user->name }}',{{ $row->id }})" />
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
    {{-- Table Zone --}}
    {{-- Modal Zone --}}
    {{-- Modal Zone --}}
</div>
