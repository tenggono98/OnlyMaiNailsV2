<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}



    <div class="container lg:mx-auto">


        <div class="">
            <h1>Hello, Dear {{ $user->name }}</h1>
        </div>


        <div class="">


            <div class="grid grid-cols-1 gap-3 my-5 lg:grid-cols-2">

                <div class="">
                    <label for="">Full Name <span
                        class="text-xs text-red-600">*</span></label>
                    <input class="w-full form-control" type="text" wire:model='fullNameClient'>
                    <x-pages.inputs.error error='fullNameClient' />
                </div>

                <div class="">
                    <label for="">Email <span
                        class="text-xs text-red-600">*</span></label>
                    <p>{{ $user->email }}</p>
                    {{-- <a href="">Change Email</a> --}}
                </div>

                <div class="">
                    <label for="">Phone Number <span
                        class="text-xs text-red-600">*</span></label>
                    <input class="w-full form-control" type="number" wire:model='phoneNumberClient'>
                    <x-pages.inputs.error error='phoneNumberClient' />
                </div>
                <div class="">
                    <label for="">Instagram</label>
                    <input class="w-full form-control" type="text" wire:model='igTagClient'>
                </div>

                <div class="grid grid-cols-1 col-span-2 gap-3 my-5 border lg:grid-cols-2 border-[#fadde1] rounded-lg p-4">
                    <div class="col-span-2">
                        <label for="">Old Password</label>
                        <input class="w-full form-control" type="text" wire:model='oldPassword'>
                        <x-pages.inputs.error error='oldPassword' />
                    </div>


                    <div class="">
                        <label for="">New Password</label>
                        <input class="w-full form-control" type="text" wire:model='password'>
                        <x-pages.inputs.error error='password' />
                    </div>

                    <div class="">
                        <label for="">Confirm New Password</label>
                        <input class="w-full form-control" type="text" wire:model='confirmPassword'>
                        <x-pages.inputs.error error='confirmPassword' />
                    </div>

                    <div class="col-span-2">
                        <h2>To update your password, please fill in the required information. If you do not wish to change your password, you can leave these fields empty.</h2>

                    </div>
                </div>


            </div>

            <button wire:click="save()"
            type="button"
            class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">
        <!-- Default text -->
        <span wire:loading.remove wire:target="next">Save</span>
        <!-- Loading text with spinner -->
        <span wire:loading wire:target="next">
            <svg class="w-5 h-5 mr-3 animate-spin" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0v5a8 8 0 01-16 0v-5z"></path>
            </svg>
                Updated your Account...
            </span>
        </button>

        </div>

    </div>
</div>
