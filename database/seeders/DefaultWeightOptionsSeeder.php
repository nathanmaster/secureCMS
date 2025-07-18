<?php

namespace Database\Seeders;

use App\Models\DefaultWeightOption;
use Illuminate\Database\Seeder;

class DefaultWeightOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weightOptions = [
            // Set value options (specific weights commonly used in cannabis)
            [
                'value' => 'set-1',
                'label' => '1g',
                'is_set_value' => true,
                'set_weight' => 1.0,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'value' => 'set-3.5',
                'label' => '1/8 (3.5g)',
                'is_set_value' => true,
                'set_weight' => 3.5,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'value' => 'set-7',
                'label' => '1/4 (7g)',
                'is_set_value' => true,
                'set_weight' => 7.0,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'value' => 'set-14',
                'label' => '1/2 (14g)',
                'is_set_value' => true,
                'set_weight' => 14.0,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'value' => 'set-28',
                'label' => '1 oz (28g)',
                'is_set_value' => true,
                'set_weight' => 28.0,
                'sort_order' => 5,
                'is_active' => true,
            ],
            
            // Range options for flexibility
            [
                'value' => '0-100',
                'label' => 'Light (0-100g)',
                'is_set_value' => false,
                'min_weight' => 0,
                'max_weight' => 100,
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'value' => '100-250',
                'label' => 'Small (100-250g)',
                'is_set_value' => false,
                'min_weight' => 100,
                'max_weight' => 250,
                'sort_order' => 11,
                'is_active' => true,
            ],
            [
                'value' => '250-500',
                'label' => 'Medium (250-500g)',
                'is_set_value' => false,
                'min_weight' => 250,
                'max_weight' => 500,
                'sort_order' => 12,
                'is_active' => true,
            ],
            [
                'value' => '500-1000',
                'label' => 'Large (500g-1kg)',
                'is_set_value' => false,
                'min_weight' => 500,
                'max_weight' => 1000,
                'sort_order' => 13,
                'is_active' => true,
            ],
            [
                'value' => '1000+',
                'label' => 'Extra Large (1kg+)',
                'is_set_value' => false,
                'min_weight' => 1000,
                'max_weight' => null,
                'sort_order' => 14,
                'is_active' => true,
            ],
        ];

        foreach ($weightOptions as $option) {
            DefaultWeightOption::firstOrCreate(
                ['value' => $option['value']],
                $option
            );
        }
    }
}
