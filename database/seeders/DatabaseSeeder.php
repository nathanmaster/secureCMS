<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in correct order
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,
            SubcategoryWeightsSeeder::class,
            ProductSeeder::class,
            ProductRatingSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
    }
}
