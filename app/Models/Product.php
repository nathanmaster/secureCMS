<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'is_available',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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
     * Get the full URL to the product image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Check if the product has an image.
     */
    public function hasImage(): bool
    {
        return $this->image_path && Storage::disk('public')->exists($this->image_path);
    }

    /**
     * Get a default image URL if no image exists.
     */
    public function getImageOrDefaultAttribute(): string
    {
        return $this->image_url ?? asset('images/product-placeholder.svg');
    }
}
