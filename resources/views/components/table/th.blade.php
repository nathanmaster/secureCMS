@props(['sortable' => false, 'direction' => null])

<th {{ $attributes->merge(['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider']) }}>
    @if($sortable)
        <button class="group inline-flex items-center hover:text-gray-700 dark:hover:text-gray-300">
            {{ $slot }}
            <span class="ml-2 flex-none rounded text-gray-400 group-hover:text-gray-500">
                @if($direction === 'asc')
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 10l5-5 5 5H5z"/>
                    </svg>
                @elseif($direction === 'desc')
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M15 10l-5 5-5-5h10z"/>
                    </svg>
                @else
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 12l5 5 5-5H5zm0-4l5-5 5 5H5z"/>
                    </svg>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th>
