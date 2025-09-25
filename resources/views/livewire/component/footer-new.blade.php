<div>
    {{-- Do your work, then step back. --}}
    <div class="grid gap-5 px-10 py-10 lg:px-20 lg:grid-cols-4">
        {{-- Image --}}
        <div class="">
            {{-- <img src="{{ asset('img/transparant-logo-v2.png') }}" alt=""> --}}
            <h1 class="julius-sans-one-regular text-4xl !tracking-[15%] ">ONLYMAINAILS</h1>
        </div>
        {{-- Image --}}
        {{-- Info 1 --}}
        <div class="">
            <h1 class="mb-2 text-2xl uppercase ">Visit Us</h1>
            <ul>
                <li>
                    <a target="_blank" href="https://www.instagram.com/onlymainails/"
                        class="flex items-center gap-1 align-middle">
                        <div class="">
                            <img src="{{ asset('img/instagram-icon.svg') }}" class="w-auto h-7" alt="">
                        </div>
                        <div class="my-auto ">
                            <p class="uppercase "> @onlymainails</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        {{-- Info 1 --}}
        {{-- Info 2 --}}
        <div class="">
            <h1 class="mb-2 text-2xl uppercase">Working Hours</h1>
            <p class="uppercase">Mondays </p>
            <p class="uppercase">Tuesdays </p>
            <p class="uppercase">Wednesdays </p>
        </div>
        {{-- Info 2 --}}
        {{-- Info 3 --}}
        <div class="">
            <h1 class="mb-2 text-2xl uppercase">Quick Links</h1>
            <ul class="">
                <li class="mb-3">
                    <a target="_blank" href="https://www.instagram.com/onlymainails/"
                        class="flex items-center gap-1 align-middle">
                        <img src="{{ asset('img/instagram-icon.svg') }}" class="w-auto h-7" alt="">
                        <div class="my-auto ">
                            <p class="uppercase "> @onlymainails</p>
                        </div>
                    </a>
                </li>
                <li class="mb-3">
                    <a target="_blank"
                        href="https://mail.google.com/mail/u/0/
                                                ?to=maixesthetics@gmail.com
                                                &su=OnlyMaiNails+Help
                                                &body=Hello+There
                                                &tf=cm"
                        class="flex items-center gap-1 align-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-auto h-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <div class="my-auto ">
                            <p class="uppercase "> maixesthetics@gmail.com</p>
                        </div>
                    </a>
                </li>
                <li class="mb-3">
                    <a target="_blank" href="{{ route('contact_us') }}" class="flex items-center gap-1 align-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-auto h-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        <div class="my-auto ">
                            <p class="uppercase ">Contact Us</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        {{-- Info 3 --}}
    </div>
    <div class="py-3 ">
        <h1 class="font-light text-center">© {{ Carbon\Carbon::today()->format('Y') }} OnlyMaiNails. All Rights Reserved
            | Developed and SEO by "Ateng"</h1>
    </div>
</div>
