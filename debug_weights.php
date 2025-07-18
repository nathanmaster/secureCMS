<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $defaultWeights = \Illuminate\Support\Facades\DB::table('default_weight_options')->get(['value', 'label']);
    echo "=== Default Weight Options ===\n";
    foreach ($defaultWeights as $weight) {
        echo "Value: " . var_export($weight->value, true) . " (type: " . gettype($weight->value) . ")\n";
        echo "Label: " . var_export($weight->label, true) . "\n";
        echo "---\n";
    }
    
    $productWeights = \Illuminate\Support\Facades\DB::table('products')->whereNotNull('weight')->distinct()->pluck('weight');
    echo "\n=== Product Weights ===\n";
    foreach ($productWeights as $weight) {
        echo "Value: " . var_export($weight, true) . " (type: " . gettype($weight) . ")\n";
    }
    
    $variantWeights = \Illuminate\Support\Facades\DB::table('product_weight_variants')->whereNotNull('custom_weight')->distinct()->pluck('custom_weight');
    echo "\n=== Variant Custom Weights ===\n";
    foreach ($variantWeights as $weight) {
        echo "Value: " . var_export($weight, true) . " (type: " . gettype($weight) . ")\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
