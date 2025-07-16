@props(['name', 'label', 'min', 'max', 'step' => '1', 'value' => '', 'unit' => '', 'id' => ''])

<div class="mb-4">
    <label for="{{ $id ?: $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
    </label>
    <div class="relative">
        <input 
            type="range" 
            name="{{ $name }}" 
            id="{{ $id ?: $name }}" 
            min="{{ $min }}" 
            max="{{ $max }}" 
            step="{{ $step }}" 
            value="{{ $value }}" 
            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
            oninput="updateSliderValue('{{ $id ?: $name }}', this.value, '{{ $unit }}')"
        >
        <div class="flex justify-between text-xs text-gray-500 mt-1">
            <span>{{ $min }}{{ $unit }}</span>
            <span id="{{ $id ?: $name }}_value" class="font-medium text-gray-700">{{ $value ?: $min }}{{ $unit }}</span>
            <span>{{ $max }}{{ $unit }}</span>
        </div>
    </div>
</div>

<script>
function updateSliderValue(sliderId, value, unit) {
    document.getElementById(sliderId + '_value').textContent = value + unit;
}
</script>

<style>
.slider::-webkit-slider-thumb {
    appearance: none;
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.slider::-moz-range-thumb {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
</style>
