<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategoryWeightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all subcategories and add some sample default weights
        $subcategories = Subcategory::all();
        
        $defaultWeightOptions = [
            ['value' => '0-100', 'label' => 'Light (0-100g)'],
            ['value' => '100-250', 'label' => 'Small (100-250g)'],
            ['value' => '250-500', 'label' => 'Medium (250-500g)'],
            ['value' => '500-1000', 'label' => 'Large (500g-1kg)'],
            ['value' => '1000+', 'label' => 'Extra Large (1kg+)'],
        ];
        
        foreach ($subcategories as $subcategory) {
            // Assign random weight ranges based on subcategory name
            $weights = [];
            
            // Logic to assign weights based on subcategory name
            $name = strtolower($subcategory->name);
            
            if (str_contains($name, 'light') || str_contains($name, 'small')) {
                $weights = ['0-100', '100-250'];
            } elseif (str_contains($name, 'medium') || str_contains($name, 'regular')) {
                $weights = ['100-250', '250-500'];
            } elseif (str_contains($name, 'large') || str_contains($name, 'big')) {
                $weights = ['250-500', '500-1000'];
            } elseif (str_contains($name, 'extra') || str_contains($name, 'jumbo')) {
                $weights = ['500-1000', '1000+'];
            } else {
                // Default to all weights for generic subcategories
                $weights = ['0-100', '100-250', '250-500', '500-1000', '1000+'];
            }
            
            $subcategory->update([
                'default_weights' => $weights
            ]);
        }
    }
}
