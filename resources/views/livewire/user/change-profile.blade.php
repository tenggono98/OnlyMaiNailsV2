<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class=" lg:mx-auto">
        <div class="">
            <h1>Hello, Dear {{ $user->name }}</h1>
        </div>
        <div class="">
            <div class="grid grid-cols-1 gap-3 my-5 lg:grid-cols-2">
                <div class="">
                    <label for="">Full Name <span class="text-xs text-red-600">*</span></label>
                    <input class="w-full form-control" type="text" wire:model='fullNameClient'>
                    <x-pages.inputs.error error='fullNameClient' />
                </div>
                <div class="">
                    <label for="">Email <span class="text-xs text-red-600">*</span></label>
                    <p>{{ $user->email }}</p>
                    {{-- <a href="">Change Email</a> --}}
                </div>
                <div class="">
                    <label for="">Phone Number <span class="text-xs text-red-600">*</span></label>
                    <input class="w-full form-control" type="number" wire:model='phoneNumberClient'>
                    <x-pages.inputs.error error='phoneNumberClient' />
                </div>
                <div class="">
                    <label for="">Instagram</label>
                    <input class="w-full form-control" type="text" wire:model='igTagClient'>
                </div>
            </div>
                <div class="grid grid-cols-1  gap-3 my-5 border lg:grid-cols-2 border-[#fadde1] rounded-lg p-4">

                    <div class="lg:col-span-2">
                        <label for="">Old Password</label>
                        <input class="w-full form-control" type="password" wire:model='oldPassword'>
                        <x-pages.inputs.error error='oldPassword' />
                    </div>
                    <div class="">
                        <label for="">New Password</label>
                        <input class="w-full form-control" type="password" wire:model='password'>
                        <x-pages.inputs.error error='password' />
                    </div>
                    <div class="">
                        <label for="">Confirm New Password</label>
                        <input class="w-full form-control" type="password" wire:model='confirmPassword'>
                        <x-pages.inputs.error error='confirmPassword' />
                    </div>
                    <div class="lg:col-span-2">
                        <small>To update your password, please fill in the required information. If you do not wish to
                            change your password, you can leave these fields empty.</small>
                    </div>
                </div>

            <button wire:click="save()" type="button"
                class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">
                <!-- Default text -->
                <span wire:loading.remove wire:target="save">Save</span>
                <!-- Loading text with spinner -->
                <span wire:loading wire:target="save" class="animate-pulse">
                    Updated your Account...
                </span>
            </button>
        </div>
    </div>
</div>
