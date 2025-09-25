<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <h1 class="mb-4 text-xl ">Client Register</h1>
    <!-- Client information form goes here -->
    @if (!Auth::user())
        <div class="flex flex-col gap-3 p-4 my-5 border-brand-accent-light border rounded-lg">
            <div class="flex-auto">
                <label for="">Full Name <span class="text-xs text-red-600">*</span></label><br>
                <input type="text" class="w-full form-control" name="" id="" wire:model='fullNameClient'>
                <x-pages.inputs.error error='fullNameClient' />
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="">
                    <label for="">Phone Number <span class="text-xs text-red-600">*</span></label>
                    <input type="text" name="" id="" class="w-full form-control phone-format"
                        wire:model='phoneNumberClient'>
                    <x-pages.inputs.error error='phoneNumberClient' />
                </div>
                <div class="">
                    <label for="">Email <span class="text-xs text-red-600">*</span></label>
                    <input type="email" name="" id="" class="w-full form-control"
                        wire:model='emailClient'>
                    <x-pages.inputs.error error='emailClient' />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <div class="">
                    <label for="">Password <span class="text-xs text-red-600">*</span></label>
                    <input type="password" name="" id="" class="w-full form-control"
                        wire:model='passwordClient'>
                    <x-pages.inputs.error error='passwordClient' />
                </div>
                <div class="">
                    <label for="">Confirm password <span class="text-xs text-red-600">*</span></label>
                    <input type="password" name="" id="" class="w-full form-control"
                        wire:model='confrimPasswordClient'>
                    <x-pages.inputs.error error='confrimPasswordClient' />
                </div>
            </div>
            <div class="">
                <label for="">Instagram</label>
                <input type="text" name="" class="w-full form-control" id="" wire:model='igClient' placeholder="@onlymainails">
            </div>
            <div class="flex items-center py-5">
                <div class="flex-auto">
                    <hr class="border-t border-brand-accent-light">
                </div>
                <div class="px-4">
                    <h1 class="text-lg text-center">OR</h1>
                </div>
                <div class="flex-auto">
                    <hr class="border-t border-brand-accent-light">
                </div>
            </div>
            <div class="">
                <a href="{{ route('oauth.google') }}" class="w-full">
                    <div
                        class="bg-brand-accent-light flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-brand-accent-light hover:bg-transparent cursor-pointer">
                        <div class="">
                            <svg class="w-8 h-8 text-red-500" width="24" height="24" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" />
                                <path d="M17.788 5.108A9 9 0 1021 12h-8" />
                            </svg>
                        </div>
                        <div class="flex items-center">
                            <p>Sign in with Google</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @else
        <div class="p-4 my-5 border-brand-accent-light border rounded-lg">
            <h1>Hello, {{ Auth::user()->name }}!</h1>
            <p>Is this your account? If not, you can switch to a different one.</p>
            <a wire:click="logout"
                class="bg-brand-accent-light flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-brand-accent-light hover:bg-transparent cursor-pointer my-3">Logout</a>
            @if (Auth::user()->phone == null)
                <p class="my-2 font-bold">You're need to fill in some required information</p>
                <div class="">
                    <label for="">Phone Number <span class="text-xs text-red-600">*</span></label>
                    <input type="number" name="" id="" class="w-full form-control"
                        wire:model='phoneNumberClient'>
                    <x-pages.inputs.error error='phoneNumberClient' />
                </div>
            @endif
            @if (Auth::user()->ig_tag == null)
                <div class="">
                    <label for="">Instagram</label>
                    <input type="text" name="" class="w-full form-control" id=""
                        wire:model='igClient'>
                </div>
            @endif
            <div class="my-3">
                <h1>Your Information</h1>
                <div class="flex flex-wrap gap-5 ">
                    <div class="">
                        <label for="">Full Name</label>
                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="">
                        <label for="">Email</label>
                        <p class="font-semibold">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="">
                        <label for="">Phone Number</label>
                        <p class="font-semibold">{{ Auth::user()->phone }}</p>
                    </div>
                    <div class="">
                        <label for="">Instagram</label>
                        <p class="font-semibold">{{ Auth::user()->ig_tag }}</p>
                    </div>
                </div>
            </div>
            <div class="">
                <p>If you want to change the detail, please click this link <a
                        href="{{ route('user.change_profile', ['id' => Auth::user()->id]) }}"
                        class="font-semibold underline underline-offset-4">Change Profile</a></p>
            </div>
        </div>
    @endif
    <div class="flex w-full gap-3">
        <div class="flex-auto">
            <button wire:click="store()" type="button"
                class="bg-brand-accent-light flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-brand-accent-light hover:bg-transparent cursor-pointer w-full flex">
                <!-- Default text -->
                <span>Submit</span>
                @if (Auth::user() == null)
                    <!-- Loading text with spinner -->
                    <span wire:loading wire:target="next">
                        Creating your Account...
                    </span>
                @endif
            </button>
        </div>
    </div>
</div>
</div>
