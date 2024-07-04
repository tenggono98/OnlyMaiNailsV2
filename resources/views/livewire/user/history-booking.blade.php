<div>
    {{-- In work, do what you enjoy. --}}
    <div class="grid grid-cols-1 gap-4 mx-auto lg:grid-cols-3 lg:px-10">
        {{-- Container Search --}}
        <div class="">
            <h1>Booking History</h1>
            <form>
                <div class="my-4">
                    <div class="mb-3">
                        <label for="dateSearch" class="mb-2">Date</label><br>
                        <div class="flex gap-3">
                            <div class="flex-auto">
                                <input type="date" class="w-full form-control" name="dateSearch" id="dateSearch"
                                    wire:model='dateSearch'>
                            </div>

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="codeSearch" class="mb-2">Code Booking</label><br>
                        <input type="text" class="w-full form-control" placeholder="8 Digit Code" name="codeSearch" id="codeSearch"
                            wire:model='codeSearch'>
                    </div>
                    <div class="mb-3">
                        <label for="statusSearch" class="mb-2">Status</label><br>
                        <select class="w-full form-control" name="statusSearch" id="statusSearch"
                            wire:model='statusSearch'>
                            <option value="">Select Booking Status</option>
                            <option value="completed">Completed</option>
                            <option value="cancel">Cancel</option>
                            <option value="1">Ongoing</option>
                            <option value="reschedule">Reschedule</option>
                            <option value="1&0">Waiting Payment Deposit</option>
                            <option value="1&1">Waiting Admin Confirmation</option>
                        </select>
                    </div>
                    <div class="">
                        <button class="w-full btn-normal" type="submit">Search</button>
                    </div>

                </div>
            </form>
            @if($dateSearch !== null || $codeSearch !== null || $statusSearch !== null)
            <div class="mb-3">
                <button class="w-full btn-normal" wire:click='clearSearch'>Clear</button>
            </div>
            @endif
        </div>
        {{-- Container Search --}}
        {{-- Container Booking --}}
        <div class="col-span-2">
            <h1 class="mb-4 lg:text-right">List Booking</h1>
            {{-- Container --}}
            <div class="rounded-lg border border-[#fadde1] p-4">
                {{-- Container Item --}}
                @if(count($bookingData) > 0)
                <div class="flex flex-col gap-5">
                    @foreach ($bookingData as $item)
                        {{-- Item --}}
                        <div class="flex-auto border-b border-[#fadde1]">

                            <div class="">
                                <small for="">Code Booking</small>

                                <p class="text-xl font-semibold">{{ $item->code_booking }}</p>
                            </div>
                            <div class="flex flex-col justify-between mb-1 lg:flex-row">
                                <div class="flex gap-4 ">
                                    <div class="">
                                        <small for="">Date & Time</small>
                                        <p class="font-semibold">{{ Carbon\Carbon::parse($item->scheduleDateBook->date_schedule )->format('l , d F Y') }} |  {{ Carbon\Carbon::parse($item->scheduleTimeBook->time)->format('h:i A') }}</p>
                                    </div>

                                    <div class="">
                                        <small for="">Total Payment</small>
                                        <p class="font-semibold">$ {{ $item->total_price_booking - $item->deposit_price_booking }}</p>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="py-2 lg:py-0">
                                        @if ($item->status == 1)
                                            @if ($item->confirm_payment == '0')
                                             <x-pages.badge type='danger' value='Waiting Payment Deposit' />
                                            @elseif($item->confirm_payment == '1'  && $item->is_deposit_paid == '0')
                                            <x-pages.badge type='success' value='Waiting Admin Confirmation' />
                                            @elseif($item->confirm_payment == '1' && $item->is_deposit_paid == '1')
                                             <x-pages.badge type='success' value='Ongoing' />
                                            @endif
                                        @elseif($item->status == 0)
                                            <x-pages.badge type='danger' value='Deactivate' />
                                        @elseif($item->status == 'cancel')
                                        <x-pages.badge type='danger' value='Cancel' />
                                        @elseif($item->status == 'reschedule')
                                        <x-pages.badge type='info' value='Reschedule' />
                                        @elseif($item->status == 'completed')
                                        <x-pages.badge type='success' value='Complete' />

                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="">
                                    <small for="">Services</small>
                                    <ul>
                                        @foreach ($item->detailService as $service)
                                        <li class="font-semibold">({{ $service->service->category->name_service_categori}}) {{ $service->name_service }}</li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            {{-- Action --}}
                            <div class="flex gap-3 mb-3">
                                <div class="flex-auto">
                                    <a href="{{ route('user.reschedule_or_cancel',['uuid' => $item->uuid])  }}"><button class="w-full btn-normal">More</button></a>
                                </div>
                                @if($item->status == 'completed')
                                <div class="flex-auto">
                                <button class="w-full btn-normal">Leave Review</button>

                                </div>
                                @endif
                            </div>
                            {{-- Action --}}
                        </div>
                        {{-- Item --}}
                    @endforeach
                </div>
                @else
                <h1 class="p-3 text-center">No current bookings found. Please schedule an appointment</h1>
                @endif
                {{-- Container Item --}}
            </div>
            {{-- Container --}}
        </div>
        {{-- Container Booking --}}
    </div>
</div>
