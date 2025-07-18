<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Try to instantiate the ProductFilterService
    $filterService = $app->make(\App\Services\ProductFilterService::class);
    echo "✓ ProductFilterService instantiated successfully\n";
    
    // Test basic functionality
    $query = \App\Models\Product::query();
    $filters = [
        'search' => 'test',
        'category' => null,
        'subcategory' => null,
        'min_price' => null,
        'max_price' => null,
        'weights' => [],
        'selected_weight' => null,
        'min_percentage' => null,
        'max_percentage' => null,
        'availability' => ['available', 'unavailable'],
    ];
    
    $result = $filterService->applyFilters($query, $filters);
    echo "✓ applyFilters method works correctly\n";
    
    $result = $filterService->applySorting($query, 'name', 'asc', null);
    echo "✓ applySorting method works correctly\n";
    
    echo "All tests passed!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
