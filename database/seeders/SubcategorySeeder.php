<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get existing categories
        $beverages = Category::where('name', 'Beverages')->first();
        $food = Category::where('name', 'Food')->first();
        $desserts = Category::where('name', 'Desserts')->first();

        // Create subcategories for Beverages
        if ($beverages) {
            Subcategory::create([
                'name' => 'Hot Drinks',
                'slug' => 'hot-drinks',
                'category_id' => $beverages->id,
            ]);

            Subcategory::create([
                'name' => 'Cold Drinks',
                'slug' => 'cold-drinks',
                'category_id' => $beverages->id,
            ]);

            Subcategory::create([
                'name' => 'Alcoholic',
                'slug' => 'alcoholic',
                'category_id' => $beverages->id,
            ]);
        }

        // Create subcategories for Food
        if ($food) {
            Subcategory::create([
                'name' => 'Appetizers',
                'slug' => 'appetizers',
                'category_id' => $food->id,
            ]);

            Subcategory::create([
                'name' => 'Main Courses',
                'slug' => 'main-courses',
                'category_id' => $food->id,
            ]);

            Subcategory::create([
                'name' => 'Sandwiches',
                'slug' => 'sandwiches',
                'category_id' => $food->id,
            ]);
        }

        // Create subcategories for Desserts
        if ($desserts) {
            Subcategory::create([
                'name' => 'Cakes',
                'slug' => 'cakes',
                'category_id' => $desserts->id,
            ]);

            Subcategory::create([
                'name' => 'Ice Cream',
                'slug' => 'ice-cream',
                'category_id' => $desserts->id,
            ]);

            Subcategory::create([
                'name' => 'Pastries',
                'slug' => 'pastries',
                'category_id' => $desserts->id,
            ]);
        }
    }
}
