<div>

    {{-- Container List Services --}}
    <div class="flex flex-col gap-4 mb-5">
        @foreach ($services as $card)
        @php
            $image_link = '';
            if($card->name_service_categori == 'Gel-X')
                $image_link = 'https://media.discordapp.net/attachments/851045333101576212/1326658808629563402/4DF192A0-0CE2-4E91-9131-E0866D07E4F6.jpg?ex=67877b0c&is=6786298c&hm=31a3f7d2dab61f10afe8113f79b2930c1f282c7c229957d9cfc665519d04878b&=&format=webp&width=1256&height=1262';
            elseif($card->name_service_categori == 'Builder Gel Overlay')
                $image_link = 'https://media.discordapp.net/attachments/851045333101576212/1326658808143151124/IMG_1006.jpg?ex=67877b0b&is=6786298b&hm=fa420d24c62f47e192470e7acd3d68f5fa3f7863e9a69ad294145701da26751b&=&format=webp&width=946&height=1262';
            elseif($card->name_service_categori == 'Removal')
            $image_link = 'https://media.discordapp.net/attachments/851045333101576212/1328487851788206132/IMG_3418.jpg?ex=67878af9&is=67863979&hm=a26ef249dd018a75b56d45e5c5964776009f957f998b00c67d6d5fecef42643d&=&format=webp&width=946&height=1262';
            elseif($card->name_service_categori == 'Other Services')
                $image_link = 'https://media.discordapp.net/attachments/851045333101576212/1326658804116623503/IMG_3174.jpg?ex=67877b0b&is=6786298b&hm=4bb23d288c0532be60493d5edf65c3e788f452253434bb9a8f9648e552260304&=&format=webp&width=946&height=1262'
        @endphp
        <h1 class="text-3xl  ">{{ $card->name_service_categori }}</h1>

            <div class="grid grid-cols-3 gap-10 mb-5 ">


                    <div class="">

                        <img src="{{ $image_link }}"  class="rounded-xl max-h-60 w-full object-cover object-center" alt="">
                    </div>

                    <div class="col-span-2 ">

                        @foreach ($card->services as $item)

                            <div class="flex  justify-between">

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

        <div class="grid grid-cols-3 gap-10 mb-5">

            <div class="col-span-2">
                <img src="https://media.discordapp.net/attachments/851045333101576212/1326658807073603584/IMG_1002.jpg?ex=67877b0b&is=6786298b&hm=b565a8d71669e03ca3c2de4c9ce698bc2575b9860027e2a1ba8d070116a865be&=&format=webp&width=1210&height=1262" class="rounded-xl max-h-60 w-full object-cover object-center" alt="">
            </div>
            <div class="">
                    <h1 class="text-2xl  text-right mb-5">Have Question?</h1>

                    <div class="flex flex-col gap-4 float-right">

                    {{-- IG --}}
                    <div class="flex gap-3 justify-end">


                          <div class="">
                            <h1 class="text-right">Instagram</h1>
                            <p class="text-2xl underline underline-offset-2">onlymainails</p>
                          </div>
                          <svg class=" text-gray-800 dark:text-white w-[56px] h-[56px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z" clip-rule="evenodd"/>
                          </svg>

                    </div>
                    {{-- IG --}}

                    {{-- Email --}}
                    <div class="flex gap-3 justify-end">


                          <div class="">
                            <h1 class="text-right">Email</h1>
                            <p class="text-2xl underline underline-offset-2">maixesthetics@gmail.com</p>
                          </div>
                          <svg class="text-gray-800 dark:text-white w-[56px] h-[56px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                          </svg>

                    </div>
                    {{-- Email --}}
                </div>


            </div>

        </div>


    {{-- More Information --}}







</div>
