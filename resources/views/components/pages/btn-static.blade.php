@props([
    'type' => 'default',
    'value' => 'default',
    'size' => 'text-xs',
    'action' => 'button',
    'icon' => '',
])


@php
    $padding = 'px-3 py-1.5';
    if ($size === 'text-sm') { $padding = 'px-4 py-2'; }
    if ($size === 'text-base' || $size === 'text-lg') { $padding = 'px-5 py-2.5'; }
    $base = 'inline-flex items-center rounded-lg font-medium '.$size.' '.$padding.' focus:ring-2 focus:ring-offset-2 border';
@endphp

@switch($type)
    @case('danger')
    <button type="{{ $action }}"
            {{ $attributes->merge(['class' => $base.' text-red-700 bg-white hover:bg-gray-50 border-red-200 focus:ring-red-500']) }}>
        <span >{{ $value }}</span>
    </button>
    @break

    @case('success')
    <button type="{{ $action }}"
            {{ $attributes->merge(['class' => $base.' text-green-700 bg-white hover:bg-gray-50 border-green-200 focus:ring-green-500']) }}>
        <span >{{ $value }}</span>
    </button>
    @break

    @case('info')
    <button type="{{ $action }}"
            {{ $attributes->merge(['class' => $base.' text-blue-700 bg-white hover:bg-gray-50 border-blue-200 focus:ring-blue-500']) }}>
        <span >{{ $value }}</span>

    </button>
    @break

    @case('icon')
    <button type="{{ $action }}"
            {{ $attributes->merge(['class' => $base.' text-gray-700 bg-white hover:bg-gray-50 border-gray-200 focus:ring-gray-500']) }}>
        <div class="flex items-center gap-2">
            @if($value)
            <span >{{ $value }}</span>
            @endif
            {!! $icon !!}
        </div>
    </button>
    @break

    @default
    <button type="{{ $action }}"
            {{ $attributes->merge(['class' => $base.' text-gray-700 bg-white hover:bg-gray-50 border-gray-200 focus:ring-gray-500']) }}>
        <span >{{ $value }}</span>

    </button>
@endswitch
