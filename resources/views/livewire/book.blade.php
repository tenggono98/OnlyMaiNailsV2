<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}






    <div class="container p-4 mx-auto">









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



                            @if($indexDate !== null)
                            <div class="grid grid-cols-3 gap-4">


                                    @foreach ($dataBookingDate[(int)$indexDate]->times as $key => $bookingTime )

                                    @php
                                        $inputId = 'timeSlot-' . str_replace(':', '-', str_replace(' ', '-', $key)) . $indexDate;
                                    @endphp

                                    <label for="{{ $inputId }}" class="flex text-nowrap items-center justify-center p-2 border rounded-md cursor-pointer border-[#fadde1] {{ ($bookingTime->is_book == true)?'bg-gray-300 border-none' : '' }}">
                                        <input {{ ($bookingTime->is_book == true)?'disabled' : '' }} type="radio" id="{{ $inputId }}" name="timeSlot" value="{{ $bookingTime->id }}" class="mr-2">
                                        {{ Carbon\Carbon::parse($bookingTime->time)->format('h:i A')  }}
                                    </label>




                                    @endforeach



                            </div>
                            @endif




                        </div>

                    </div>


                </div>

                {{-- <button wire:click="back('')"
                    class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Back</button> --}}
                <button wire:click="next('pickDateAndTime')"
                    class="px-4 py-2 text-white bg-blue-500 rounded">Next</button>
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
                            @for ($i = 2;$i<99;$i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>

                    </div>



                     {{-- Info  --}}

                    <div class="">

                        @php
                            // Calculate Total Price & Deducted Price
                            // dd($number_of_people);
                             foreach ($this->selectedServices as $key => $selected ){
                                $total_price += (int)$selected['price'] * $number_of_people ;
                            }
                        @endphp

                        <div class="flex flex-col gap-3 my-3 lg:flex-row ">
                            <div class="border border-[#fadde1] p-3 rounded-lg">
                                <p class="text-xl">Total Price (Before Deducted)</p>
                                <p class="text-4xl">$ {{ $total_price ?? 0 }}</p>
                            </div>

                            <div class="border border-[#fadde1] p-3 rounded-lg">
                                <p class="text-xl">Total Payment (After Deducted)</p>
                                <p class="text-4xl">$ {{  ((int)$total_price > 0)?  (int)$total_price - (int)$this->deposit->value  : 0 }}</p>
                            </div>

                        </div>

                    </div>
                    {{-- Info --}}



                    {{-- Category --}}
                    <div class="flex flex-col gap-4 mt-10 mb-2 lg:flex-row">
                        @foreach ($serviceCategory as $key => $cat)
                            <div x-on:click="openCategory = openCategory === {{ $key }} ? null : {{ $key }}"
                                :class="openCategory === {{ $key }} ? 'border-white bg-[#fadde1]' : 'border-[#fadde1]'"
                                class="flex-auto p-4 border rounded-lg hover:cursor-pointer hover:border-white hover:bg-[#fadde1]">
                                <p>{{ $cat->name_service_categori}}</p>
                            </div>
                        @endforeach
                    </div>
                    {{-- -------------- --}}

                    @foreach ($serviceCategory as $key => $cat)
                    {{-- Category Item --}}
                    <div x-bind:class="openCategory !== {{ $key }} ? 'hidden' : ''"
                        class="border rounded-lg border-[#fadde1] mb-10 mt-2">
                        @foreach ($cat->services as $serv)
                            <label for="{{ $cat->id }}-{{ $serv->id }}" >
                                <div class="flex justify-between p-2 hover:cursor-pointer hover:border-white hover:bg-[#fadde1]">
                                    <div>
                                        {{ $serv->name_service }}
                                    </div>
                                    <div class="flex items-center justify-center p-2">
                                        <div>
                                            @if($serv->is_merge == true)

                                            <input
                                            wire:click='toggleService({{ $serv->id }},"checkbox")'
                                                id="{{ $cat->id }}-{{ $serv->id }}"
                                                type="checkbox"
                                                class="w-42"
                                                @if(in_array($serv->id, array_column($selectedServices, 'id')))
                                                    checked
                                                @endif
                                            >
                                            @else
                                            <input
                                            wire:click='toggleService({{ $serv->id }},"radio")'
                                                id="{{ $cat->id }}-{{ $serv->id }}"
                                                name="{{ $cat->id }}"
                                                type="radio"
                                                class="w-42"
                                                @if(in_array($serv->id, array_column($selectedServices, 'id')))
                                                    checked
                                                @endif
                                            >

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

                    <button wire:click="back('service')"
                    class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Back</button>
                <button wire:click="next('service')"
                    class="px-4 py-2 text-white bg-blue-500 rounded">Next</button>
                </div>

            </div>
        </div>


        <!-- Client Information -->
        <div x-data="{ open: @entangle('flagInformationClient') }">
            <div x-show="open" x-transition>
                <h2 class="mb-4 text-xl ">Client Information</h2>
                <!-- Client information form goes here -->

                <div class="flex flex-col gap-3 p-4 my-5 border-[#fadde1] border rounded-lg">


                    <div class="flex-auto">
                        <label for="">Full Name</label><br>
                        <input type="text" class="w-full form-control"  name="" id="" wire:model='clientName'>
                    </div>


                    <div class="">
                        <label for="">Phone Number</label>
                        <input type="number" name="" id="" class="w-full form-control" wire:model='clientPhoneNumber'>
                    </div>


                    <div class="">
                        <label for="">Email</label>
                        <input type="email" name="" id="" class="w-full form-control" wire:model='clientEmail'>
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
                            <div class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">
                                <div class="">
                                    <svg class="w-8 h-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M17.788 5.108A9 9 0 1021 12h-8" /></svg>
                                </div>
                                <div class="flex items-center">
                                    <p>Sign in with Google</p>
                                </div>

                            </div>
                            </a>
                    </div>



                </div>


                <div class="mb-5">


                    <div class="py-5">
                        <hr class="border-t border-[#fadde1]">
                    </div>


                    <div class="">
                        <label for="">Instagram</label>
                        <input type="text" name="" class="w-full form-control" id="" wire:model='clientName'>

                    </div>
                </div>






                <button wire:click="back('informationClient')"
                    class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Back</button>
                <button wire:click="next('informationClient')"
                    class="px-4 py-2 text-white bg-blue-500 rounded">Next</button>
            </div>
        </div>

        <!-- Summary -->
        <div x-data="{ open: @entangle('flagSummary') }">
            <div x-show="open" x-transition>
                <h2 class="mb-4 text-xl ">Summary</h2>
                <!-- Summary of all selections goes here -->
                <button wire:click="back('summary')" class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Back</button>
                <button wire:click="next('summary')" class="px-4 py-2 text-white bg-green-500 rounded">Submit</button>
            </div>
        </div>
    </div>








</div>
