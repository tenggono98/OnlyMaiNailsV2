<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="">
        @if($userType == null)
        <x-pages.admin.title-header-admin title="Select Account Type" />
        <div class="mt-5">
            <div class="flex flex-wrap items-center gap-4 justify-normal">
                <div class="flex-auto ">
                    <a href="{{ route('admin.users.type',['type' => 'admin']) }}">
                        <button
                            class="w-full p-4 text-2xl text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-400">Admin</button>
                    </a>
                </div>
                <div class="flex-auto ">
                    <a href="{{ route('admin.users.type',['type' => 'user']) }}">
                        <button
                            class="w-full p-4 text-2xl text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-400">User</button>
                    </a>
                </div>
            </div>
        </div>
        @else

        <x-pages.admin.title-header-admin title="Account" />

        @endif
    </div>
</div>
