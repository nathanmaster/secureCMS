<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductRating;
use App\Models\ProductComment;
use Faker\Factory as Faker;

class ProductRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        $products = Product::all();

        if ($users->count() === 0 || $products->count() === 0) {
            $this->command->warn('No users or products found. Skipping rating seeder.');
            return;
        }

        // Create ratings for about 70% of products
        $productsToRate = $products->count() > 0 ? 
            $products->random(max(1, intval($products->count() * 0.7))) : 
            collect();

        foreach ($productsToRate as $product) {
            // Each product gets 1-5 ratings, but not more than available users
            $maxRatings = min(5, $users->count());
            $ratingsCount = $faker->numberBetween(1, $maxRatings);
            $usersForProduct = $users->random($ratingsCount);

            foreach ($usersForProduct as $user) {
                $rating = $faker->numberBetween(1, 5);
                
                // Create rating
                ProductRating::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => $rating,
                ]);

                // 60% chance of also leaving a comment
                if ($faker->boolean(60)) {
                    $comments = [
                        'Great product! Highly recommend.',
                        'Good value for money.',
                        'Excellent quality and fast delivery.',
                        'Not bad, but could be better.',
                        'Amazing taste and freshness!',
                        'Perfect for my needs.',
                        'Will definitely buy again.',
                        'Good product, prompt service.',
                        'Exceeded my expectations.',
                        'Decent quality for the price.',
                        'Fresh and delicious!',
                        'Exactly what I was looking for.',
                        'High quality ingredients.',
                        'Fast shipping and good packaging.',
                        'Really satisfied with this purchase.',
                        'Could use some improvement.',
                        'Outstanding product quality.',
                        'Perfect portion size.',
                        'Great flavor and texture.',
                        'Reasonable price point.',
                        'Would recommend to friends.',
                        'Consistent quality every time.',
                        'Innovative and useful product.',
                        'Exceeded all expectations.',
                        'Really good value.',
                    ];

                    ProductComment::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'comment' => $faker->randomElement($comments),
                        'is_approved' => $faker->boolean(80), // 80% chance of being approved
                    ]);
                }
            }
        }

        $this->command->info('Product ratings and comments seeded successfully!');
    }
}
