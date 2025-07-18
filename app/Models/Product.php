<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'weight',
        'percentage',
        'image_path',
        'is_available',
        'category_id',
        'subcategory_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'percentage' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory that owns the product.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Get the comments for the product.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ProductComment::class);
    }

    /**
     * Get the approved comments for the product.
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(ProductComment::class)->where('is_approved', true);
    }

    /**
     * Get the ratings for the product.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(ProductRating::class);
    }

    /**
     * Get the weight variants for the product.
     */
    public function weightVariants(): HasMany
    {
        return $this->hasMany(ProductWeightVariant::class);
    }

    /**
     * Get available weight variants for the product.
     */
    public function availableWeightVariants(): HasMany
    {
        return $this->hasMany(ProductWeightVariant::class)->where('is_available', true);
    }

    /**
     * Get the full URL to the product image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        return asset('storage/' . $this->image_path);
    }

    /**
     * Check if the product has an image.
     */
    public function hasImage(): bool
    {
        return $this->image_path && file_exists(storage_path('app/public/' . $this->image_path));
    }

    /**
     * Get a default image URL if no image exists.
     */
    public function getImageOrDefaultAttribute(): string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/product-placeholder.svg');
    }

    /**
     * Get the average rating for the product.
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    /**
     * Get the total number of ratings for the product.
     */
    public function getRatingsCountAttribute(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Get the formatted weight with unit.
     */
    public function getFormattedWeightAttribute(): string
    {
        if (!$this->weight) {
            return 'N/A';
        }
        
        if ($this->weight >= 1000) {
            return number_format($this->weight / 1000, 2) . ' kg';
        }
        
        return number_format($this->weight, 0) . ' g';
    }

    /**
     * Get the formatted percentage with unit.
     */
    public function getFormattedPercentageAttribute(): string
    {
        if (!$this->percentage) {
            return 'N/A';
        }
        
        return number_format($this->percentage, 1) . '%';
    }

    /**
     * Get the base price (lowest price among variants or fallback to main price).
     */
    public function getBasePriceAttribute(): float
    {
        $lowestVariantPrice = $this->availableWeightVariants()->min('price');
        
        if ($lowestVariantPrice !== null) {
            return $lowestVariantPrice;
        }
        
        return $this->price;
    }

    /**
     * Get price range display for products with multiple variants.
     */
    public function getPriceRangeAttribute(): string
    {
        $variants = $this->availableWeightVariants;
        
        if ($variants->isEmpty()) {
            return '$' . number_format($this->price, 2);
        }
        
        $minPrice = $variants->min('price');
        $maxPrice = $variants->max('price');
        
        if ($minPrice == $maxPrice) {
            return '$' . number_format($minPrice, 2);
        }
        
        return '$' . number_format($minPrice, 2) . ' - $' . number_format($maxPrice, 2);
    }

    /**
     * Check if product has multiple weight options
     */
    public function hasMultipleWeights(): bool
    {
        $baseWeightCount = $this->weight ? 1 : 0;
        $variantCount = $this->weightVariants()->count();
        return ($baseWeightCount + $variantCount) > 1;
    }

    /**
     * Get display price based on current context
     */
    public function getDisplayPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get available weight options for this product.
     */
    public function getAvailableWeightOptionsAttribute()
    {
        return $this->availableWeightVariants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'label' => $variant->effective_label,
                'price' => $variant->price,
                'formatted_price' => '$' . number_format($variant->price, 2),
                'weight' => $variant->effective_weight,
                'formatted_weight' => $variant->formatted_weight,
            ];
        });
    }
}
