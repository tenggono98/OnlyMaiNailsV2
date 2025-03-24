@props([
    'type' => 'button',
    'color' => 'primary', // primary, secondary, success, danger
    'size' => 'base', // sm, base, lg
    'fullWidth' => false,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg focus:ring-4 focus:outline-none';
$colorClasses = match($color) {
    'primary' => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
    'secondary' => 'text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700',
    'success' => 'text-white bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800',
    'danger' => 'text-white bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800',
    default => 'text-white bg-blue-700 hover:bg-blue-800 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'
};
$sizeClasses = match($size) {
    'sm' => 'px-3 py-2 text-sm',
    'lg' => 'px-5 py-3 text-base',
    default => 'px-4 py-2.5 text-sm'
};
$widthClass = $fullWidth ? 'w-full' : '';

$classes = "{$baseClasses} {$colorClasses} {$sizeClasses} {$widthClass}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>