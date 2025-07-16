@props(['padding' => 'p-6', 'shadow' => 'shadow-sm', 'rounded' => 'rounded-lg'])

<div {{ $attributes->merge(['class' => "bg-white dark:bg-gray-800 overflow-hidden $shadow $rounded border border-gray-200 dark:border-gray-700 $padding"]) }}>
    {{ $slot }}
</div>
