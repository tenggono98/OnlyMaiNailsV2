<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="">
        <x-pages.admin.title-header-admin title="Booking" />
        {{-- Filter Zone --}}
        <form wire:submit.prevent="search">
            <div class="flex flex-col gap-4 my-3 lg:flex lg:flex-row">
                @livewire('component.module.date-picker-range')
                <div class="flex-auto ">
                    <x-pages.inputs.text placeholder='Search Code' wire:model='searchBookingCode' />
                </div>
                <div class="flex-auto ">
                    <x-pages.inputs.select wire:model='searchDepositStatus'>
                        <option value="">Select Status Deposit</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </x-pages.inputs.select>
                </div>
                <div class="flex-auto ">
                    <x-pages.inputs.select wire:model='searchStatus'>
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="deactivate">Deactivate</option>
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
        {{-- Action Zone --}}
        <div class="flex justify-end ">
            <div>
                <x-pages.btn value='New Booking'
                    icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                  '
                    type='icon' data-modal-target="add-modal" data-modal-toggle="add-modal"
                    wire:click='resetForm()' />
            </div>
        </div>
        {{-- Action Zone --}}
        {{-- Table Zone --}}
        <x-pages.table.table :header="['No', 'Client', 'Code', 'Date & Time', 'Status', 'Action']">
            @if (count($booking) > 0)
                @foreach ($booking as $key => $row)
                    <x-pages.table.tr>
                        <x-pages.table.td>
                            {{ $loop->iteration }}
                        </x-pages.table.td>
                        <x-pages.table.td>
                            {{ $row->client->name ?? '' }}
                        </x-pages.table.td>
                        <x-pages.table.td>
                            <div class="flex gap-3">
                                <div class="">
                                    {{ $row->code_booking }}
                                </div>
                                <div class="flex items-center">
                                    <button onclick="copyText('{{ $row->code_booking }}')" wire:click='notifCopy()'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="size-6 hover:stroke-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </x-pages.table.td>
                        <x-pages.table.td>
                            {{ Carbon\Carbon::parse($row->scheduleDateBook->date_schedule)->format('l , d F Y') }} |
                            {{ Carbon\Carbon::parse($row->scheduleTimeBook->time)->format('h:i A') }}
                        </x-pages.table.td>
                        <x-pages.table.td>
                            @if ($row->status == 1)
                                <x-pages.badge type='success' value='Active' />
                            @elseif($row->status == 0)
                                <x-pages.badge type='danger' value='Deactivate' />
                            @elseif($row->status == 'cancel')
                                <x-pages.badge type='danger' value='Cancel' />
                            @elseif($row->status == 'reschedule')
                                <x-pages.badge type='info' value='Reschedule' />
                            @elseif($row->status == 'completed')
                                <x-pages.badge type='success' value='Complete' />
                            @endif
                        </x-pages.table.td>
                        <x-pages.table.td>
                            <div x-data="{ open: false }" class="relative flex items-center"
                                x-id="['menu-{{ $key }}']">
                                <!-- Three Dots Button -->
                                <div @mouseenter="open = true" @click="open = !open">
                                    <button class="text-gray-500 hover:text-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zM12 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zM17.25 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0z" />
                                        </svg>
                                    </button>
                                    <!-- Menu -->
                                    <div x-show="open"
                                        class="absolute z-40 w-auto mt-2 bg-white rounded-md shadow-lg -left-20 ring-1 ring-black ring-opacity-5"
                                        @mouseenter="open = true" @click.away="open = false" @mouseleave="open = false">
                                        <div class="flex flex-col py-1">
                                            <button
                                                class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                wire:click="bookmarkGoogleCalendar({{ $row->user_id }},{{ $row->id }})">
                                                Google Calender
                                            </button>
                                            <button
                                                class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                wire:click="edit({{ $row->id }})" data-modal-target="add-modal"
                                                data-modal-toggle="add-modal">
                                                Edit
                                            </button>
                                            <button
                                                class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                wire:click="bookmarkGoogleCalendar({{ $row->user_id }},{{ $row->id }})">
                                                Reschedule
                                            </button>
                                            @if ($row->status == false)
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                    wire:click="toggleStatus({{ $row->id }})">
                                                    Activate
                                                </button>
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                    wire:click="confirmDelete('{{ $row->name_service }}', {{ $row->id }})">
                                                    Delete
                                                </button>
                                            @else
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                    wire:click="toggleStatus({{ $row->id }})"
                                                    wire:confirm='Are you sure want to disable / cancel this booking ?'
                                                    >
                                                    Disable
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-pages.table.td>
                    </x-pages.table.tr>
                    <x-pages.table.tr>
                        <x-pages.table.td colspan='6'>
                            <div class="flex gap-10 ">
                                <div class="flex flex-col gap-4">
                                    <div class="">
                                    <p class="font-semibold">Deposit Payment</p>
                                    <div class="flex flex-col gap-2">
                                        <div class="">
                                            @if ($row->is_deposit_paid == true)
                                                <x-pages.badge type='success' value='Paid' />
                                            @else
                                                <x-pages.badge type='danger' value='No Paid' />
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                    <div class="">
                                        <p class="font-semibold">With Tax?</p>
                                        @if ($row->total_price_after_tax_booking !== null)
                                            <x-pages.badge type='success' value='Yes' />
                                        @else
                                            <x-pages.badge type='danger' value='No' />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col ">
                                    <div class="">
                                        <p class="">Total Payment (After Deposit
                                            ${{ $row->deposit_price_booking }})</p>
                                        <p class="text-xl font-semibold">$
                                            {{ $row->total_price_booking - $row->deposit_price_booking }}</p>
                                    </div>
                                    <div class="">
                                        <p class="">Total Payment (Before Deposit)</p>
                                        <p class="text-xl font-semibold">$ {{ $row->total_price_booking }}</p>
                                    </div>
                                    @if ($row->total_price_after_tax_booking !== null)
                                        <div class="">
                                            <p class="">Total Payment With Tax (Before Deposit)</p>
                                            <p class="text-xl font-semibold">$ {{ $row->total_price_after_tax_booking }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-48 w-fit">
                                    <p class="">Services</p>
                                    <ul>
                                        @foreach ($row->detailService as $serv)
                                            <li class="text-lg">
                                                <p class="font-semibold text-wrap">({{ $serv->service->category->name_service_categori }})
                                                {{ $serv->name_service }}</p></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="w-full">
                                    <p class="">Number of Person</p>
                                    <p class="font-semibold">{{ $row->qty_people_booking }}</p>
                                    <p class="">Created By</p>
                                    <p class="font-semibold">{{ $row->admin_created->name ?? '-' }} | {{  Str::upper($row->admin_created->role ?? '-') }}</p>
                                    <p class="">Updated By</p>
                                    <p class="font-semibold">{{ $row->admin_updated->name ?? '-' }}  {{ Str::upper($row->admin_updated->role ?? '-')  }}</p>
                                </div>
                                @if($row->status !== 'cancel'  && $row->status !== 'reschedule' || $row->reschedule_booking_original_id !== null )
                                @if($row->status !== '0')
                                <div class="flex flex-col w-full gap-3">
                                    <div class="">
                                        @if ($row->status !== 'completed')
                                            <div class="">
                                                <x-pages.btn type="success" value="Complete" class="w-full"
                                                    wire:click="completeBooking({{ $row->id }})"
                                                    wire:confirm="Are you sure you want to complete this booking status?"
                                                    wire:loading.attr="disabled" wire:target="completeBooking">
                                                    <!-- Default text -->
                                                    <span wire:loading.remove
                                                        wire:target="completeBooking">Complete</span>
                                                    <!-- Loading text with spinner -->
                                                    <span wire:loading wire:target="completeBooking"
                                                        class="animate-pulse">Loading...</span>
                                                </x-pages.btn>
                                            </div>
                                        @else
                                            <div class="">
                                                <x-pages.btn type='danger' value='Uncomplete'
                                                    wire:click='completeBooking({{ $row->id }})'
                                                    wire:confirm="Are you sure you want to  revoke this booking status?" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="">
                                        @if ($row->is_deposit_paid == false)
                                            <div class="">
                                                <x-pages.btn type="success" value="Verify Deposit"
                                                    wire:click="confirmDepositPayment({{ $row->id }})"
                                                    wire:confirm="Are you sure you want to verify this deposit status?"
                                                    wire:loading.attr="disabled" wire:target="confirmDepositPayment">
                                                    <!-- Default text -->
                                                    <span wire:loading.remove
                                                        wire:target="confirmDepositPayment">Verify Deposit</span>
                                                    <!-- Loading text with spinner -->
                                                    <span wire:loading wire:target="confirmDepositPayment"
                                                        class="animate-pulse">Loading...</span>
                                                </x-pages.btn>
                                            </div>
                                        @else
                                            <div class="">
                                                <x-pages.btn type='danger' value=' Revoke Deposit'
                                                    wire:click='confirmDepositPayment({{ $row->id }})'
                                                    wire:confirm="Are you sure you want to  revoke this deposit status?" />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @else
                                <div class="w-full">
                                <p class="">Reschedule To</p>
                                <p class="font-semibold">{{ $row->reschedule->code_booking  }}</p>
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
        {{-- Table Zone --}}
    </div>
    {{-- Modal Zone --}}
    <x-pages.modal.modal id='add-modal' title="{{ $is_edit == false ? 'New Booking' : 'Edit Booking' }}"
        submitFunction='save()'>
        <div class="">
            <label for="">Select Customer</label>
            <livewire:component.module.customer-selector wire:model.live="clientBook" />
            <x-pages.inputs.error error="clientBook" />
        </div>
        <div class="">
            <label for="">Select Services</label>
            <livewire:component.module.service-selector wire:model.live="servicsBook" />
            <x-pages.inputs.error error="servicsBook" />
        </div>
        <div class="">
            <label for="">Number of Customer</label>
            <x-pages.inputs.select wire:model.live='qtyBook'>
                @for ($i = 1; $i < 50; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </x-pages.inputs.select>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div class="">
                <label for="">Total Price</label>
                <h1>$ {{ $totalPriceBook }}</h1>
            </div>
            <div class="">
                <x-pages.inputs.toggle id="tax" wire:model='tax' label='Include Tax ?' :checked="$tax"
                    wire:click="$refresh" />
            </div>
        </div>
        <div class="">
            <label for="">Select Schedule</label>
            @if ($is_edit)
                @livewire('component.module.schedule-selector', ['getSelectedTime' => $timeBook, 'getSelectedDate' => $dateBook, 'getIndexDate' => '1'])
            @else
                @livewire('component.module.schedule-selector')
            @endif
            <x-pages.inputs.error error="dateBook" />
            <x-pages.inputs.error error="timeBook" />
        </div>
    </x-pages.modal.modal>
    {{-- Modal Zone --}}
    {{-- Extra Script Zone --}}
    <script>
        function copyText(text) {
            /* Copy selected text into clipboard */
            navigator.clipboard.writeText(text);
        }
    </script>
    {{-- Extra Script Zone --}}
</div>
