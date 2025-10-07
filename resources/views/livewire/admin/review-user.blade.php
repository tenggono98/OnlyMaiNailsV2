<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <x-pages.admin.title-header-admin title="Review" />
    {{-- Filter Zone --}}
    {{-- Filter Zone --}}
    {{-- Action Zone --}}
    {{-- Action Zone --}}
    {{-- Table Zone --}}
    <x-ui.admin-table title="Reviews" :subtitle="count($review).' total'" :paginator="$review">
        <x-slot name="head">
            <tr>
                <x-ui.th>No</x-ui.th>
                <x-ui.th>User</x-ui.th>
                <x-ui.th>Booking Code</x-ui.th>
                <x-ui.th>Time & Date</x-ui.th>
                <x-ui.th>Comment</x-ui.th>
                <x-ui.th>Status</x-ui.th>
                <x-ui.th>Action</x-ui.th>
            </tr>
        </x-slot>
        @if (count($review) > 0)
            @foreach ($review as $row)
                <tr>
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $row->user->name ?? '' }}</td>
                    <td class="px-6 py-4">{{ $row->booking->code_booking ?? '' }}</td>
                    <td class="px-6 py-4">{{ Carbon\Carbon::parse($row->created_at)->format('l, d-m-Y h:i A') ?? '' }}</td>
                    <td class="px-6 py-4"><small class="text-wrap">{{ $row->description_review ?? '' }}</small></td>
                    <td class="px-6 py-4">
                        @if ($row->is_show_review == true)
                            <x-pages.badge type='success' value='Show' />
                        @else
                            <x-pages.badge type='danger' value='Hidden' />
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            @if ($row->is_show_review == false)
                                <div class=""><x-pages.btn value="Show" type="success" wire:click='toggleShow({{ $row->id }})' /></div>
                            @else
                                <div class=""><x-pages.btn value="Hidden" type="danger" wire:click='toggleShow({{ $row->id }})' /></div>
                            @endif
                            <div class=""></div>
                            @if ($row->status == false)
                                <div class=""><x-pages.btn value="Active" type="success" wire:click='toggleStatus({{ $row->id }})' /></div>
                                <div class=""><x-pages.btn value="Delete" type="danger" wire:click="confirmDelete('{{ $row->user->name }}',{{ $row->id }})" /></div>
                            @else
                                <div class=""><x-pages.btn value="Disable" type="danger" wire:click='toggleStatus({{ $row->id }})' /></div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr><td colspan='7' class="px-6 py-8 text-center">No data found</td></tr>
        @endif
    </x-ui.admin-table>
    {{-- Table Zone --}}
    {{-- Modal Zone --}}
    {{-- Modal Zone --}}
</div>
