<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $products = [
            // Beverages
            [
                'name' => 'Premium Colombian Coffee',
                'description' => 'Rich, full-bodied coffee with hints of chocolate and caramel',
                'price' => 12.99,
                'weight' => 340,
                'percentage' => 100,
                'category' => 'Beverages',
                'subcategory' => 'Coffee',
                'is_available' => true,
            ],
            [
                'name' => 'Earl Grey Tea',
                'description' => 'Classic black tea with bergamot oil and cornflower petals',
                'price' => 8.99,
                'weight' => 100,
                'percentage' => 100,
                'category' => 'Beverages',
                'subcategory' => 'Tea',
                'is_available' => true,
            ],
            [
                'name' => 'Artisan Cola',
                'description' => 'Handcrafted cola with natural ingredients and cane sugar',
                'price' => 2.99,
                'weight' => 355,
                'percentage' => null,
                'category' => 'Beverages',
                'subcategory' => 'Soft Drinks',
                'is_available' => true,
            ],
            [
                'name' => 'Energy Boost Pro',
                'description' => 'High-performance energy drink with vitamins and amino acids',
                'price' => 3.49,
                'weight' => 250,
                'percentage' => null,
                'category' => 'Beverages',
                'subcategory' => 'Energy Drinks',
                'is_available' => true,
            ],
            [
                'name' => 'Fresh Orange Juice',
                'description' => 'Freshly squeezed orange juice with no added preservatives',
                'price' => 4.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Beverages',
                'subcategory' => 'Juices',
                'is_available' => true,
            ],

            // Snacks
            [
                'name' => 'Kettle Cooked Chips',
                'description' => 'Crispy potato chips cooked in small batches with sea salt',
                'price' => 3.99,
                'weight' => 142,
                'percentage' => null,
                'category' => 'Snacks',
                'subcategory' => 'Chips',
                'is_available' => true,
            ],
            [
                'name' => 'Whole Grain Crackers',
                'description' => 'Healthy crackers made with whole grains and seeds',
                'price' => 4.49,
                'weight' => 200,
                'percentage' => null,
                'category' => 'Snacks',
                'subcategory' => 'Crackers',
                'is_available' => true,
            ],
            [
                'name' => 'Mixed Nuts Premium',
                'description' => 'Premium mix of almonds, cashews, walnuts, and pecans',
                'price' => 9.99,
                'weight' => 300,
                'percentage' => null,
                'category' => 'Snacks',
                'subcategory' => 'Nuts',
                'is_available' => true,
            ],
            [
                'name' => 'Chocolate Chip Cookies',
                'description' => 'Homestyle chocolate chip cookies with real chocolate chunks',
                'price' => 5.99,
                'weight' => 400,
                'percentage' => null,
                'category' => 'Snacks',
                'subcategory' => 'Cookies',
                'is_available' => true,
            ],
            [
                'name' => 'Dark Chocolate Bar',
                'description' => 'Rich dark chocolate bar with 70% cocoa content',
                'price' => 4.99,
                'weight' => 100,
                'percentage' => 70,
                'category' => 'Snacks',
                'subcategory' => 'Chocolate',
                'is_available' => true,
            ],

            // Bakery
            [
                'name' => 'Artisan Sourdough Bread',
                'description' => 'Traditional sourdough bread with crispy crust and tangy flavor',
                'price' => 6.99,
                'weight' => 800,
                'percentage' => null,
                'category' => 'Bakery',
                'subcategory' => 'Bread',
                'is_available' => true,
            ],
            [
                'name' => 'Butter Croissant',
                'description' => 'Flaky, buttery croissant made with French butter',
                'price' => 2.99,
                'weight' => 80,
                'percentage' => null,
                'category' => 'Bakery',
                'subcategory' => 'Croissants',
                'is_available' => true,
            ],
            [
                'name' => 'Blueberry Muffin',
                'description' => 'Moist muffin packed with fresh blueberries',
                'price' => 3.49,
                'weight' => 120,
                'percentage' => null,
                'category' => 'Bakery',
                'subcategory' => 'Muffins',
                'is_available' => true,
            ],
            [
                'name' => 'Chocolate Cake Slice',
                'description' => 'Decadent chocolate cake with rich chocolate frosting',
                'price' => 4.99,
                'weight' => 150,
                'percentage' => null,
                'category' => 'Bakery',
                'subcategory' => 'Cakes',
                'is_available' => false,
            ],

            // Dairy
            [
                'name' => 'Organic Whole Milk',
                'description' => 'Fresh organic milk from grass-fed cows',
                'price' => 5.99,
                'weight' => 1000,
                'percentage' => null,
                'category' => 'Dairy',
                'subcategory' => 'Milk',
                'is_available' => true,
            ],
            [
                'name' => 'Aged Cheddar Cheese',
                'description' => 'Sharp cheddar cheese aged for 12 months',
                'price' => 8.99,
                'weight' => 250,
                'percentage' => null,
                'category' => 'Dairy',
                'subcategory' => 'Cheese',
                'is_available' => true,
            ],
            [
                'name' => 'Greek Yogurt',
                'description' => 'Thick, creamy Greek yogurt with live cultures',
                'price' => 4.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Dairy',
                'subcategory' => 'Yogurt',
                'is_available' => true,
            ],
            [
                'name' => 'Vanilla Ice Cream',
                'description' => 'Premium vanilla ice cream made with real vanilla beans',
                'price' => 6.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Dairy',
                'subcategory' => 'Ice Cream',
                'is_available' => true,
            ],

            // Meat & Seafood
            [
                'name' => 'Grass-Fed Beef Steak',
                'description' => 'Premium grass-fed ribeye steak, perfectly marbled',
                'price' => 24.99,
                'weight' => 300,
                'percentage' => null,
                'category' => 'Meat & Seafood',
                'subcategory' => 'Beef',
                'is_available' => true,
            ],
            [
                'name' => 'Free-Range Chicken Breast',
                'description' => 'Tender chicken breast from free-range chickens',
                'price' => 12.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Meat & Seafood',
                'subcategory' => 'Chicken',
                'is_available' => true,
            ],
            [
                'name' => 'Atlantic Salmon Fillet',
                'description' => 'Fresh Atlantic salmon fillet, rich in omega-3',
                'price' => 18.99,
                'weight' => 400,
                'percentage' => null,
                'category' => 'Meat & Seafood',
                'subcategory' => 'Fish',
                'is_available' => true,
            ],

            // Fruits & Vegetables
            [
                'name' => 'Organic Bananas',
                'description' => 'Sweet, ripe organic bananas perfect for snacking',
                'price' => 2.99,
                'weight' => 1000,
                'percentage' => null,
                'category' => 'Fruits & Vegetables',
                'subcategory' => 'Fresh Fruits',
                'is_available' => true,
            ],
            [
                'name' => 'Fresh Spinach',
                'description' => 'Crisp, fresh spinach leaves perfect for salads',
                'price' => 3.99,
                'weight' => 200,
                'percentage' => null,
                'category' => 'Fruits & Vegetables',
                'subcategory' => 'Fresh Vegetables',
                'is_available' => true,
            ],
            [
                'name' => 'Organic Apples',
                'description' => 'Crisp, sweet organic apples grown without pesticides',
                'price' => 4.99,
                'weight' => 800,
                'percentage' => null,
                'category' => 'Fruits & Vegetables',
                'subcategory' => 'Organic Produce',
                'is_available' => true,
            ],

            // Pantry Essentials
            [
                'name' => 'Basmati Rice',
                'description' => 'Premium long-grain basmati rice with aromatic fragrance',
                'price' => 7.99,
                'weight' => 1000,
                'percentage' => null,
                'category' => 'Pantry Essentials',
                'subcategory' => 'Grains & Rice',
                'is_available' => true,
            ],
            [
                'name' => 'Whole Wheat Pasta',
                'description' => 'Nutritious whole wheat pasta made from durum wheat',
                'price' => 3.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Pantry Essentials',
                'subcategory' => 'Pasta',
                'is_available' => true,
            ],
            [
                'name' => 'Extra Virgin Olive Oil',
                'description' => 'Cold-pressed extra virgin olive oil from Mediterranean olives',
                'price' => 12.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Pantry Essentials',
                'subcategory' => 'Oils & Vinegars',
                'is_available' => true,
            ],

            // Health & Wellness
            [
                'name' => 'Whey Protein Powder',
                'description' => 'High-quality whey protein powder for muscle building',
                'price' => 29.99,
                'weight' => 1000,
                'percentage' => 80,
                'category' => 'Health & Wellness',
                'subcategory' => 'Protein Powders',
                'is_available' => true,
            ],
            [
                'name' => 'Vitamin D3 Supplements',
                'description' => 'High-potency vitamin D3 supplements for bone health',
                'price' => 19.99,
                'weight' => 100,
                'percentage' => null,
                'category' => 'Health & Wellness',
                'subcategory' => 'Vitamins',
                'is_available' => true,
            ],
            [
                'name' => 'Organic Quinoa',
                'description' => 'Complete protein grain perfect for healthy meals',
                'price' => 9.99,
                'weight' => 500,
                'percentage' => null,
                'category' => 'Health & Wellness',
                'subcategory' => 'Organic Foods',
                'is_available' => true,
            ],

            // Personal Care
            [
                'name' => 'Moisturizing Face Cream',
                'description' => 'Hydrating face cream with hyaluronic acid and vitamins',
                'price' => 24.99,
                'weight' => 50,
                'percentage' => null,
                'category' => 'Personal Care',
                'subcategory' => 'Skincare',
                'is_available' => true,
            ],
            [
                'name' => 'Natural Shampoo',
                'description' => 'Sulfate-free shampoo with natural ingredients',
                'price' => 14.99,
                'weight' => 400,
                'percentage' => null,
                'category' => 'Personal Care',
                'subcategory' => 'Hair Care',
                'is_available' => true,
            ],
            [
                'name' => 'Whitening Toothpaste',
                'description' => 'Advanced whitening toothpaste with fluoride protection',
                'price' => 6.99,
                'weight' => 100,
                'percentage' => null,
                'category' => 'Personal Care',
                'subcategory' => 'Oral Care',
                'is_available' => true,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            $subcategory = null;
            
            if ($category && $productData['subcategory']) {
                $subcategory = Subcategory::where('name', $productData['subcategory'])
                    ->where('category_id', $category->id)
                    ->first();
            }

            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'weight' => $productData['weight'],
                'percentage' => $productData['percentage'],
                'category_id' => $category ? $category->id : null,
                'subcategory_id' => $subcategory ? $subcategory->id : null,
                'is_available' => $productData['is_available'],
            ]);
        }

        // Add some additional random products using faker
        $categories = Category::with('subcategories')->get();
        
        for ($i = 0; $i < 50; $i++) {
            $category = $categories->random();
            $subcategory = $category->subcategories->random();
            
            Product::create([
                'name' => $faker->words(3, true),
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 1, 100),
                'weight' => $faker->randomElement([50, 100, 150, 200, 250, 300, 400, 500, 750, 1000, 1500, 2000]),
                'percentage' => $faker->optional(0.3)->randomElement([10, 20, 30, 40, 50, 60, 70, 80, 90, 100]),
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'is_available' => $faker->boolean(85), // 85% chance of being available
            ]);
        }
    }
}
