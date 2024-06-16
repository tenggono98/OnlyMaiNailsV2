<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    @if(count($dataBookingDate) > 0)
    <div class="">
        <x-pages.inputs.select wire:model.live='selectedDate' wire:click='$refresh' >
            <option value="">Select Date</option>
        @foreach ($dataBookingDate as $index => $item)
        <option value="{{ $item->id }}">{{ Carbon\Carbon::parse($item->date_schedule)->format('d-m-Y')  }}</option>
        @endforeach
        </x-pages.inputs.select>
    </div>


    @for ($i = 0; $i < count($dataBookingDate);$i++)
    <div class="grid grid-cols-3 gap-2 my-3 {{ ($dataBookingDate[$i]->id == $selectedDate )?'':'hidden' }}">
        @foreach ($dataBookingDate[$i]->times as $key => $bookingTime)
            @php
                $inputId =
                    'timeSlot-' .
                    str_replace(':', '-', str_replace(' ', '-', $key)) .
                    $i;
            @endphp

            <div class="">


                <label for="{{ $inputId }}"
                    class="flex text-nowrap items-center justify-center p-2 border rounded-md cursor-pointer border-[#fadde1] {{ $bookingTime->is_book == true ? 'bg-gray-300 border-none' : '' }}">
                    <input wire:model.live='timeSelected'
                        {{ $bookingTime->is_book == true ? 'disabled' : '' }} type="radio"
                        id="{{ $inputId }}" name="timeSlot" value="{{ $bookingTime->id }}"
                        class="mr-2">
                    {{ Carbon\Carbon::parse($bookingTime->time)->format('h:i A') }}
                </label>
            </div>

        @endforeach
    </div>
    @endfor

    {{-- <div class="grid grid-cols-3 gap-2 my-3">

    @foreach ($dataBookingDate->times as $key => $bookingTime)
    @dd($dataBookingDate->times);
        @php
            $inputId =
                'timeSlot-' .
                str_replace(':', '-', str_replace(' ', '-', $key)) .
                $indexDate;
        @endphp

    <div class="">


        <label for="{{ $inputId }}"
            class="flex text-nowrap items-center justify-center p-2 border rounded-md cursor-pointer border-[#fadde1] {{ $bookingTime->is_book == true ? 'bg-gray-300 border-none' : '' }}">
            <input wire:model.live='timeSelected'
                {{ $bookingTime->is_book == true ? 'disabled' : '' }} type="radio"
                id="{{ $inputId }}" name="timeSlot" value="{{ $bookingTime->id }}"
                class="mr-2">
            {{ Carbon\Carbon::parse($bookingTime->time)->format('h:i A') }}
        </label>
    </div>

    @endforeach --}}
    @else
        <h1 class="font-semibold">They no schedule for now &#128533;. Please create new schedule  </h1>
    @endif



</div>
