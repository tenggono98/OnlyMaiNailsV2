

<div>

    {{-- If your happiness depends on money, you will never be happy with yourself. --}}


    <div class="flex justify-between p-2 lg:p-5">
        <div class="">
            {{-- <h1 class="uppercase lg:text-2xl">Only Mai Nails</h1> --}}
        </div>
        <div class="flex-auto lg:flex-none lg:justify-center">
            @if(empty(Auth::user()->role))
            <ul class="flex justify-center gap-4">
                <li>Already Member?</li>
                <li class="cursor-pointer"><a class="w-full" href="{{ route('user.login') }}">Login</a></li>
                <li class="cursor-pointer"><a class="w-full" href="{{ route('user.login') }}">Sign Up</a></li>
            </ul>
            @else

            <ul class="flex justify-between w-full gap-4 lg:flex lg:justify-center ">
                <li>Hello, <span class="font-semibold">{{ Auth::user()->name }}</span></li>
                <div class="hidden lg:flex">
                    <li class="cursor-pointer">Booking History</li>
                    <li class="cursor-pointer">Change Password</li>
                </div>
                    <li class="cursor-pointer"><a wire:click="logout" >Logout</a></li>

            </ul>


            @endif

        </div>




    </div>

    <section id="nav-dekstop" class="bg-[#fadde1] p-5 hidden lg:block">


        <div class="flex justify-between w-full ">

            {{-- Logo --}}
            <div class="">
                <img src="{{ asset('img/transparant-logo.png') }}" class="h-28" alt="">
            </div>
            {{-- Logo --}}

            {{-- Menu --}}
            <div class="flex items-center justify-center ">
                <ul class="flex justify-center gap-5 uppercase list-none">
                    <li><a href="{{ Route('home') }}">Home V2</a></li>
                    <li><a href="">Our Services</a></li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="{{ Route('book') }}">Book</a></li>
                </ul>
            </div>
            {{-- Menu --}}

        </div>

    </section>


    <section id="nav-mobile" class="bg-[#fadde1] p-5 lg:hidden fixed bottom-0 w-full z-10">
        <div class="flex justify-between w-full p-2">
            {{-- Menu --}}
            <div class="flex items-center w-full justify-evenly">
                <ul class="flex items-center w-full gap-5 uppercase list-none justify-evenly">
                    <li>
                        <a href="{{ Route('home') }}" class="flex flex-col items-center justify-between block h-full p-2 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <p class="mt-2 text-xs">Home</p>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex flex-col items-center justify-between block h-full p-2 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v16.5M2.25 12h19.5M6.375 17.25a4.875 4.875 0 0 0 4.875-4.875V12m6.375 5.25a4.875 4.875 0 0 1-4.875-4.875V12m-9 8.25h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v13.5a1.5 1.5 0 0 0 1.5 1.5Zm12.621-9.44c-1.409 1.41-4.242 1.061-4.242 1.061s-.349-2.833 1.06-4.242a2.25 2.25 0 0 1 3.182 3.182ZM10.773 7.63c1.409 1.409 1.06 4.242 1.06 4.242S9 12.22 7.592 10.811a2.25 2.25 0 1 1 3.182-3.182Z" />
                            </svg>
                            <p class="mt-2 text-xs">Services</p>
                        </a>
                    </li>
                    <li>
                        <a href="" class="flex flex-col items-center justify-between block h-full p-2 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            <p class="mt-2 text-xs">Contact Us</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ Route('book') }}" class="flex flex-col items-center justify-between block h-full p-2 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <p class="mt-2 text-xs">Booking</p>
                        </a>
                    </li>
                </ul>
            </div>
            {{-- Menu --}}
        </div>
    </section>






</div>
