<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <div class="grid gap-5 p-4  rounded-lg lg:grid-cols-2">
        <div class="relative flex items-center justify-center overflow-hidden">
            @if(count($loginImages) > 0)
            <div class="w-full">
                <div class="relative">
                <img src="{{ asset('storage/' . $loginImages[$currentImageIndex]->image_path) }}"
                     alt="{{ $loginImages[$currentImageIndex]->alt_text }}"
                     class="object-cover w-full h-auto rounded-lg max-h-[600px] transition-opacity duration-500">

                <!-- Navigation arrows -->
                @if(count($loginImages) > 1)
                    <button wire:click="prevImage" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/50 hover:bg-white/80 rounded-full p-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    </button>
                    <button wire:click="nextImage" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/50 hover:bg-white/80 rounded-full p-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    </button>

                    <!-- Dots indicator -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    @foreach($loginImages as $index => $image)
                        <button wire:click="setImage({{ $index }})" class="h-2 w-2 rounded-full {{ $currentImageIndex === $index ? 'bg-white' : 'bg-white/50' }}"></button>
                    @endforeach
                    </div>
                @endif
                </div>
            </div>
            @else
            <div class="flex items-center justify-center w-full h-64 bg-gray-100 rounded-lg">
                <p class="text-gray-500">No login image available</p>
            </div>
            @endif
        </div>
        <div class="flex flex-col justify-center">

            <h1 class="my-5 font-semibold">Welcome Back</h1>

            <form wire:submit='login'>
                @csrf

                <div class="flex flex-col gap-3 p-4 my-5 border-[#fadde1] border rounded-lg">

                    <div class="flex-auto">
                        <label for="">Email</label><br>
                        <input type="email" class="w-full form-control" name="" id=""
                            wire:model='email'>
                        <x-pages.inputs.error error='email' />
                    </div>

                    <div class="flex-auto">
                        <label for="">Password</label><br>
                        <input type="password" class="w-full form-control" name="" id=""
                            wire:model='password'>
                        <x-pages.inputs.error error='password' />
                    </div>
                    <div class="flex-auto ">
                        <div class="float-end">
                        <a href="{{ route('password.request') }}" class="text-right hover:text-[#bca5a8]">Forget your password ?</a>

                        </div>

                    </div>


                </div>

                <div class="flex w-full gap-3">

                    <div class="flex-auto">

                        <button  type="submit"
                            class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">Login</button>

                    </div>

                </div>

            </form>

            <div class="mt-4 text-center">
                <p>Don't have an account? <button type="button" @click="$dispatch('open-modal')" class="font-semibold text-[#bca5a8] hover:underline">Sign Up</button></p>
            </div>

            <div class="flex items-center py-5">
                <div class="flex-auto">
                    <hr class="border-t border-[#fadde1]">
                </div>
                <div class="px-4">
                    <h1 class="text-lg text-center">OR</h1>
                </div>
                <div class="flex-auto">
                    <hr class="border-t border-[#fadde1]">
                </div>
            </div>

            <a href="{{ route('oauth.google') }}" class="w-full">
            <div class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer">
                <div class="">
                    <svg class="w-8 h-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M17.788 5.108A9 9 0 1021 12h-8" /></svg>
                </div>
                <div class="flex items-center">
                    <p>Sign in with Google</p>
                </div>

            </div>
            </a>


            <div class="flex">

            </div>


        </div>

    </div>

    <!-- Registration Modal -->
    <div x-data="{ open: false }"
         @open-modal.window="open = true"
         @close-modal.window="open = false"
         @keydown.escape.window="open = false">

        <!-- Modal Backdrop -->
        <div x-show="open"
             class="fixed inset-0 z-40 bg-black bg-opacity-50"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Modal Content -->
        <div x-show="open"
             x-trap="open"
             class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95">

            <div class="w-11/12 max-w-md p-6 mx-auto bg-white rounded-lg shadow-xl md:w-2/3 lg:w-1/2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold">Create an Account</h2>
                    <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Sign Up Form -->
                <form wire:submit.prevent="register">
                    @csrf

                    <div class="flex flex-col gap-3 p-4 my-4 border-[#fadde1] border rounded-lg">
                        <div class="flex-auto">
                            <label for="fullName">Full Name <span class="text-xs text-red-600">*</span></label><br>
                            <input type="text" class="w-full form-control" id="fullName" wire:model="fullName">
                            <x-pages.inputs.error error='fullName' />
                        </div>

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <div class="">
                                <label for="phoneNumber">Phone Number <span class="text-xs text-red-600">*</span></label>
                                <input type="number" id="phoneNumber" class="w-full form-control" wire:model="phoneNumber">
                                <x-pages.inputs.error error='phoneNumber' />
                            </div>
                            <div class="">
                                <label for="regEmail">Email <span class="text-xs text-red-600">*</span></label>
                                <input type="email" id="regEmail" class="w-full form-control" wire:model="regEmail">
                                <x-pages.inputs.error error='regEmail' />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <div class="">
                                <label for="regPassword">Password <span class="text-xs text-red-600">*</span></label>
                                <input type="password" id="regPassword" class="w-full form-control" wire:model="regPassword">
                                <x-pages.inputs.error error='regPassword' />
                            </div>
                            <div class="">
                                <label for="confirmPassword">Confirm password <span class="text-xs text-red-600">*</span></label>
                                <input type="password" id="confirmPassword" class="w-full form-control" wire:model="confirmPassword">
                                <x-pages.inputs.error error='confirmPassword' />
                            </div>
                        </div>

                        <div class="">
                            <label for="igTag">Instagram</label>
                            <input type="text" id="igTag" class="w-full form-control" wire:model="igTag">
                        </div>
                    </div>

                    <div class="flex w-full gap-3">
                        <div class="flex-auto">
                            <button type="submit"
                                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">
                                Sign Up
                            </button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>

</div>
