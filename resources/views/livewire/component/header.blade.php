

<div>

    {{-- If your happiness depends on money, you will never be happy with yourself. --}}


    <div class="flex justify-between p-2 lg:p-5">
        <div class="">
            {{-- <h1 class="uppercase lg:text-2xl">Only Mai Nails</h1> --}}
        </div>
        <div class="lg:justify-center">
            @if(empty(Auth::user()->role))
            <ul class="flex justify-center gap-4">
                <li>Already Member?</li>
                <li class="cursor-pointer"><a class="w-full" href="{{ route('user.login') }}">Login</a></li>
                <li class="cursor-pointer"><a class="w-full" href="{{ route('user.login') }}">Sign Up</a></li>
            </ul>
            @else

            <ul class="flex justify-center gap-4">
                <li>Hello, <span class="font-semibold">{{ Auth::user()->name }}</span></li>
                <li class="cursor-pointer">Booking History</li>
                <li class="cursor-pointer">Change Password</li>
                <li class="cursor-pointer"><a wire:click="logout" >Logout</a></li>
            </ul>


            @endif

        </div>




    </div>

    <section id="nav-dekstop" class="bg-[#fadde1] p-5">


        <div class="flex justify-between w-full ">

            {{-- Logo --}}
            <div class="">
                <img src="{{ asset('img/transparant-logo.png') }}" class="h-28" alt="">
            </div>
            {{-- Logo --}}

            {{-- Menu --}}
            <div class="flex items-center justify-center ">
                <ul class="flex justify-center gap-5 uppercase list-none">
                    <li><a href="{{ Route('home') }}">Home</a></li>
                    <li><a href="">Our Services</a></li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="{{ Route('book') }}">Book</a></li>
                </ul>
            </div>
            {{-- Menu --}}

        </div>

    </section>




</div>
