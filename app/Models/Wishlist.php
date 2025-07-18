<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'selected_weight',
        'selected_price',
        'notes',
        'phone_number',
        'status',
        'contacted_at',
    ];

    protected $casts = [
        'selected_price' => 'decimal:2',
        'contacted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the wishlist item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that belongs to the wishlist item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the formatted status.
     */
    public function getFormattedStatusAttribute(): string
    {
        return ucfirst($this->status);
    }

    /**
     * Check if the wishlist item is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the user has been contacted.
     */
    public function isContacted(): bool
    {
        return $this->status === 'contacted';
    }

    /**
     * Check if the wishlist item is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
