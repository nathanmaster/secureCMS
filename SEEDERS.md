# Database Seeders Documentation

## Overview

The SecureCMS project includes comprehensive seeders to populate the database with sample data for testing and development purposes.

## Available Seeders

### 1. AdminUserSeeder
Creates admin and demo users with predefined credentials.

**Created Users:**
- System Administrator: `admin@securecms.com` / `admin123`
- Store Manager: `manager@securecms.com` / `manager123`
- Demo User: `demo@securecms.com` / `demo123`

### 2. CategorySeeder
Creates 10 main categories with subcategories:
- Beverages (Coffee, Tea, Soft Drinks, etc.)
- Snacks (Chips, Crackers, Nuts, etc.)
- Bakery (Bread, Pastries, Cakes, etc.)
- Dairy (Milk, Cheese, Yogurt, etc.)
- Meat & Seafood (Beef, Chicken, Fish, etc.)
- Fruits & Vegetables (Fresh, Organic, Frozen, etc.)
- Pantry Essentials (Grains, Pasta, Spices, etc.)
- Frozen Foods (Meals, Pizza, Desserts, etc.)
- Health & Wellness (Vitamins, Supplements, etc.)
- Personal Care (Skincare, Hair Care, etc.)

### 3. SubcategoryWeightsSeeder
Assigns default weight ranges to subcategories based on their names:
- Light/Small categories: 0-100g, 100-250g
- Medium/Regular categories: 100-250g, 250-500g
- Large/Big categories: 250-500g, 500-1000g
- Extra/Jumbo categories: 500-1000g, 1000g+
- Generic categories: All weight ranges

### 4. ProductSeeder
Creates over 80 products including:
- 30+ hand-crafted realistic products with detailed descriptions
- 50+ additional random products using Faker
- Products distributed across all categories and subcategories
- Realistic pricing, weights, and availability status
- Some products marked as unavailable for testing

### 5. ProductRatingSeeder
Adds ratings and comments to products:
- 70% of products receive 1-5 ratings each
- 60% of ratings include comments
- 80% of comments are pre-approved
- Realistic rating distribution and comments

## Running Seeders

### Option 1: Run All Seeders
```bash
php artisan db:seed
```

### Option 2: Run Specific Seeder
```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

### Option 3: Fresh Migration with Seeders
```bash
php artisan migrate:fresh --seed
```

### Option 4: Custom Refresh Command
```bash
php artisan db:refresh-with-seeders
```

## Seeder Execution Order

The seeders must run in the following order due to dependencies:

1. **AdminUserSeeder** - Creates users for ratings/comments
2. **CategorySeeder** - Creates categories and subcategories
3. **SubcategoryWeightsSeeder** - Adds weight ranges to subcategories
4. **ProductSeeder** - Creates products linked to categories
5. **ProductRatingSeeder** - Adds ratings and comments to products

## Database Structure

### Users Table
- Admin and regular users
- Email verification timestamps
- Admin privileges

### Categories Table
- Main product categories
- URL-friendly slugs

### Subcategories Table
- Subcategories linked to categories
- Default weight ranges (JSON field)
- URL-friendly slugs

### Products Table
- Comprehensive product information
- Category and subcategory relationships
- Weight, price, and percentage fields
- Availability status
- Image path support

### Product Ratings Table
- User ratings (1-5 stars)
- One rating per user per product

### Product Comments Table
- User comments/reviews
- Admin approval system
- Linked to ratings

## Development Notes

### Faker Integration
The ProductSeeder uses Faker to generate additional random products, ensuring a rich dataset for testing filtering and search functionality.

### Realistic Data
All seeded data is designed to be realistic and representative of a real e-commerce application, including:
- Appropriate pricing ranges
- Realistic product weights
- Logical category assignments
- Varied availability status

### Testing Scenarios
The seeders create data suitable for testing:
- Search functionality (varied product names and descriptions)
- Filtering by category, subcategory, price, weight, and availability
- Sorting by different criteria
- User authentication and authorization
- Admin approval workflows
- Rating and comment systems

## Configuration

### Customizing Products
To add more products, edit the `$products` array in `ProductSeeder.php`. Each product should include:
- name, description, price, weight, percentage
- category and subcategory names
- availability status

### Customizing Categories
To modify categories, edit the `$categories` array in `CategorySeeder.php`. Each category should include:
- name, slug, and array of subcategory names

### Customizing Weight Ranges
To modify weight assignments, edit the logic in `SubcategoryWeightsSeeder.php`. The system supports:
- Custom weight ranges per subcategory
- Conditional assignments based on subcategory names
- Default fallback for unmatched subcategories

## Troubleshooting

### Foreign Key Constraints
Ensure migrations are run before seeders:
```bash
php artisan migrate:fresh
php artisan db:seed
```

### Missing Dependencies
If seeders fail due to missing models, check:
- All model files exist in `app/Models/`
- Proper namespace imports in seeder files
- Database tables exist (run migrations first)

### Performance
For large datasets, consider:
- Running seeders individually
- Using database transactions
- Increasing PHP memory limit if needed

## Contributing

When adding new seeders:
1. Follow the existing naming conventions
2. Include proper error handling
3. Add informative console output
4. Update this documentation
5. Test with fresh database

## Security Note

**Never run seeders in production!** The seeded data includes default passwords and is intended for development/testing only.
