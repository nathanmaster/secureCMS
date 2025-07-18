<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Weight Option') }}
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
                    <form action="{{ route('admin.weight-options.update', $weightOption) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Value -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Value <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="value" 
                                   id="value" 
                                   value="{{ old('value', $weightOption->value) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., 0-100, 250-500, 1000+"
                                   required>
                            @error('value')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Unique identifier for this weight option (e.g., '0-100', '250-500', '1000+')</p>
                        </div>

                        <!-- Label -->
                        <div>
                            <label for="label" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Label <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="label" 
                                   id="label" 
                                   value="{{ old('label', $weightOption->label) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="e.g., Light (0-100g), Medium (250-500g)"
                                   required>
                            @error('label')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Display name for this weight option</p>
                        </div>

                        <!-- Min Weight -->
                        <div>
                            <label for="min_weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Minimum Weight (grams)
                            </label>
                            <input type="number" 
                                   name="min_weight" 
                                   id="min_weight" 
                                   value="{{ old('min_weight', $weightOption->min_weight) }}"
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
                                   value="{{ old('max_weight', $weightOption->max_weight) }}"
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
                                   value="{{ old('sort_order', $weightOption->sort_order) }}"
                                   min="0"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
                        </div>

                        <!-- Is Active -->
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active" 
                                   value="1"
                                   {{ old('is_active', $weightOption->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                Active (available for selection)
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.weight-options.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Weight Option
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
