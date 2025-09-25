<div>
    {{-- Container List Services --}}
    <div class="flex flex-col gap-4 mb-5" data-aos="fade-up">
        @foreach ($services as $card)
        @php
            $image_link = '';
            if($card->name_service_categori == 'Gel-X')
                $image_link = asset('img/IMG_3195.jpg');
            elseif($card->name_service_categori == 'Builder Gel Overlay')
            $image_link = asset('img/IMG_1002.jpg');
            elseif($card->name_service_categori == 'Removal')
            $image_link = asset('img/IMG_3917.png');
            elseif($card->name_service_categori == 'Other Services')
                $image_link = asset('img/IMG_3174.jpg')
        @endphp
        <h1 class="text-3xl  " data-aos="fade-up">{{ $card->name_service_categori }}</h1>
            <div class="grid grid-cols-3 gap-10 mb-5 " data-aos="fade-up" data-aos-delay="60">
                    <div class="" data-aos="zoom-in">
                        <img src="{{ $image_link }}"  class="rounded-xl max-h-60 w-full object-cover object-center" alt="">
                    </div>
                    <div class="col-span-2 ">
                        @foreach ($card->services as $item)
                            <div class="flex  justify-between" data-aos="fade-up" data-aos-delay="90">
                                <div class="mb-2">
                                    <h1 class="text-2xl">{{ $item->name_service }}</h1>
                                </div>
                                <div class="">
                                    <p class="text-xl text-mute">${{ $item->price_service }}</p>
                                </div>
                            </div>
                            @endforeach
                    </div>
            </div>
        @endforeach
    </div>
    {{-- Container List Services --}}


    {{-- More Information --}}
        <div class="grid grid-cols-3 gap-10 mb-5" data-aos="fade-up">
            <div class="col-span-2">
                <h1 class="text-2xl  text-left mb-5">Have a Question?</h1>
                <div class="flex flex-col gap-4 float-left">
                {{-- IG --}}
                <div class="flex gap-3 justify-start">
                    <svg class=" text-gray-800 dark:text-white w-[56px] h-[56px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" clip-rule="evenodd"/>
                      </svg>
                      <div class="">
                        <h1 class="text-left">Instagram</h1>
                        <p class="text-2xl underline underline-offset-2">onlymainails</p>
                      </div>

                </div>
                {{-- IG --}}
                {{-- Email --}}
                <div class="flex gap-3 justify-start">
                    <svg class="text-gray-800 dark:text-white w-[56px] h-[56px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                      </svg>
                      <div class="">
                        <h1 class="text-left">Email</h1>
                        <p class="text-2xl underline underline-offset-2">maixesthetics@gmail.com</p>
                      </div>

                </div>
                {{-- Email --}}

            </div>
            <div class="">

                </div>
            </div>
        </div>
    {{-- More Information --}}



</div>
