<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create Product') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                   required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                      placeholder="Enter product description...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Base Price -->
                        <div>
                            <label for="base_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Base Price <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                </div>
                                <input type="number" 
                                       name="base_price" 
                                       id="base_price" 
                                       value="{{ old('base_price') }}"
                                       step="0.01"
                                       min="0"
                                       class="block w-full pl-7 pr-12 border-gray-300 dark:border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('base_price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Fallback price when no weight variants are specified</p>
                        </div>

                        <!-- Weight Variants Section -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Weight-Based Pricing</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure different prices for different weight options. Leave empty to use base price only.</p>
                                </div>
                                <button type="button" onclick="addWeightVariant()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Weight Option
                                </button>
                            </div>
                            
                            <!-- Weight Variants Table -->
                            <div class="overflow-hidden border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-2/5">
                                                Weight Configuration
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-1/5">
                                                Price
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-1/5">
                                                Availability
                                            </th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-1/5">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="weight-variants-container" class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                        <!-- Weight variants will be added here -->
                                    </tbody>
                                </table>
                                
                                <!-- Empty state -->
                                <div id="weight-variants-empty" class="text-center py-12 bg-white dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-4-4m0 0l-4 4m4-4v18"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No weight options</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a weight option for this product.</p>
                                    <div class="mt-6">
                                        <button type="button" onclick="addWeightVariant()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Weight Option
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Template for weight variant (hidden - template will be cloned and modified) -->
                            <template id="weight-variant-template">
                                <tr class="weight-variant-item bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <td class="px-4 py-4">
                                        <div class="space-y-3">
                                            <!-- Weight Type Selection -->
                                            <div class="space-y-2">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="weight_variants[INDEX][type]" value="default" 
                                                           class="text-blue-600 focus:ring-blue-500 focus:ring-2" 
                                                           onchange="toggleWeightType(this)" checked disabled>
                                                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Use Default Option</span>
                                                </label>
                                                
                                                <select name="weight_variants[INDEX][weight_option_id]" 
                                                        class="default-weight-select w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm transition-all" disabled>
                                                    <option value="">Select weight option...</option>
                                                    @foreach($defaultWeightOptions as $option)
                                                        <option value="{{ $option->id }}">{{ $option->label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="weight_variants[INDEX][type]" value="custom" 
                                                           class="text-blue-600 focus:ring-blue-500 focus:ring-2" 
                                                           onchange="toggleWeightType(this)" disabled>
                                                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Custom Weight</span>
                                                </label>
                                                
                                                <div class="custom-weight-inputs space-y-2 hidden">
                                                    <div class="grid grid-cols-1 gap-2">
                                                        <input type="number" name="weight_variants[INDEX][custom_weight]" 
                                                               placeholder="Weight (e.g., 250)" 
                                                               step="0.01" min="0" 
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" disabled>
                                                        <input type="text" name="weight_variants[INDEX][custom_label]" 
                                                               placeholder="Display label (e.g., 250g, 1oz)" 
                                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">$</span>
                                            </div>
                                            <input type="number" name="weight_variants[INDEX][price]" 
                                                   step="0.01" min="0" 
                                                   class="block w-full pl-7 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" 
                                                   placeholder="0.00" required disabled>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="hidden" name="weight_variants[INDEX][is_available]" value="0" disabled>
                                                <input type="checkbox" name="weight_variants[INDEX][is_available]" value="1" checked 
                                                       class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 focus:ring-2 w-4 h-4" disabled>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">Available</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex justify-center">
                                            <button type="button" onclick="removeWeightVariant(this)" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Remove
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Weight (grams)
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" 
                                       name="weight" 
                                       id="weight" 
                                       value="{{ old('weight') }}"
                                       step="0.01"
                                       min="0"
                                       class="block w-full pr-12 border-gray-300 dark:border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">g</span>
                                </div>
                            </div>
                            @error('weight')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Percentage -->
                        <div>
                            <label for="percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Percentage
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" 
                                       name="percentage" 
                                       id="percentage" 
                                       value="{{ old('percentage') }}"
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       class="block w-full pr-12 border-gray-300 dark:border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">%</span>
                                </div>
                            </div>
                            @error('percentage')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" 
                                    id="category_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subcategory -->
                        <div>
                            <label for="subcategory_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Subcategory
                            </label>
                            <select name="subcategory_id" 
                                    id="subcategory_id"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select a subcategory</option>
                                @foreach($subcategories ?? [] as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Image
                            </label>
                            
                            <!-- Upload Area -->
                            <div id="uploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-gray-400 dark:hover:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF, WEBP up to 10MB</p>
                                </div>
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <div class="relative">
                                    <img id="preview" class="h-48 w-48 object-cover rounded-lg mx-auto shadow-md" alt="Preview">
                                    <button type="button" onclick="removePreview()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm">
                                        ×
                                    </button>
                                </div>
                                <div class="text-center mt-2">
                                    <p class="text-sm text-gray-700 dark:text-gray-300 font-medium" id="fileName"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" id="fileSize"></p>
                                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">✓ Ready to upload</p>
                                </div>
                            </div>
                            
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Available -->
                        <div class="flex items-center">
                            <input id="is_available" 
                                   name="is_available" 
                                   type="checkbox" 
                                   value="1"
                                   {{ old('is_available', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_available" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                Product is available for purchase
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                                Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let weightVariantIndex = 0;

        function addWeightVariant() {
            const container = document.getElementById('weight-variants-container');
            const emptyState = document.getElementById('weight-variants-empty');
            const template = document.getElementById('weight-variant-template');
            
            if (!template) {
                console.error('Template not found');
                return;
            }
            
            // Hide empty state if this is the first variant
            if (emptyState) {
                emptyState.style.display = 'none';
            }
            
            // Clone the template content (the <tr> element)
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('tr');
            
            if (!row) {
                console.error('Row not found in template');
                return;
            }
            
            // Replace INDEX with actual index in the HTML
            row.innerHTML = row.innerHTML.replace(/INDEX/g, weightVariantIndex);
            
            // Enable all form inputs (remove disabled attribute)
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.disabled = false;
            });
            
            // Add required attribute to price field
            const priceInput = row.querySelector('input[name*="[price]"]');
            if (priceInput) {
                priceInput.required = true;
            }
            
            // Ensure the default weight option is selected by default
            const defaultRadio = row.querySelector('input[value="default"]');
            if (defaultRadio) {
                defaultRadio.checked = true;
                // Trigger the toggle to ensure proper initial state
                toggleWeightType(defaultRadio);
            }
            
            // Append the row to the container
            container.appendChild(row);
            weightVariantIndex++;
        }

        function removeWeightVariant(button) {
            const row = button.closest('tr');
            const container = document.getElementById('weight-variants-container');
            const emptyState = document.getElementById('weight-variants-empty');
            
            // Remove the row
            row.remove();
            
            // Show empty state if no variants left
            if (container.children.length === 0 && emptyState) {
                emptyState.style.display = 'block';
            }
        }

        function toggleWeightType(radio) {
            const row = radio.closest('tr');
            const defaultSelect = row.querySelector('.default-weight-select');
            const customInputs = row.querySelector('.custom-weight-inputs');
            
            if (radio.value === 'default') {
                // Show default select, hide custom inputs
                defaultSelect.style.display = 'block';
                customInputs.classList.add('hidden');
                defaultSelect.required = true;
                
                // Clear and disable custom inputs
                customInputs.querySelectorAll('input').forEach(input => {
                    input.required = false;
                    input.value = '';
                });
            } else if (radio.value === 'custom') {
                // Hide default select, show custom inputs
                defaultSelect.style.display = 'none';
                customInputs.classList.remove('hidden');
                defaultSelect.required = false;
                defaultSelect.value = '';
                
                // Enable custom inputs
                const weightInput = customInputs.querySelector('input[type="number"]');
                const labelInput = customInputs.querySelector('input[type="text"]');
                if (weightInput) weightInput.required = true;
                if (labelInput) labelInput.required = true;
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    input.value = '';
                    return;
                }
                
                // Validate file size (10MB = 10 * 1024 * 1024 bytes)
                const maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('File size must be less than 10MB.');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    
                    // Hide upload area and show preview
                    uploadArea.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                };
                
                reader.readAsDataURL(file);
            } else {
                resetPreview();
            }
        }
        
        function removePreview() {
            const input = document.getElementById('image');
            input.value = '';
            resetPreview();
        }
        
        function resetPreview() {
            const previewContainer = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            
            previewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        // Add drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission handling
            const form = document.querySelector('form');
            const submitButton = document.querySelector('button[type="submit"]');
            
            if (form && submitButton) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submit event triggered');
                    
                    // Check if any weight variants exist and validate them
                    const container = document.getElementById('weight-variants-container');
                    const variants = container ? container.querySelectorAll('tr') : [];
                    
                    // If there are variants, validate each one
                    for (let i = 0; i < variants.length; i++) {
                        const variant = variants[i];
                        const defaultRadio = variant.querySelector('input[value="default"]:checked');
                        const customRadio = variant.querySelector('input[value="custom"]:checked');
                        const priceInput = variant.querySelector('input[name*="[price]"]');
                        
                        // Validate price is filled
                        if (!priceInput || !priceInput.value || parseFloat(priceInput.value) <= 0) {
                            alert('Please enter a valid price for all weight variants.');
                            e.preventDefault();
                            return false;
                        }
                        
                        // Validate weight configuration
                        if (defaultRadio) {
                            const weightSelect = variant.querySelector('.default-weight-select');
                            if (!weightSelect || !weightSelect.value) {
                                alert('Please select a weight option for all default weight variants.');
                                e.preventDefault();
                                return false;
                            }
                        } else if (customRadio) {
                            const weightInput = variant.querySelector('input[name*="[custom_weight]"]');
                            const labelInput = variant.querySelector('input[name*="[custom_label]"]');
                            if (!weightInput || !weightInput.value || !labelInput || !labelInput.value) {
                                alert('Please fill in both weight and label for all custom weight variants.');
                                e.preventDefault();
                                return false;
                            }
                        }
                    }
                    
                    // Allow form submission if validation passes
                    console.log('Form validation passed, submitting...');
                });
                
                submitButton.addEventListener('click', function(e) {
                    console.log('Submit button clicked');
                    // Don't prevent default - let the form submit naturally
                });
            }
            
            // File upload functionality
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('image');
            
            if (uploadArea && fileInput) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, preventDefaults, false);
                });
                
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, highlight, false);
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    uploadArea.addEventListener(eventName, unhighlight, false);
                });
                
                function highlight(e) {
                    uploadArea.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20', 'dark:border-indigo-400');
                }
                
                function unhighlight(e) {
                    uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20', 'dark:border-indigo-400');
                }
                
                uploadArea.addEventListener('drop', handleDrop, false);
                
                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    
                    if (files.length > 0) {
                        fileInput.files = files;
                        previewImage(fileInput);
                    }
                }
            }
        });
    </script>
</x-app-layout>
