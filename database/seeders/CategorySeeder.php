<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Beverages',
                'slug' => 'beverages',
                'subcategories' => [
                    'Coffee',
                    'Tea',
                    'Soft Drinks',
                    'Energy Drinks',
                    'Juices',
                    'Water',
                    'Alcoholic Beverages'
                ]
            ],
            [
                'name' => 'Snacks',
                'slug' => 'snacks',
                'subcategories' => [
                    'Chips',
                    'Crackers',
                    'Nuts',
                    'Cookies',
                    'Candy',
                    'Chocolate',
                    'Popcorn'
                ]
            ],
            [
                'name' => 'Bakery',
                'slug' => 'bakery',
                'subcategories' => [
                    'Bread',
                    'Pastries',
                    'Cakes',
                    'Muffins',
                    'Donuts',
                    'Croissants',
                    'Bagels'
                ]
            ],
            [
                'name' => 'Dairy',
                'slug' => 'dairy',
                'subcategories' => [
                    'Milk',
                    'Cheese',
                    'Yogurt',
                    'Butter',
                    'Cream',
                    'Ice Cream',
                    'Eggs'
                ]
            ],
            [
                'name' => 'Meat & Seafood',
                'slug' => 'meat-seafood',
                'subcategories' => [
                    'Beef',
                    'Chicken',
                    'Pork',
                    'Fish',
                    'Shellfish',
                    'Deli Meats',
                    'Sausages'
                ]
            ],
            [
                'name' => 'Fruits & Vegetables',
                'slug' => 'fruits-vegetables',
                'subcategories' => [
                    'Fresh Fruits',
                    'Fresh Vegetables',
                    'Organic Produce',
                    'Frozen Fruit Products',
                    'Frozen Veggie Products',
                    'Dried Fruits',
                    'Canned Vegetables'
                ]
            ],
            [
                'name' => 'Pantry Essentials',
                'slug' => 'pantry-essentials',
                'subcategories' => [
                    'Grains & Rice',
                    'Pasta',
                    'Canned Goods',
                    'Spices & Seasonings',
                    'Oils & Vinegars',
                    'Baking Supplies',
                    'Condiments'
                ]
            ],
            [
                'name' => 'Frozen Foods',
                'slug' => 'frozen-foods',
                'subcategories' => [
                    'Frozen Meals',
                    'Frozen Pizza',
                    'Frozen Vegetables',
                    'Frozen Fruits',
                    'Frozen Ice Cream',
                    'Frozen Desserts',
                    'Frozen Appetizers'
                ]
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'subcategories' => [
                    'Vitamins',
                    'Supplements',
                    'Protein Powders',
                    'Organic Foods',
                    'Gluten-Free',
                    'Keto Products',
                    'Vegan Products'
                ]
            ],
            [
                'name' => 'Personal Care',
                'slug' => 'personal-care',
                'subcategories' => [
                    'Skincare',
                    'Hair Care',
                    'Oral Care',
                    'Body Care',
                    'Deodorants',
                    'Feminine Care',
                    'Men\'s Grooming'
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => $categoryData['slug'],
            ]);

            // Create subcategories with unique slugs
            foreach ($categoryData['subcategories'] as $subcategoryName) {
                $baseSlug = Str::slug($subcategoryName);
                $uniqueSlug = $baseSlug;
                $counter = 1;
                
                // Ensure unique slug by appending counter if needed
                while (Subcategory::where('slug', $uniqueSlug)->exists()) {
                    $uniqueSlug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                Subcategory::create([
                    'name' => $subcategoryName,
                    'slug' => $uniqueSlug,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
