@props([
    'maxWidth' => '2xl',
    'title' => '',
])

@php
$maxWidthClass = match($maxWidth) {
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    '6xl' => 'sm:max-w-6xl',
    '7xl' => 'sm:max-w-7xl',
    default => 'sm:max-w-2xl'
};
@endphp

<div {{ $attributes->merge(['class' => 'fixed inset-0 z-50 overflow-y-auto']) }} aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:p-6 {{ $maxWidthClass }}">
            @if($title)
            <div class="mb-4 border-b">
                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                    {{ $title }}
                </h3>
            </div>
            @endif

            <div class="mt-2">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>