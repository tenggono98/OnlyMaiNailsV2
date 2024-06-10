@props([
    'type' => 'default',
    'value' => 'default',
    'size' => 'text-xs',
    'action' => 'button',
    'icon' => '',

])

@php

@endphp

@switch($type)
        @case('danger')
        <button type="{{ $action }}" {{ $attributes->merge(['class'=>' w-full  focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg '.$size .' p-4   dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900']) }}>{!! $value !!}</button>

        @break

        @case('success')
        <button type="{{ $action }}" {{ $attributes->merge(['class'=>' w-full  focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg '.$size .' p-4   dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800']) }}>{!! $value !!}</button>

        @break

        @case('info')
        <button type="{{ $action }}" {{ $attributes->merge(['class'=>' w-full  focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg '.$size .' p-4   dark:focus:ring-yellow-900']) }}>{!! $value !!}</button>
        @break

        @case('icon')
        <button type="{{ $action }}" {{ $attributes->merge(['class'=>' w-full  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg '.$size .' p-4   dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800']) }}>

            <div class="flex gap-3">

                @if($value )
                <div class="flex items-center">
                    {{ $value }}
                </div>
                @endif
                <div class="flex items-center">
                    {!! $icon !!}

                </div>

            </div>
        </button>


        @break
    @default
        <button type="{{ $action }}" {{ $attributes->merge(['class'=>'w-full  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg '.$size .' p-4   dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800']) }}>{!! $value !!}</button>

@endswitch





