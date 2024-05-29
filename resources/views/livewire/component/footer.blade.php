<div>
    {{-- Do your work, then step back. --}}


    <div class="grid gap-5 px-10 py-10 lg:px-20 lg:grid-cols-4">

        {{-- Image --}}
        <div class="">
            <img src="{{ asset('img/transparant-logo.png') }}" alt="">
        </div>
        {{-- Image --}}

        {{-- Info 1 --}}
        <div class="">
            <h1 class="text-2xl uppercase">Visit Us</h1>
        </div>
        {{-- Info 1 --}}

        {{-- Info 2 --}}
        <div class="">
            <h1 class="text-2xl uppercase">Working Hours</h1>
            <p class="uppercase">Mondays <span class="font-light"> 10AM, 12PM, 2PM </span></p>
            <p class="uppercase">Tuesdays <span class="font-light"> 12PM, 2PM</span></p>
            <p class="uppercase">Wednesdays  <span class="font-light"> 12 PM </span></p>

        </div>
        {{-- Info 2 --}}

        {{-- Info 3 --}}
        <div class="">
            <h1 class="text-2xl uppercase">Quick Links</h1>
        </div>
        {{-- Info 3 --}}

    </div>
    <div class="py-3 ">
        <h1 class="font-light text-center">© {{ Carbon\Carbon::today()->format('Y') }} OnlyMaiNails. All Rights Reserved | Developed and SEO by "Ateng"</h1>
    </div>

</div>
