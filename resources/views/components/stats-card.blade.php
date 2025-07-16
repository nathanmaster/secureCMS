@props(['title', 'value', 'description' => null, 'icon' => null, 'color' => 'blue'])

@php
$colorClasses = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'yellow' => 'bg-yellow-500',
    'red' => 'bg-red-500',
    'purple' => 'bg-purple-500',
    'indigo' => 'bg-indigo-500',
    'gray' => 'bg-gray-500'
];
@endphp

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6">
        <div class="flex items-center">
            @if($icon)
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-8 w-8 rounded-md {{ $colorClasses[$color] }} text-white">
                        {!! $icon !!}
                    </div>
                </div>
            @endif
            
            <div class="{{ $icon ? 'ml-5' : '' }} w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $title }}</dt>
                    <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $value }}</dd>
                    @if($description)
                        <dd class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $description }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
