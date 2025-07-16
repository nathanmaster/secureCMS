@props(['cols' => 1, 'gap' => 6])

@php
$colClasses = [
    1 => 'grid-cols-1',
    2 => 'grid-cols-1 md:grid-cols-2',
    3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
    5 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-5',
    6 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-6',
];

$gapClasses = [
    1 => 'gap-1',
    2 => 'gap-2',
    3 => 'gap-3',
    4 => 'gap-4',
    5 => 'gap-5',
    6 => 'gap-6',
    8 => 'gap-8',
];
@endphp

<div {{ $attributes->merge(['class' => "grid {$colClasses[$cols]} {$gapClasses[$gap]}"]) }}>
    {{ $slot }}
</div>
