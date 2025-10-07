@props([
  'scope' => 'col',
  'align' => 'left', // left|center|right
  'width' => null,
])

@php
  $base = 'px-6 py-3 text-xs font-medium uppercase tracking-wider text-gray-500';
  $alignClass = $align === 'right' ? 'text-right' : ($align === 'center' ? 'text-center' : 'text-left');
  $widthStyle = $width ? 'width: '.$width.';' : '';
@endphp

<th scope="{{ $scope }}" style="{{ $widthStyle }}" {{ $attributes->merge(['class' => $base.' '.$alignClass]) }}>
  {{ $slot }}
</th>



