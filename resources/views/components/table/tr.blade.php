@props(['striped' => false])

@php
$rowClass = 'bg-white dark:bg-gray-800';
if ($striped) {
    $rowClass .= ' odd:bg-gray-50 dark:odd:bg-gray-900';
}
@endphp

<tr {{ $attributes->merge(['class' => $rowClass . ' hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors']) }}>
    {{ $slot }}
</tr>
