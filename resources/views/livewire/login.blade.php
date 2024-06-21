<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <div class="grid gap-3 p-4 border rounded-lg lg:grid-cols-2">
        <div class="">
            <img src="" alt="">
        </div>
        <div class="">

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

                </div>

                <div class="flex w-full gap-3">

                    <div class="flex-auto">

                        <button  type="submit"
                            class="bg-[#fadde1] flex gap-4 justify-center rounded-lg p-3 hover:border hover:border-[#fadde1] hover:bg-transparent cursor-pointer w-full">Login</button>

                    </div>

                </div>



            </form>


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



</div>
