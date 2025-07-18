<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Weight Option') }}
            </h2>
            <a href="{{ route('admin.weight-options.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Weight Options
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.weight-options.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Option Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Option Type <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="option_type" value="range" class="mr-2" onchange="toggleOptionType(this)" checked>
                                    <span class="text-sm">Weight Range (e.g., 0-100g, 250-500g)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="option_type" value="set" class="mr-2" onchange="toggleOptionType(this)">
                                    <span class="text-sm">Set Value (e.g., 3.5g = "1/8", 7g = "1/4")</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Value -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Value <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="value" 
                                   id="value" 
                                   value="{{ old('value') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., 0-100, 250-500, set-3.5"
                                   required>
                            @error('value')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Unique identifier for this weight option</p>
                        </div>

                        <!-- Label -->
                        <div>
                            <label for="label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Label <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="label" 
                                   id="label" 
                                   value="{{ old('label') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., Light (0-100g), 1/8 (3.5g)"
                                   required>
                            @error('label')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Display name for this weight option</p>
                        </div>

                        <!-- Set Value Fields -->
                        <div id="set-value-fields" class="hidden space-y-4">
                            <div>
                                <label for="set_weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Set Weight (grams) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="set_weight" 
                                       id="set_weight" 
                                       value="{{ old('set_weight') }}"
                                       step="0.01"
                                       min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="e.g., 3.5, 7, 14, 28">
                                @error('set_weight')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Exact weight in grams for this option</p>
                            </div>
                            <div class="flex items-center justify-end space-x-4">
                                <a href="{{ route('admin.weight-options.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Create Weight Option
                                </button>
                            </div>
                            <div class="flex items-center">
                            <input id="is_active" 
                                   name="is_active" 
                                   type="checkbox" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                    Option is active and available for use
                                </label>
                            </div>
                        </div>

                        <!-- Range Fields -->
                        <div id="range-fields" class="space-y-4">
                            <!-- Min Weight -->
                            <div>
                                <label for="min_weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Minimum Weight (grams)
                                </label>
                                <input type="number" 
                                       name="min_weight" 
                                       id="min_weight" 
                                       value="{{ old('min_weight') }}"
                                       step="0.01"
                                       min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                @error('min_weight')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Max Weight -->
                            <div>
                                <label for="max_weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Maximum Weight (grams)
                                </label>
                            <input type="number" 
                                       name="max_weight" 
                                       id="max_weight" 
                                       value="{{ old('max_weight') }}"
                                       step="0.01"
                                       min="0"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('max_weight')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Leave empty for open-ended ranges like "1000+"</p>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sort Order
                            </label>
                            <input type="number" 
                                   name="sort_order" 
                                   id="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input id="is_active" 
                                   name="is_active" 
                                   type="checkbox" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                Option is active and available for use
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.weight-options.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Weight Option
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleOptionType(radio) {
            const setFields = document.getElementById('set-value-fields');
            const rangeFields = document.getElementById('range-fields');
            const setWeight = document.getElementById('set_weight');
            const minWeight = document.getElementById('min_weight');
            const maxWeight = document.getElementById('max_weight');
            
            if (radio.value === 'set') {
                setFields.classList.remove('hidden');
                rangeFields.classList.add('hidden');
                setWeight.required = true;
                minWeight.required = false;
                maxWeight.required = false;
            } else {
                setFields.classList.add('hidden');
                rangeFields.classList.remove('hidden');
                setWeight.required = false;
                minWeight.required = true;
                maxWeight.required = false;
            }
        }
    </script>
</x-app-layout>
