<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="container p-4 mx-auto">
         <!-- Policies -->
         <div x-data="{ open: @entangle('flagPolicies') }">
            <div x-show="open" x-transition>
                <h1 class="mb-4 text-xl ">Our Policies</h1>
                <!-- Policies form goes here -->
                <div class="my-5">
                <h1>Cancellations + Reschedules</h1>
                <ul class="mb-4">
                    <li>Cancellations and/or reschedules within less than 24h notice will result in a forfeited deposit.</li>
                    <li>No shows will also result in a forfeited deposit.</li>
                </ul>
                <h1>Deposit</h1>
                    <ul class="mb-4">
                        <li> All clients are required to send a <span class="font-semibold"> ${{ $deposit }} deposit to book an appointment</span>.</li>
                        <li>Please send via e-transfer to <span class="font-semibold"> {{ $dataBook['email'] }}</span> within <span class="font-semibold text-red-800">{{ $dataBook['LimitTime'] }} hours </span> of booking, or appointment will not be confirmed.</li>
                        <li>Deposit will be subtracted from the total once the service is done.</li>
                        <li>There will be a 15 min grace period. After that, a late fee will be charged, or your appointment will be cancelled.  No shows will result in a forfeited deposit</li>
                    </ul>
                <h1>Payment</h1>
                <p class="mb-4">Cash or E-transfer only</p>
                <h1>Location</h1>
                <p class="mb-4">{{ $dataBook['address'] }}</p>
                <iframe class="mb-4" src="{{ $dataBook['gmapLinks'] }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <h1>Other Info</h1>
                <p class="mb-4">Please DM nail inspiration prior to the appointment for the best results!
                If you need any further assistance with this text or have additional questions, feel free to ask!</p>
                <div class="flex">
                    <label for="agree-checkbox" class="flex items-center gap-2 p-2 align-middle">
                    <div class="">
                        <input type="checkbox" wire:model.live='agree_checkbox' value="accept" name="agree-checkbox" id="agree-checkbox" class="">
                    </div>
                    <div class="items-center">
                        <p class="p-0 m-0">I have read and agreed to all the policies</p>
                    </div>
                    </label>
                </div>
            </div>
                <div class="flex w-full gap-3">
                    <div class="flex-auto">
                        <button wire:click="next('flagPolicies')"
                        type="button"
                        class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">
                    Next
                    </button>
                    </div>
                </div>
            </div>
        </div>
        <form wire:submit="save">
            @csrf
            <!-- Client Information -->
            <div x-data="{ open: @entangle('flagInformationClient') }">
                <div x-show="open" x-transition>
                    <h1 class="mb-4 text-xl ">Client Information</h1>
                    <!-- Client information form goes here -->
                    @if (!Auth::user())
                        <div class="flex flex-col gap-3 p-4 my-5 border-[#fadde1] border rounded-lg">
                            <div class="flex-auto">
                                <label for="">Full Name <span class="text-xs text-red-600">*</span></label><br>
                                <input type="text" class="w-full form-control" name="" id=""
                                    wire:model='fullNameClient'>
                                <x-pages.inputs.error error='fullNameClient' />
                            </div>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div class="">
                                    <label for="">Phone Number <span
                                            class="text-xs text-red-600">*</span></label>
                                    <input type="number" name="" id="" class="w-full form-control"
                                        wire:model='phoneNumberClient'>
                                    <x-pages.inputs.error error='phoneNumberClient' />
                                </div>
                                <div class="">
                                    <label for="">Email <span class="text-xs text-red-600">*</span></label>
                                    <input type="email" name="" id="" class="w-full form-control"
                                        wire:model='emailClient'>
                                    <x-pages.inputs.error error='emailClient' />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div class="">
                                    <label for="">Password <span class="text-xs text-red-600">*</span></label>
                                    <input type="password" name="" id="" class="w-full form-control"
                                        wire:model='passwordClient'>
                                    <x-pages.inputs.error error='passwordClient' />
                                </div>
                                <div class="">
                                    <label for="">Confirm password <span
                                            class="text-xs text-red-600">*</span></label>
                                    <input type="password" name="" id="" class="w-full form-control"
                                        wire:model='confrimPasswordClient'>
                                    <x-pages.inputs.error error='confrimPasswordClient' />
                                </div>
                            </div>
                            <div class="">
                                <label for="">Instagram</label>
                                <input type="text" name="" class="w-full form-control" id=""
                                    wire:model='igClient'>
                            </div>
                            <div class="flex items-center py-5">
                                <div class="flex-auto">
                                    <hr class="border-t border-[#fadde1]">
                                </div>
                                <div class="px-4">
                                    <h1 class="text-lg text-center">OR</h1>
                                </div>
                                <div class="flex-auto">
                                    <hr class="border-t border-[#fadde1]">
                                </div>
                            </div>
                            <div class="">
                                <a href="{{ route('oauth.google') }}" class="w-full">
                                    <div
                                        class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">
                                        <div class="">
                                            <svg class="w-8 h-8 text-red-500" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" />
                                                <path d="M17.788 5.108A9 9 0 1021 12h-8" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center">
                                            <p>Sign in with Google</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="p-4 my-5 border-[#fadde1] border rounded-lg">
                            <h1>Hello, {{ Auth::user()->name }}!</h1>
                            <p>Is this your account? If not, you can switch to a different one.</p>
                            <a wire:click="logout"
                                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer my-3">Logout</a>
                            @if (Auth::user()->phone == null)
                                <p class="my-2 font-bold">You're need to fill in some required information</p>
                                <div class="">
                                    <label for="">Phone Number <span
                                            class="text-xs text-red-600">*</span></label>
                                    <input type="number" name="" id="" class="w-full form-control"
                                        wire:model='phoneNumberClient'>
                                        <x-pages.inputs.error error='phoneNumberClient' />
                                </div>
                            @endif
                            @if (Auth::user()->ig_tag == null)
                                <div class="">
                                    <label for="">Instagram</label>
                                    <input type="text" name="" class="w-full form-control" id=""
                                        wire:model='igClient'>
                                </div>
                            @endif
                            <div class="my-3">
                                <h1>Your Information</h1>
                                <div class="flex flex-wrap gap-5 ">
                                    <div class="">
                                        <label for="">Full Name</label>
                                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                                    </div>
                                    <div class="">
                                        <label for="">Email</label>
                                        <p class="font-semibold">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="">
                                        <label for="">Phone Number</label>
                                        <p class="font-semibold">{{ Auth::user()->phone }}</p>
                                    </div>
                                    <div class="">
                                        <label for="">Instagram</label>
                                        <p class="font-semibold">{{ Auth::user()->ig_tag }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <p>If you want to change the detail, please click this link <a href="{{ route('user.change_profile',['id' => Auth::user()->id]) }}" class="font-semibold underline underline-offset-4">Change Profile</a></p>
                            </div>
                        </div>
                    @endif
                    <div class="flex w-full gap-3">
                        <div class="flex-auto">
                            <button wire:click="next('informationClient')"
                            type="button"
                            class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full flex">
                        <!-- Default text -->
                        <span wire:loading.remove wire:target="next">Next</span>
                        @if(Auth::user() == null)
                        <!-- Loading text with spinner -->
                        <span wire:loading wire:target="next">
                            Creating your Account...
                        </span>
                        @endif
                        </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Date and Time Selection -->
            <div x-data="{ open: @entangle('flagPickDateAndTime') }">
                <div x-show="open" x-transition>
                    <h1 class="mb-4 text-xl ">Pick Date and Time</h1>
                    <!-- Date and time selection form goes here -->
                    <div class="my-5">
                        <div class="flex flex-col gap-4 lg:flex-row">
                            <div class="">
                                <p>Dates</p>
                                @livewire('component.module.date-picker-calender')
                            </div>
                            <div class="">
                                <p>Time</p>
                                @if ($indexDate !== null)
                                    <div class="grid grid-cols-3 gap-4">
                                        @foreach ($dataBookingDate[(int) $indexDate]->times as $key => $bookingTime)
                                            @php
                                                $inputId =
                                                    'timeSlot-' .
                                                    str_replace(':', '-', str_replace(' ', '-', $key)) .
                                                    $indexDate;
                                            @endphp
                                            <label for="{{ $inputId }}"
                                                class="flex text-nowrap items-center justify-center p-2 border rounded-md cursor-pointer border-[#fadde1] {{ $bookingTime->is_book == true ? 'bg-gray-300 border-none' : '' }}">
                                                <input wire:model.live='timeBooking'
                                                    {{ $bookingTime->is_book == true ? 'disabled' : '' }}
                                                    type="radio" id="{{ $inputId }}" name="timeSlot"
                                                    value="{{ $bookingTime->id }}" class="mr-2">
                                                {{ Carbon\Carbon::parse($bookingTime->time)->format('h:i A') }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex w-full gap-3">
                        <div class="">
                            <button wire:click="back('pickDateAndTime')" type="button"
                                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">Back</button>
                        </div>
                        <div class="flex-auto">
                            <button wire:click="next('pickDateAndTime')" type="button"
                                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Service Selection -->
            <div x-data="{ open: @entangle('flagService') }">
                <div x-show="open" x-transition>
                    <div x-data="{ openCategory: null }" class="">
                        <h1 class="mb-4 text-xl ">Select Service</h1>
                        <!-- Service selection form goes here -->
                        <div class="flex flex-col">
                            <label for="">Number Of People</label>
                            <select name="number_of_people" id="number_of_people" wire:model.live='number_of_people'>
                                <option value="1">1</option>
                                @for ($i = 2; $i < 99; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        {{-- Category --}}
                        <div class="flex flex-col gap-4 mt-10 mb-2 lg:flex-row">
                            @foreach ($serviceCategory as $key => $cat)
                                <div x-on:click="openCategory = openCategory === {{ $key }} ? null : {{ $key }}"
                                    :class="openCategory === {{ $key }} ? 'border-white bg-[#fadde1]' :
                                        'border-[#fadde1]'"
                                    class="flex-auto p-4 border rounded-lg hover:cursor-pointer hover:border-white hover:bg-[#fadde1]">
                                    <p>{{ $cat->name_service_categori }}</p>
                                </div>
                            @endforeach
                        </div>
                        {{-- -------------- --}}
                        @foreach ($serviceCategory as $key => $cat)
                            {{-- Category Item --}}
                            <div x-bind:class="openCategory !== {{ $key }} ? 'hidden' : ''"
                                class="border rounded-lg border-[#fadde1] mb-10 mt-2">
                                @foreach ($cat->services as $serv)
                                    <label for="{{ $cat->id }}-{{ $serv->id }}">
                                        <div
                                            class="flex justify-between p-2 hover:cursor-pointer hover:border-white hover:bg-[#fadde1]">
                                            <div>
                                                {{ $serv->name_service }}
                                            </div>
                                            <div class="flex items-center justify-center p-2">
                                                <div>
                                                    @if ($serv->is_merge == true)
                                                        <input
                                                            wire:click='toggleService({{ $serv->id }},"checkbox")'
                                                            id="{{ $cat->id }}-{{ $serv->id }}"
                                                            type="checkbox" class="w-42"
                                                            @if (in_array($serv->id, array_column($selectedServices, 'id'))) checked @endif>
                                                    @else
                                                        <input wire:click='toggleService({{ $serv->id }},"radio")'
                                                            id="{{ $cat->id }}-{{ $serv->id }}"
                                                            name="{{ $cat->id }}" type="radio" class="w-42"
                                                            @if (in_array($serv->id, array_column($selectedServices, 'id'))) checked @endif>
                                                    @endif
                                                </div>
                                                <div class="flex items-center ml-2">
                                                    <div>
                                                        <p class="p-0 m-0 text-sm">${{ $serv->price_service }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="flex w-full gap-3">
                            <div class="">
                                <button wire:click="back('service')" type="button"
                                    class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">Back</button>
                            </div>
                            <div class="flex-auto">
                                <button wire:click="next('service')" type="button"
                                    class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Summary -->
            <div x-data="{ open: @entangle('flagSummary') }">
                <div x-show="open" x-transition>
                    <h1 class="mb-4 text-xl ">Summary</h1>
                    <!-- Summary of all selections goes here -->
                    <div class="grid grid-cols-1 mb-4 lg:grid-cols-2">
                        <div class="">
                            <h1 class="">Date</h1>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($selectedDate ?? '')->format('l , d F Y')  }}</p>
                        </div>
                        <div class="">
                            <h1>Time</h1>
                            <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($selectedTime  ?? '')->format('h:i A') }}</p>
                        </div>
                    </div>
                        <div class="mb-4">
                            <h1>Service</h1>
                            <table class="w-full text-left border-collapse">
                                <tbody>
                                    @foreach ($selectedServices as $service)
                                        <tr>
                                            <td class="py-2 text-lg font-semibold border-b">{{ $service['name'] }}</td>
                                            <td class="py-2 text-lg font-semibold text-right border-b">${{ number_format($service['price'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="grid grid-cols-1 mb-4 lg:grid-cols-2">
                            <div class="">
                                <h1>Number of People:</h1>
                                <p class="text-lg font-semibold">{{ $number_of_people }}</p>
                            </div>
                            <div class="">
                                <h1>Total Price:</h1>
                                <p class="text-lg font-semibold">${{ number_format($totalPriceBook, 2) }}</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h1 class="text-lg">Total Payment (after $20 deposit):</h1>
                            <p class="text-xl font-semibold">${{ number_format($totalPriceBook - $deposit, 2) }}</p>
                        </div>
                    <div class="flex w-full gap-3">
                        <div class="">
                            <button wire:click="back('summary')" type="button"
                                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">Back</button>
                        </div>
                        <div class="flex-auto">
                            <button wire:click="next('summary')" type='submit'  wire:confirm='Are you sure you want to proceed with your order?'
                                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">

                                <!-- Default text -->
                                <span wire:loading.remove wire:target="save">Submit</span>
                                <!-- Loading text with spinner -->
                                <span wire:loading wire:target="save" class="animate-pulse">
                                    Creating your Appointment...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
