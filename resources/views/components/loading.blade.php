@props(['size' => 'md'])

@php
$sizes = [
    'sm' => 'h-4 w-4',
    'md' => 'h-6 w-6',
    'lg' => 'h-8 w-8',
    'xl' => 'h-12 w-12'
];
@endphp

<div class="flex items-center justify-center">
    <div class="animate-spin rounded-full border-2 border-gray-300 border-t-blue-600 {{ $sizes[$size] }}"></div>
</div>
