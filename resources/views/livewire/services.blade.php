<div>
    {{-- The best athlete wants his opponent at his best. --}}

    {{-- BANNER ZONE --}}
     <section id="banner" class="">

        <div class="py-5 ">
            <h1 class="text-4xl text-center animate-fade animate-once animate-delay-100">Our Services </h1>
        </div>

     </section>
     {{-- BANNER ZONE --}}

    {{-- SERVICES ZONE --}}

    <section id="services" class="">

        <div class="">


            <div class="grid gap-4 lg:grid-cols-4">
                @foreach ($services as $card )
                  {{-- Card --}}
                  <div class="p-4 border rounded-lg border-[#fadde1]">
                    <h1 class="text-2xl text-center">{{ $card->name_service_categori }}</h1>
                    @foreach ($card->services as $item)


                    {{-- Item --}}
                    <div class="mb-1 text-lg">
                        <div class="flex justify-between ">
                            <div class="">
                                <p class="">{{ $item->name_service}}</p>
                            </div>
                            <div class="">
                                <p class="">${{ $item->price_service}}</p>
                            </div>

                        </div>
                    </div>
                    {{-- Item --}}
                    @endforeach

                    {{-- <p class="text-xs font-thin">Only permitted once for Gel-X</p> --}}
                </div>
                {{-- Card --}}

                @endforeach




            </div>
        </div>

    </section>

    {{-- SERVICES ZONE --}}


    {{-- BANNER ZONE --}}
    <section id="banner" class="mt-10">

        <div class="py-5 ">
            <h1 class="text-4xl text-center animate-fade animate-once animate-delay-100">Our Works </h1>
        </div>

     </section>
     {{-- BANNER ZONE --}}


     {{-- OUR WORK ZONE --}}
     <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 ">

        @for ($i = 0 ; $i < 20; $i++)

        <div class="">
            <img src="{{ asset('img/IMG_3918.png') }}" class="hover:translate-y-5" alt="">

        </div>

        @endfor

     </div>

     {{-- OUR WORK ZONE --}}





</div>
