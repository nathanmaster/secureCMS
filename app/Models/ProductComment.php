<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductComment extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the product that owns the comment.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rating for this comment (same user and product).
     */
    public function rating(): BelongsTo
    {
        return $this->belongsTo(ProductRating::class, 'user_id', 'user_id')
            ->where('product_id', $this->product_id);
    }

    /**
     * Get the rating value for this comment.
     */
    public function getRatingValueAttribute(): ?int
    {
        $rating = ProductRating::where('product_id', $this->product_id)
            ->where('user_id', $this->user_id)
            ->first();
        
        return $rating ? $rating->rating : null;
    }
}
