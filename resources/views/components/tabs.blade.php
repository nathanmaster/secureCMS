@props(['active' => null])

<div x-data="{ activeTab: '{{ $active }}' }">
    {{ $slot }}
</div>
