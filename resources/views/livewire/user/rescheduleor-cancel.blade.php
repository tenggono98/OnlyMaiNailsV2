<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="">
        <h1 class="mb-3">Your Booking Information</h1>
        <div class="border border-[#fadde1] rounded-lg p-4">
            <div class="grid lg:grid-cols-5">
                <div class="lg:col-span-3">
                    <a class="p-4 underline hover:text-[#fadde1]" target="_blank" href="{{ route('book') }}">Our
                        Policies</a>
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 ">
                        <div class="flex items-center gap-3 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="p-2 border rounded-full size-14 border-[#fadde1]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            <div class="">
                                <label for="">Date & Time</label>
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($booking->scheduleDateBook->date_schedule)->format('l , d F Y') }}
                                    <br> {{ \Carbon\Carbon::parse($booking->scheduleTimeBook->time)->format('h:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="p-2 border rounded-full size-14 border-[#fadde1]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <div class="">
                                <label for="">List of Services</label>
                                <ul>
                                    @foreach ($detailBooking as $item)
                                        <li class="font-semibold">
                                            ({{ $item->service->category->name_service_categori }})
                                            {{ $item->name_service }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-4 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="p-2 border rounded-full size-14 border-[#fadde1]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                            </svg>
                            <div class="">
                                <label for="">Code Booking</label>
                                <div class="flex items-center gap-2">
                                    <div class="">
                                        <p class="font-semibold">{{ $booking->code_booking }}</p>
                                    </div>
                                    <button onclick="copyText('{{ $booking->code_booking }}')" wire:click='notifCopy()'>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="size-5 hover:stroke-green-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="p-2 border rounded-full size-14 border-[#fadde1]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <div class="">
                                <label for="">Quantity of Person</label>
                                <p class="font-semibold">{{ $booking->qty_people_booking }} Person</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="p-2 border rounded-full size-14 border-[#fadde1]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                            <div class="">
                                <label for="">Status Deposit</label><br>
                                @if ($booking->is_deposit_paid == true)
                                    <x-pages.badge type='success' value='Paid' />
                                @else
                                    <x-pages.badge type='danger' value='No Paid' />
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="p-2 border rounded-full size-14 border-[#fadde1]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <div class="">
                                <label for="">Total Payment after Deducted </label><br>
                                <p class="font-semibold">(-${{ $booking->deposit_price_booking }})
                                    ${{ $booking->total_price_booking - $booking->deposit_price_booking }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="p-4 rounded-lg ">
                        @if ($booking->is_deposit_paid == false)
                            {{-- Time Limit --}}
                            <div class="p-4 my-5 border border-[#fadde1] rounded-lg">
                                <!-- Title Section -->
                                <h2 class="mb-4 text-2xl font-bold text-center">Deposit Payment Deadline</h2>
                                <!-- Explanation Text -->
                                <p class="mb-10 text-center text-gray-600">
                                    Please pay the deposit before the timer runs out. If you miss the deadline, your
                                    transaction will be canceled. <br><br>
                                    Remember to include your <b>booking code</b> shown above, so we can confirm your
                                    payment and booking.
                                </p>
                                <!-- Timer Section -->
                                <div class="flex justify-center mb-10" wire:poll.1s="checkTimeRemaining">
                                    <div class="p-6 text-4xl font-semibold bg-[#fadde1] rounded-xl shadow-lg timer">
                                        {{-- @php
                                            $hours = floor($timeRemaining / 3600);
                                            $minutes = floor(($timeRemaining % 3600) / 60);
                                            $seconds = $timeRemaining % 60;
                                        @endphp
                                        <span>{{ str_replace('-', '', str_pad($hours, 2, '0', STR_PAD_LEFT)) }}</span>
                                        <span>:</span>
                                        <span>{{ str_replace('-', '', str_pad($minutes, 2, '0', STR_PAD_LEFT)) }}</span>
                                        <span>:</span>
                                        <span>{{ str_replace('-', '', str_pad($seconds, 2, '0', STR_PAD_LEFT)) }}</span> --}}
                                        {{ $timeRemaining }}
                                    </div>
                                </div>
                                <!-- Additional Info Below Timer -->
                                <p class="text-center text-gray-600">
                                    If the time reaches zero, your booking will be automatically <b
                                        class="text-red-600"> canceled </b>, and you will need to make a new booking.
                                </p>
                            </div>
                            {{-- Time Limit --}}
                        @endif
                        {{-- Information Container --}}
                        <!-- Accordion Container -->
                        <div class="space-y-4 accordion-container">
                            <!-- Accordion Item 1: Deposit Requirement -->
                            <div x-data="{ open: false }"
                                class="mb-4 border border-[#fadde1] rounded-md accordion-item">
                                <button @click="open = !open"
                                    class="w-full p-4 text-left text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold">Deposit Requirement</span>
                                        <svg :class="{ 'transform rotate-180': open }"
                                            class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>
                                <div x-show="open" x-transition class="p-4 border-t border-[#fadde1]">
                                    <p>To confirm your appointment, a deposit is required. Here’s how to complete it:
                                    </p>
                                    <ul class="pl-6 list-disc">
                                        <li><strong>Deposit Amount</strong>: All clients must send a deposit of <span
                                                class="font-semibold">${{ $deposit }}</span> to book an
                                            appointment.</li>
                                        <li><strong>E-Transfer Instructions</strong>:
                                            <ul class="pl-6 list-disc">
                                                <li>Send the deposit via e-transfer to <span
                                                        class="font-semibold">{{ $paymentEmail }}</span>
                                                    <button onclick="copyText('{{ $paymentEmail }}')"
                                                        wire:click='notifCopy()'>
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor"
                                                            class="size-5 hover:stroke-green-600">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                        </svg>
                                                    </button>
                                                </li>
                                                <li>Ensure to send the deposit within <span class="font-semibold">2
                                                        hours</span> of
                                                    booking to secure your appointment</li>
                                            </ul>
                                        </li>
                                        <li><strong>Deposit Policy</strong>:
                                            <ul class="pl-6 list-disc">
                                                <li>The deposit will be subtracted from the total cost once the service
                                                    is
                                                    completed.</li>
                                                <li>If the deposit is not received within 2 hours, the appointment will
                                                    not be
                                                    confirmed.</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Accordion Item 2: Payment Options -->
                            <div x-data="{ open: false }"
                                class="mb-4 border border-[#fadde1] rounded-md accordion-item">
                                <button @click="open = !open"
                                    class="w-full p-4 text-left text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold">Payment Options</span>
                                        <svg :class="{ 'transform rotate-180': open }"
                                            class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>
                                <div x-show="open" x-transition class="p-4 border-t border-[#fadde1]">
                                    <p>We offer two payment methods for your convenience:</p>
                                    <ul class="pl-6 list-disc">
                                        <li><strong>Cash Payment</strong>: Pay the remaining balance in cash at the time
                                            of your
                                            appointment.</li>
                                        <li><strong>E-Transfer</strong>: Complete the remaining balance via e-transfer
                                            to <span class="font-semibold">{{ $paymentEmail }}</span>.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- Information Container --}}
                    </div>
                </div>
            </div>
            @if($booking->status !== 'cancel'  && $booking->status !== 'reschedule' && $booking->status !== 'completed')
            <div class="flex gap-3 my-5 ">
                @if ($booking->is_deposit_paid == '1')
                    @php
                        $dateSchedule = \Carbon\Carbon::parse($booking->scheduleDateBook->date_schedule);
                        $today = \Carbon\Carbon::today();
                    @endphp
                    @if ($dateSchedule->gt($today) && $booking->reschedule_flag_booking == '0')
                        <div class="flex-auto">
                            <x-pages.btn-static value=' Reschedule Booking' data-modal-target="reschedule-modal"
                                data-modal-toggle="reschedule-modal" />
                        </div>
                    @endif
                @else
                    <div class="flex-auto">
                        <x-pages.btn-static type='success' wire:click='confirmDeposit' value='Confirm Deposit'
                            wire:confirm='Are you sure want to Confirm Deposit for Booking' />
                    </div>
                @endif
                <div class="flex-auto">
                    <x-pages.btn-static type='danger' value=' Cancel Booking'
                        wire:confirm='Are you sure want to "Cancel" this Booking ' />
                </div>
            </div>
            @endif
        </div>
    </div>
    {{-- Modal Reschedule Date - Begin --}}
    <x-pages.modal.modal id='reschedule-modal' title="Reschedule Booking" submitFunction='rescheduleBooking()'>
        <small>
            This can be changed only once and only if it's available within 24 hours of the booking date and time.
        </small>
        @livewire('component.module.schedule-selector', ['getSelectedTime' => $booking->scheduleTimeBook->id, 'getSelectedDate' => $booking->scheduleDateBook->id, 'getIndexDate' => '1'])
    </x-pages.modal.modal>
    {{-- Modal Reschedule Date - End --}}
    {{-- Extra Script --}}
    <script>
        function copyText(text) {
            /* Copy selected text into clipboard */
            navigator.clipboard.writeText(text);
        }
    </script>
    {{-- Extra Script --}}
</div>
