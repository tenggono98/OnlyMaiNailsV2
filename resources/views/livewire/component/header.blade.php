<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="hidden lg:flex items-center bg-primary xl:px-32 px-5 lg:fixed lg:top-0 lg:left-0 lg:right-0 z-50 h-12 " data-aos="fade-down">

        <div class="flex justify-between w-full ">
            @if (empty(Auth::user()->role))
                <ul class="flex justify-between gap-4 w-full" data-aos="fade-down" data-aos-delay="60">
                    <li class="lg:hidden ">
                        <h1 class="text-2xl !tracking-widest">OnlyMaiNails</h1>
                        <small class="text-xs">Thank you for choosing Onlymainails</small>
                    </li>
                    <ul class="flex gap-4 xl:ml-auto" data-aos="fade-down" data-aos-delay="100">
                        <li class="hidden lg:block">Already a Member?</li>
                        <li class="cursor-pointer"><a class="w-full ux-link" href="{{ route('user.login') }}">Login</a></li>
                        <li class="cursor-pointer"><a class="w-full ux-link" href="{{ route('user.signup') }}">Sign Up</a></li>
                    </ul>
                </ul>
            @else
                <ul class="flex items-center justify-between w-full gap-4 lg:flex lg:justify-center " data-aos="fade-down" data-aos-delay="60">
                    <li class="lg:hidden">
                        <h1 class="text-2xl">OnlyMaiNails</h1>
                    </li>

                    <ul class="hidden gap-4 lg:flex ml-auto" data-aos="fade-down" data-aos-delay="100">
                        <li class="cursor-pointer"><a class="ux-link" href="{{ route('shop.orders') }}">My Orders</a></li>
                        <li class="cursor-pointer"><a class="ux-link" href="{{ Route('shop.cart') }}">Cart</a></li>
                        <li class="cursor-pointer"><a class="ux-link" href="{{ route('user.history_booking') }}">Booking History</a></li>
                        <li class="cursor-pointer"><a class="ux-link" href="{{ route('user.change_profile') }}">Change Profile</a></li>
                    </ul>

                    <li class="">
                        <div class="flex justify-end gap-5">
                            <div class="inline-flex items-center ">
                                <div class="relative">
                                    <button id="notificationButton" class="p-2 text-white bg-blue-600 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                        </svg>
                                        @if (count($notification) > 0)
                                            <span
                                                class="absolute top-0 left-0 flex items-center justify-center p-2 text-white transform -translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full notification-badge"
                                                wire:poll.10s>{{ count($notification->where('is_read', '=', '0')) }}</span>
                                        @endif
                                    </button>
                                    <!-- Dropdown Container -->
                                    <div id="dropdown"
                                        class="absolute right-0  hidden w-64 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg"
                                        wire:ignore.self wire:poll.10s>
                                        <!-- Dropdown Header -->
                                        <div class="flex items-center justify-between p-4 border-b">
                                            <h3 class="font-semibold">Notifications</h3>
                                            <a class="font-semibold text-blue-600 underline cursor-pointer"
                                                wire:click="readAll()">Read All</a>
                                        </div>
                                        <!-- Notification List -->
                                        <ul class="overflow-y-auto h-52">
                                            @if (count($notification) > 0)
                                                @foreach ($notification as $notif)
                                                    <li class="p-0 m-0 border-b last:border-0">
                                                        <a target="_blank" wire:click='readNotif({{ $notif->id }})'
                                                            href="{{ $notif->url }}"
                                                            class="flex items-center justify-between p-4 space-x-2 hover:bg-gray-100">
                                                            <div class="flex items-center space-x-2">
                                                                <div class="text-sm">
                                                                    <p class="font-semibold">
                                                                        {{ $notif->title_notification }}</p>
                                                                    <small>{{ $notif->description_notification }}</small>
                                                                </div>
                                                            </div>
                                                            @if (!$notif->is_read)
                                                                <div class="p-1 bg-red-600 rounded-full"></div>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>
                                                    <h2 class="py-5 font-semibold text-center">There is no new
                                                        notification</h2>
                                                </li>
                                            @endif
                                        </ul>
                                        <!-- View More Link -->
                                        <div class="w-full p-4 text-center border-t">
                                            <button class="font-semibold text-blue-600 underline cursor-pointer"
                                                wire:click='showMoreNotification()'>View More</button>
                                        </div>
                                    </div>
                                    <!-- Styles for the Dropdown -->
                                    <style>
                                        #dropdown {
                                            max-height: 400px;
                                            /* Adjust as needed for overall max height */
                                        }

                                        #dropdown ul {
                                            max-height: 200px;
                                            /* Adjust as needed for notification list height */
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>

                    </li>
                </ul>
            @endif
        </div>
    </div>
    <section id="nav-dekstop" class="bg-primary p-3 hidden lg:block lg:fixed lg:top-12 lg:left-0 lg:right-0 z-40 w-full   xl:px-32 px-5 " data-aos="fade-down">
        <div class="flex justify-between w-full ">
            {{-- Logo --}}
            <div class="">
                <h1 class="julius-sans-one-regular text-4xl !tracking-[15%] ">ONLYMAINAILS</h1>
            </div>
            {{-- Logo --}}
            {{-- Menu --}}
            <div class="flex items-center justify-center " data-aos="fade-down" data-aos-delay="60">
                <ul class="flex justify-center gap-5 uppercase list-none">
                    <li><a class="ux-link" href="{{ Route('home') }}">Home</a></li>
                    <li><a class="ux-link" href="{{ Route('services') }}">Our Services</a></li>
                    <li><a class="ux-link" href="{{ Route('shop.index') }}">Shop</a></li>
                    @if (empty(Auth::user()->role))
                    <li><a class="ux-link" href="{{ Route('shop.cart') }}">Cart</a></li>
                    @endif
                    <li><a class="ux-link" href="{{ Route('contact_us') }}">Contact Us</a></li>
                    <li class=""><a class="p-4 bg-white border border-white border-spacing-5 rounded-xl ux-btn"
                            href="{{ Route('book') }}">Book Now</a></li>
                </ul>
            </div>
            {{-- Menu --}}
        </div>
    </section>
    <!-- Desktop spacer to offset fixed header height -->
    <div class="hidden lg:block h-24"></div>
    <section id="nav-mobile" class="bg-primary px-5 lg:hidden fixed bottom-0 w-full  rounded-t-lg " style="z-index: 1000 !important;" data-aos-skip >
        <div class="flex justify-between w-full p-2">
            {{-- Menu --}}
            <div class="flex items-center w-full justify-evenly">
                <ul class="flex items-center w-full gap-5 uppercase list-none justify-evenly">
                    <li>
                        <a href="{{ Route('home') }}"
                            class="flex flex-col items-center justify-between h-full p-2 text-center ux-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            {{-- <p class="mt-2 text-xs">Home</p> --}}
                        </a>
                    </li>
                    <li class="z-10">
                        <a href="{{ Route('services') }}"
                            class="flex flex-col items-center justify-between h-full p-2 text-center ux-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3.75v16.5M2.25 12h19.5M6.375 17.25a4.875 4.875 0 0 0 4.875-4.875V12m6.375 5.25a4.875 4.875 0 0 1-4.875-4.875V12m-9 8.25h16.5a1.5 1.5 0 0 0 1.5-1.5V5.25a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v13.5a1.5 1.5 0 0 0 1.5 1.5Zm12.621-9.44c-1.409 1.41-4.242 1.061-4.242 1.061s-.349-2.833 1.06-4.242a2.25 2.25 0 0 1 3.182 3.182ZM10.773 7.63c1.409 1.409 1.06 4.242 1.06 4.242S9 12.22 7.592 10.811a2.25 2.25 0 1 1 3.182-3.182Z" />
                            </svg>
                            {{-- <p class="mt-2 text-xs">Services</p> --}}
                        </a>
                    </li>
                    <li class="absolute p-2  bottom-5 bg-primary  rounded-full z-0 ">
                        <a href="{{ Route('book') }}"
                            class="flex flex-col items-center justify-between h-full p-2 text-center ux-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            <p class="mt-2 text-xs"></p>
                        </a>
                    </li>
                    <li class="z-10">
                        <a href="{{ route('shop.index') }}" class="flex flex-col items-center justify-between h-full p-2 text-center ux-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                            </svg>
                            {{-- <p class="mt-2 text-xs">Shop</p> --}}
                        </a>
                    </li>
                    <li>
                        <a wire:click="toggleDrawer"
                            class="flex flex-col items-center justify-between h-full p-2 text-center ux-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                            </svg>
                            {{-- <p class="mt-2 text-xs">More</p> --}}
                        </a>
                    </li>
                </ul>
            </div>
            {{-- Menu --}}
        </div>
    </section>
    {{-- Drawer --}}
    <div x-data="{ isOpen: @entangle('isOpen') }" x-show="isOpen" class="fixed inset-0  bg-gray-500 bg-opacity-35"
        @click="isOpen = false">
        <div class="fixed top-0 left-0 z-40 w-3/5 h-full p-4 transition-transform transform bg-white shadow-xl"
            @click.stop x-show="isOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full">
            {{-- <button @click="isOpen = false" class="px-4 py-2 text-white bg-red-500">
                Close Drawer
            </button> --}}
            <h1 class="text-3xl">OnlyMaiNails</h1>
            @if (!empty(Auth::user()->role))
                <p>Hello, <span class="font-semibold">{{ Auth::user()->name }}</span></p>
            @endif
            @if (empty(Auth::user()->role))
                <div class="flex flex-col justify-between h-[93%] ">
                    <div class="gap-5 py-10">
                        <ul class="flex flex-col gap-5">
                            <a href="{{ route('user.login') }}">
                                <li class="flex gap-3">
                                    {{-- Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                    </svg>

                                    {{-- Icon --}}
                                    {{-- Text --}}
                                    <div class="">
                                        <p>Login</p>
                                    </div>
                                    {{-- Text --}}
                                </li>
                            </a>
                            <a href="{{ route('user.signup') }}">
                                <li class="flex gap-3">
                                    {{-- Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                                    </svg>

                                    {{-- Icon --}}
                                    {{-- Text --}}
                                    <div class="">
                                        <p>Sign Up</p>
                                    </div>
                                    {{-- Text --}}
                                </li>
                            </a>
                        </ul>
                    </div>
                </div>
            @else
                <div class="flex flex-col justify-between h-[93%] ">
                    <div class="py-4">
                        <ul class="flex flex-col gap-5 list-none">
                            <a href="{{ route('shop.orders') }}">
                                <li class="flex gap-3">
                                    {{-- Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.801 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                    </svg>
                                    {{-- Icon --}}
                                    {{-- Text --}}
                                    <div class="">
                                        <p>My Orders</p>
                                    </div>
                                    {{-- Text --}}
                                </li>
                            </a>
                            <a href="{{ route('user.history_booking') }}">
                                <li class="flex gap-3">
                                    {{-- Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                    </svg>
                                    {{-- Icon --}}
                                    {{-- Text --}}
                                    <div class="">
                                        <p>Booking History</p>
                                    </div>
                                    {{-- Text --}}
                                </li>
                            </a>
                            <a href="{{ route('user.change_profile') }}">
                                <li class="flex gap-3">
                                    {{-- Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    {{-- Icon --}}
                                    {{-- Text --}}
                                    <div class="">
                                        <p>Change Profile</p>
                                    </div>
                                    {{-- Text --}}
                                </li>
                            </a>
                        </ul>
                    </div>
                    <div class="py-4">

                        <a wire:click="logout" class="cursor-pointer" >
                        <div class="flex gap-3">

                            {{-- Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>
                            {{-- Icon --}}
                            {{-- Text --}}
                            <div class="">
                                <p>Logout</p>
                            </div>
                            {{-- Text --}}

                        </div>
                    </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {{-- Drawer --}}
    @if (Auth::user())
        @if (Auth::user()->email_verified_at == null && Auth::user()->gauth_id == null)
            <div class="w-full p-4 bg-brand-base-1 border-t border-white lg:mt-24">
                <p class="text-center">
                    Oops! Your email isn’t verified yet.
                    <a wire:click='resendverified' class='underline cursor-pointer'>
                        <span wire:loading.remove>Click here</span>
                        <span wire:loading>Sending your email...</span>
                    </a>
                    to resend the verification link.
                </p>
            </div>
        @endif
    @endif

</div>
