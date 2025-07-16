@props(['id'])

<div x-show="activeTab === '{{ $id }}'" x-transition>
    {{ $slot }}
</div>
