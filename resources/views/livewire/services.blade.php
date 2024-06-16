<div>
    {{-- The best athlete wants his opponent at his best. --}}

     {{-- BANNER ZONE --}}
     <section id="banner" class="py-10 ">

        <div class="py-5 ">
            <h1 class="text-4xl text-center animate-fade animate-once animate-delay-100">Our Services </h1>
        </div>

         {{-- SERVICES ZONE --}}

    <section id="services" class="px-32">

        <div class="">


            <div class="grid gap-4 lg:grid-cols-4">
                @foreach ($services as $card )
                  {{-- Card --}}
                  <div class="p-4 border rounded-lg border-[#fadde1]">
                    <h1 class="text-2xl text-center">{{ $card->name_service_categori }}</h1>
                    @foreach ($card->services as $item)


                    {{-- Item --}}
                    <div class="">
                        <div class="flex justify-between">
                            <div class="">
                                <p>{{ $item->name_service}}</p>
                            </div>
                            <div class="">
                                <p>${{ $item->price_service}}</p>
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


    </section>
    {{-- BANNER ZONE --}}
</div>
