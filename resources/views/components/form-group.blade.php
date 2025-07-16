@props(['label' => null, 'name' => null, 'required' => false, 'error' => null])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
        <x-input-label for="{{ $name }}" :value="$label" :required="$required" />
    @endif
    
    {{ $slot }}
    
    @if($error)
        <x-input-error :messages="$error" class="mt-2" />
    @endif
</div>
