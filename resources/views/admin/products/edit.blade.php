<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Product') }}: {{ $product->name }}
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
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $product->name) }}"
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
                                      placeholder="Enter product description...">{{ old('description', $product->description) }}</textarea>
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
                                       value="{{ old('base_price', $product->price) }}"
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
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Weight-Based Pricing</h3>
                                <button type="button" onclick="addWeightVariant()" class="bg-green-500 hover:bg-green-600 dark:hover:bg-green-700 text-white text-sm font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Weight Option
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Configure different prices for different weights. Leave empty to use base price only.</p>
                            
                            <!-- Weight Variants Table -->
                            <div class="overflow-hidden border border-gray-200 dark:border-gray-600 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Weight Option</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Available</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weight-variants-container" class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                        @if($product->weightVariants->count() > 0)
                                            @foreach($product->weightVariants as $index => $variant)
                                                <tr class="weight-variant-item hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="space-y-3">
                                                            <div class="flex items-center space-x-3">
                                                                <label class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="weight_variants[{{ $index }}][type]" value="default" class="text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" onchange="toggleWeightType(this)" {{ $variant->default_weight_option_id ? 'checked' : '' }}>
                                                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Default Option</span>
                                                                </label>
                                                            </div>
                                                            <select name="weight_variants[{{ $index }}][weight_option_id]" class="default-weight-select w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" {{ !$variant->default_weight_option_id ? 'style=display:none;' : '' }}>
                                                                <option value="">Select weight option...</option>
                                                                @foreach($defaultWeightOptions as $option)
                                                                    <option value="{{ $option->id }}" {{ $variant->default_weight_option_id == $option->id ? 'selected' : '' }}>{{ $option->label }}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <div class="flex items-center space-x-3">
                                                                <label class="flex items-center cursor-pointer">
                                                                    <input type="radio" name="weight_variants[{{ $index }}][type]" value="custom" class="text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" onchange="toggleWeightType(this)" {{ $variant->custom_weight ? 'checked' : '' }}>
                                                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Custom Weight</span>
                                                                </label>
                                                            </div>
                                                            <div class="custom-weight-inputs space-y-2 {{ $variant->custom_weight ? '' : 'hidden' }}">
                                                                <input type="number" name="weight_variants[{{ $index }}][custom_weight]" value="{{ $variant->custom_weight }}" placeholder="Weight (g)" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                                                <input type="text" name="weight_variants[{{ $index }}][custom_label]" value="{{ $variant->custom_label }}" placeholder="Label (e.g., 250g)" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="relative">
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 dark:text-gray-400 text-sm">$</span>
                                                            </div>
                                                            <input type="number" name="weight_variants[{{ $index }}][price]" value="{{ $variant->price }}" step="0.01" min="0" required class="block w-full pl-7 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" placeholder="0.00">
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <label class="flex items-center cursor-pointer">
                                                            <input type="hidden" name="weight_variants[{{ $index }}][is_available]" value="0">
                                                            <input type="checkbox" name="weight_variants[{{ $index }}][is_available]" value="1" {{ $variant->is_available ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700">
                                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Available</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <button type="button" onclick="removeWeightVariant(this)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 inline-flex items-center transition-colors duration-200">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                
                                <!-- Empty state -->
                                @if($product->weightVariants->count() === 0)
                                    <div id="weight-variants-empty" class="text-center py-8 bg-white dark:bg-gray-700">
                                        <p class="text-gray-500 dark:text-gray-400">No weight options added yet. Click "Add Weight Option" to get started.</p>
                                    </div>
                                @else
                                    <div id="weight-variants-empty" class="text-center py-8 bg-white dark:bg-gray-700" style="display: none;">
                                        <p class="text-gray-500 dark:text-gray-400">No weight options added yet. Click "Add Weight Option" to get started.</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Template for weight variant (hidden) -->
                            <template id="weight-variant-template">
                                <tr class="weight-variant-item hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="space-y-3">
                                            <div class="flex items-center space-x-3">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="weight_variants[INDEX][type]" value="default" class="text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" onchange="toggleWeightType(this)" checked disabled>
                                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Default Option</span>
                                                </label>
                                            </div>
                                            <select name="weight_variants[INDEX][weight_option_id]" class="default-weight-select w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" disabled>
                                                <option value="">Select weight option...</option>
                                                @foreach($defaultWeightOptions as $option)
                                                    <option value="{{ $option->id }}">{{ $option->label }}</option>
                                                @endforeach
                                            </select>
                                            
                                            <div class="flex items-center space-x-3">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="radio" name="weight_variants[INDEX][type]" value="custom" class="text-blue-600 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600" onchange="toggleWeightType(this)" disabled>
                                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Custom Weight</span>
                                                </label>
                                            </div>
                                            <div class="custom-weight-inputs space-y-2 hidden">
                                                <input type="number" name="weight_variants[INDEX][custom_weight]" placeholder="Weight (g)" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" disabled>
                                                <input type="text" name="weight_variants[INDEX][custom_label]" placeholder="Label (e.g., 250g)" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" disabled>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">$</span>
                                            </div>
                                            <input type="number" name="weight_variants[INDEX][price]" step="0.01" min="0" required class="block w-full pl-7 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm" placeholder="0.00" disabled>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="hidden" name="weight_variants[INDEX][is_available]" value="0">
                                            <input type="checkbox" name="weight_variants[INDEX][is_available]" value="1" checked class="rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 dark:bg-gray-700" disabled>
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Available</span>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" onclick="removeWeightVariant(this)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 inline-flex items-center transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove
                                        </button>
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
                                       value="{{ old('weight', $product->weight) }}"
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
                                       value="{{ old('percentage', $product->percentage) }}"
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
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($product->hasImage())
                            <div id="currentImage">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Current Image
                                </label>
                                <div class="mt-1 relative">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="h-48 w-48 object-cover rounded-lg shadow-md mx-auto">
                                    <div class="mt-2 text-center">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Current product image</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- New Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $product->hasImage() ? 'Replace Image' : 'Product Image' }}
                            </label>
                            
                            <!-- Upload Area -->
                            <div id="uploadArea" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
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
                            
                            <!-- New Image Preview -->
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
                                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">⚠️ This will replace the current image</p>
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
                                   {{ old('is_available', $product->is_available) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_available" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                Product is available for purchase
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let weightVariantIndex = {{ $product->weightVariants->count() }};

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
            
            // Replace INDEX with the current index
            row.innerHTML = row.innerHTML.replace(/INDEX/g, weightVariantIndex);
            
            // Enable all form fields in the clone
            const fields = row.querySelectorAll('input, select');
            fields.forEach(field => {
                field.disabled = false;
            });
            
            // Add the row directly to the container
            container.appendChild(row);
            weightVariantIndex++;
        }

        function removeWeightVariant(button) {
            const row = button.closest('.weight-variant-item');
            const container = document.getElementById('weight-variants-container');
            const emptyState = document.getElementById('weight-variants-empty');
            
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
                defaultSelect.style.display = 'block';
                customInputs.classList.add('hidden');
                defaultSelect.required = true;
                customInputs.querySelectorAll('input').forEach(input => {
                    input.required = false;
                    input.value = ''; // Clear custom values
                });
            } else {
                defaultSelect.style.display = 'none';
                customInputs.classList.remove('hidden');
                defaultSelect.required = false;
                defaultSelect.value = ''; // Clear default selection
                customInputs.querySelector('input[type="number"]').required = true;
                customInputs.querySelector('input[type="text"]').required = true;
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            const currentImage = document.getElementById('currentImage');
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
                    
                    // Hide upload area and current image, show preview
                    uploadArea.classList.add('hidden');
                    if (currentImage) {
                        currentImage.style.opacity = '0.5';
                    }
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
            const currentImage = document.getElementById('currentImage');
            
            previewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            if (currentImage) {
                currentImage.style.opacity = '1';
            }
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
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('image');
            
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
                uploadArea.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
            }
            
            function unhighlight(e) {
                uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
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
        });
    </script>
</x-app-layout>
