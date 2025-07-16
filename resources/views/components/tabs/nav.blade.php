@props(['tabs' => []])

<div class="border-b border-gray-200 dark:border-gray-700">
    <nav class="-mb-px flex space-x-8">
        @foreach($tabs as $tab)
            <button 
                @click="activeTab = '{{ $tab['id'] }}'"
                :class="activeTab === '{{ $tab['id'] }}' ? 'border-blue-500 text-blue-600 dark:text-blue-500' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                class="whitespace-nowrap border-b-2 py-2 px-1 text-sm font-medium"
            >
                {{ $tab['title'] }}
            </button>
        @endforeach
    </nav>
</div>
