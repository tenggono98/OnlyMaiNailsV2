@props([
    'header' => []

])




<div class="relative my-5 overflow-x-auto lg:overflow-visible ">
    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($header as $h )
                <th scope="col" class="px-6 py-3">
                    {{ $h }}
                </th>

                @endforeach
            </tr>
        </thead>
        <tbody>

            {{ $slot }}



        </tbody>
    </table>
</div>




